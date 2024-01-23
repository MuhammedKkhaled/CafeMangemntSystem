<?php
session_start();

// echo "<pre>";
// print_r($_POST);
// exit;

require_once("../DB/db_config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!empty($_POST)) {



        ///Query parameters variables 
        $orderid = $_GET['orderid'];
        $session_id = $_GET['session_id'];
        $old_price = $_GET['old_price'];

        /// For Cafe Products and Qunatites
        $additionalCafeProducts = isset($_POST['additionalProduct']) ? $_POST['additionalProduct'] : [];
        $additionalCafeQuantities = isset($_POST['additionalQuantity']) ? $_POST['additionalQuantity'] : [];


        ///For Food Products And Quantites
        $additionalFoodProducts = isset($_POST['additionalfoodproducts']) ? $_POST['additionalfoodproducts'] : [];
        $additionalFoodQuantites = isset($_POST['additionalFoodQuantity']) ? $_POST['additionalFoodQuantity'] : [];


        try {



            /// Begin SQL Transaction
            mysqli_begin_transaction($conn);

            // Insert data into cafe_products_orders table cafe products 
            if (!empty($additionalCafeProducts)) {
                $insertAdditionalCafeProducts = "INSERT INTO `playstation_product_order` (`playstation_session_id`,`cafe_product_id`,`qunatity`,`each_price`,`total_price`)
                                                                                    VALUES(?,?,?,?,?)";
                $stmtAdditionalCafe = mysqli_prepare($conn, $insertAdditionalCafeProducts);
                for ($i = 0; $i < count($additionalCafeProducts); ++$i) {
                    $additionalCafeProductPrice = calculateProductPrice($additionalCafeProducts[$i], 'cafe_products', 'product_price');
                    $totalAdditionalPrice = $additionalCafeProductPrice * $additionalCafeQuantities[$i];
                    mysqli_stmt_bind_param($stmtAdditionalCafe, 'iiidd', $session_id, $additionalCafeProducts[$i], $additionalCafeQuantities[$i], $additionalCafeProductPrice, $totalAdditionalPrice);
                    mysqli_stmt_execute($stmtAdditionalCafe);
                }
            }

            ///Insert Data Into Cafe_products_orders (Food Products)
            if (!empty($additionalFoodProducts)) {
                $insertAdditionalFoodProducts = "INSERT INTO `playstation_product_order` (`playstation_session_id`,`foodcar_product_id`,`qunatity`,`each_price`,`total_price`)
                VALUES(?,?,?,?,?)";
                $stmtAdditionalFood = mysqli_prepare($conn, $insertAdditionalFoodProducts);

                for ($i = 0; $i < count($additionalFoodProducts); ++$i) {
                    $additionalFoodProductPrice = calculateProductPrice($additionalFoodProducts[$i], 'foodcar_products');
                    $totalFoodPrice = $additionalFoodProductPrice * $additionalFoodQuantites[$i];
                    mysqli_stmt_bind_param($stmtAdditionalFood, "iiidd", $session_id, $additionalFoodProducts[$i], $additionalFoodQuantites[$i], $additionalFoodProductPrice, $totalFoodPrice);
                    mysqli_stmt_execute($stmtAdditionalFood);
                }
            }


            // Calculate the total order price
            $totalOrderPrice = calculateTotalOrderPrice($session_id);

            // Update the playstation_orders table with the total order price
            $updateOrderPriceQuery = "UPDATE `playstation_orders` SET `order_price` = ? WHERE `id` = ?";
            $stmtUpdateOrderPrice = mysqli_prepare($conn, $updateOrderPriceQuery);
            mysqli_stmt_bind_param($stmtUpdateOrderPrice, 'di', $totalOrderPrice, $orderid);
            mysqli_stmt_execute($stmtUpdateOrderPrice);



            mysqli_commit($conn);

            header("Location: ../all_playstation_order.php");
            exit();
        } catch (Exception $e) {
            mysqli_rollback($conn);
            echo "Error :" . $e->getMessage();
        } finally {
            mysqli_close($conn);
        }
    } else {

        $_SESSION['error_message'] = "لا تنسي اختيار احد المنتجات وغسيل اسنانك صباحا";
        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    }
} else {
    header("Location: ../all_playstation_order.php");
    exit;
}

function calculateProductPrice($productID, $table, $column = "food_price")
{
    global $conn;

    $query = "SELECT $column FROM $table WHERE id = '$productID'";

    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_array($result);

    return $row[0];
}

function calculateTotalOrderPrice($session_id)
{
    global $conn;

    $totalOrderPriceQuery = "SELECT SUM(total_price) as order_price FROM `playstation_product_order` WHERE `playstation_session_id` = ?";
    $stmtTotalOrderPrice = mysqli_prepare($conn, $totalOrderPriceQuery);
    mysqli_stmt_bind_param($stmtTotalOrderPrice, 'i', $session_id);
    mysqli_stmt_execute($stmtTotalOrderPrice);

    $result = mysqli_stmt_get_result($stmtTotalOrderPrice);
    $row = mysqli_fetch_assoc($result);

    return $row['order_price'];
}
