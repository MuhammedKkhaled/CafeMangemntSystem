<?php
session_start();

// Database Configuration Included
require_once("../DB/db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_SESSION['user_id'];


    /// Validate (Required Data)

    if (!empty($_POST['playstationproduct']) && !empty($_POST['playstationControllerType'])) {
        // Main product data
        $mainPlaystationProduct = $_POST["playstationproduct"];
        $mainControllerType = $_POST["playstationControllerType"];

        /// Get the base price for those confgurations
        $selectQuery = "SELECT price_per_hour FROM `playstation_configuration` WHERE `playstation_type` ='$mainPlaystationProduct' AND `controllers_type` = '$mainControllerType' ";
        $result = mysqli_query($conn, $selectQuery);
        $row = mysqli_fetch_assoc($result);
        $base_price = $row['price_per_hour'];
    } else {
        // Empty data have been sent 
        $_SESSION['error_message'] = "لا تنسي اختيار نوع الجهاز وعدد اللاعبين ";
        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    }


    // Additional cafe  products data (if available)
    $additionalProductsForCafe = isset($_POST["additionalProduct"]) ? $_POST["additionalProduct"] : [];
    $additionalQuantitiesForCafe = isset($_POST["additionalQuantity"]) ? $_POST["additionalQuantity"] : [];




    // Additional food  products data (if available)
    $additionalProductsForFood = isset($_POST["additionalfoodproducts"]) ? $_POST["additionalfoodproducts"] : [];
    $additionalQuantitiesForFood = isset($_POST["additionalFoodQuantity"]) ? $_POST["additionalFoodQuantity"] : [];


    try {


        // Begin transaction
        mysqli_begin_transaction($conn);

        /// Insert in playstation_session to start the session and get the last inserted id   
        $insertQuery = "INSERT into `playstation_session` (`start_time` , `controllers_type` ,`playstation_type` , `base_price_for_this_confgurations`) 
                                                        VALUES(NOW() , ? , ? , ?)
        ";
        $stmtOrder = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($stmtOrder, 'ssi',  $mainControllerType, $mainPlaystationProduct, $base_price);
        mysqli_stmt_execute($stmtOrder);
        $lastInsertedSessionId = mysqli_insert_id($conn);

        // Insert data into cafe_products_orders table cafe products 

        if (!empty($additionalProductsForCafe)) {
            $insertAdditionalCafeProducts = "INSERT INTO `playstation_product_order` (`playstation_session_id`,`cafe_product_id`,`qunatity`,`each_price`,`total_price`)
                                                                                    VALUES(?,?,?,?,?)
            ";
            $stmtAdditionalCafe = mysqli_prepare($conn, $insertAdditionalCafeProducts);
            for ($i = 0; $i < count($additionalProductsForCafe); $i++) {
                $additionalCafeProductPrice = calculateProductPrice($additionalProductsForCafe[$i], 'cafe_products', 'product_price');
                $totalAdditionalPrice = $additionalCafeProductPrice * $additionalQuantitiesForCafe[$i];
                mysqli_stmt_bind_param($stmtAdditionalCafe, 'iiidd', $lastInsertedSessionId, $additionalProductsForCafe[$i], $additionalQuantitiesForCafe[$i], $additionalCafeProductPrice, $totalAdditionalPrice);
                mysqli_stmt_execute($stmtAdditionalCafe);
            }
        }

        // Insert data into cafe_products_orders table Food  products 
        if (!empty($additionalProductsForFood)) {
            $insertAdditionalFoodProducts = "INSERT INTO `playstation_product_order` (`playstation_session_id` ,`foodcar_product_id`,`qunatity`, `each_price`, `total_price`)
                                                                                VALUES(?,?,?,?,?)
            ";
            $stmtAdditionalCafe = mysqli_prepare($conn, $insertAdditionalFoodProducts);
            for ($i = 0; $i < count($additionalProductsForFood); $i++) {
                $additionalFoodProductPrice = calculateProductPrice($additionalProductsForFood[$i], 'foodcar_products');
                $totalAdditionalPrice = $additionalFoodProductPrice * $additionalQuantitiesForFood[$i];
                mysqli_stmt_bind_param($stmtAdditionalCafe, 'iiidd', $lastInsertedSessionId, $additionalProductsForFood[$i], $additionalQuantitiesForFood[$i], $additionalFoodProductPrice, $totalAdditionalPrice);
                mysqli_stmt_execute($stmtAdditionalCafe);
            }
        }

        //// After committing, calculate the total order price for the last inserted session ID
        if (!empty($additionalProductsForFood) || !empty($additionalProductsForCafe)) {


            $totalOrderPrice = calculateTotalOrderPriceForSession($lastInsertedSessionId);
           
            // Insert a new record into playstation_orders table with the total order price
            $insertOrderQuery = "INSERT INTO `playstation_orders` (`playstation_session_id`, `order_price` , `user_id` ) VALUES (?, ?, ?)";
            $stmtInsertOrder = mysqli_prepare($conn, $insertOrderQuery);
            mysqli_stmt_bind_param($stmtInsertOrder, 'idi', $lastInsertedSessionId, $totalOrderPrice, $user_id);
            mysqli_stmt_execute($stmtInsertOrder);
        } elseif (empty($additionalProductsForFood) && empty($additionalProductsForCafe)) {

            $insertOrderQuery = "INSERT INTO `playstation_orders` (`playstation_session_id`, `user_id` ,`order_price`  ) VALUES (? , ?, 0)";
            $stmtInsertOrder = mysqli_prepare($conn, $insertOrderQuery);
            mysqli_stmt_bind_param($stmtInsertOrder, 'ii', $lastInsertedSessionId, $user_id);
            mysqli_stmt_execute($stmtInsertOrder);
        }

        mysqli_commit($conn);


        // echo "Order added successfully!";
        header("Location: ../playstaion.php");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction in case of an error occuired
        mysqli_rollback($conn);
        echo "Error: " . $e->getMessage();
    } finally {
            mysqli_close($conn);
    }
} else {
    header("Location: ../index.php");
    exit();
}

// Function to calculate the total order price
function calculateTotalOrderPrice($mainProductID, $mainQuantity, $additionalProducts, $additionalQuantities)
{
    $totalPrice = calculateProductPrice($mainProductID) * $mainQuantity;

    foreach ($additionalProducts as $index => $additionalProduct) {
        $additionalProductPrice = calculateProductPrice($additionalProduct);
        $totalPrice += ($additionalProductPrice * $additionalQuantities[$index]);
    }

    return $totalPrice;
}

// Function to calculate the price of a product (you can replace this with your actual pricing logic)
function calculateProductPrice($productID, $table, $column = "food_price")
{
    global $conn;

    $query = "SELECT $column FROM $table WHERE id = '$productID'";

    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_array($result);

    return $row[0];
}

function calculateTotalOrderPriceWithoutPlaystationSession($additionalProductsForCafe, $additionalProductsForFood)
{
    global $conn;

    /// calculate Cafe Orders if Exist
}

// Function to calculate the total order price for a specific session ID
function calculateTotalOrderPriceForSession($sessionId)
{
    global $conn;

    $query = "SELECT SUM(total_price) FROM `playstation_product_order` WHERE `playstation_session_id` = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $sessionId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $totalOrderPrice);
    mysqli_stmt_fetch($stmt);

    return $totalOrderPrice;
}
