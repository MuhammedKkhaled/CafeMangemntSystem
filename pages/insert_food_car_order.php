<?php
session_start();

// Database Configuration Included
require_once("../DB/db_config.php");
require_once("../functions/dd.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // dd($_POST);

    /// Validate (Required Data)

    // Additional Cafe products data (if available)
    $additionalCafeProducts = isset($_POST["additionalCafeProduct"]) ? $_POST["additionalCafeProduct"] : [];
    $additionalCafeQuantities = isset($_POST["additionalCafeQuantity"]) ? $_POST["additionalCafeQuantity"] : [];

    // Additional Food products data (if available)
    $additionalFoodProducts = isset($_POST["additionalFoodProduct"]) ? $_POST["additionalFoodProduct"] : [];
    $additionalFoodQuantities = isset($_POST["additionalFoodQuantity"]) ? $_POST["additionalFoodQuantity"] : [];

    if (!empty($_POST['table']) && $_POST['table'] != 0 && (!empty($additionalCafeProducts) || !empty($additionalFoodProducts))) {
        // Main product data
        $table_id = $_POST['table'];
    } else {
        // Empty data have been sent 
        $_SESSION['error_message'] = "لا تنسى اختيار الطاولة ";
        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    }




    try {


        // Begin transaction
        mysqli_begin_transaction($conn);

        // Insert data into cafe_orders table
        $insertOrderSQL = "INSERT INTO food_orders (total_price, user_id , table_id) VALUES (?, ? ,?)";
        $stmtOrder = mysqli_prepare($conn, $insertOrderSQL);
        $totalOrderPriceForCafe = calculateTotalOrderPriceCafeProducts($additionalCafeProducts, $additionalCafeQuantities);
        $totalOrderPriceForFood = calculateTotalOrderPriceFoodProducts($additionalFoodProducts, $additionalFoodQuantities);
        $totalOrderPrice = $totalOrderPriceForCafe + $totalOrderPriceForFood;
        $userID = $_SESSION['user_id'];
        mysqli_stmt_bind_param($stmtOrder, 'dii', $totalOrderPrice, $userID, $table_id);
        mysqli_stmt_execute($stmtOrder);
        $foodOrderID = mysqli_insert_id($conn); // Get the last inserted ID


        //// Update the Table is_available column 
        $query = "UPDATE tables SET `is_available` = 0 WHERE `id` = ?";
        $stmtUpdate = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmtUpdate, "i", $table_id);
        mysqli_stmt_execute($stmtUpdate);

        // // Insert data into cafe_products_orders table for the main product
        // $insertMainProductSQL = "INSERT INTO food_products_order (food_order_id, food_product_id, quantity, each_price, total_price) VALUES (?, ?, ?, ?, ?)";
        // $stmtMainProduct = mysqli_prepare($conn, $insertMainProductSQL);
        // $mainProductPrice = calculateProductPrice($mainProductID);
        // $total_price = $mainProductPrice * $mainQuantity;
        // mysqli_stmt_bind_param($stmtMainProduct, 'iiidd', $foodOrderID, $mainProductID, $mainQuantity, $mainProductPrice,  $total_price);
        // mysqli_stmt_execute($stmtMainProduct);

        // Insert data into cafe_products_orders table for additional products (if available)
        if (!empty($additionalCafeProducts)) {
            $insertAdditionalProductSQL = "INSERT INTO food_products_order (food_order_id, cafe_product_id, quantity, each_price, total_price) VALUES (?, ?, ?, ?, ?)";
            $stmtAdditionalProduct = mysqli_prepare($conn, $insertAdditionalProductSQL);
            for ($i = 0; $i < count($additionalCafeProducts); $i++) {
                $additionalCafeProductPrice = calculateProductPrice($additionalCafeProducts[$i], "product_price", "cafe_products");
                $totalAdditionalPrice =  $additionalCafeProductPrice * $additionalCafeQuantities[$i];
                mysqli_stmt_bind_param($stmtAdditionalProduct, 'iiidd', $foodOrderID, $additionalCafeProducts[$i], $additionalCafeQuantities[$i], $additionalCafeProductPrice, $totalAdditionalPrice);
                mysqli_stmt_execute($stmtAdditionalProduct);
            }
        }

        if (!empty($additionalFoodProducts)) {
            $insertAdditionalProductSQL = "INSERT INTO food_products_order (food_order_id, food_product_id, quantity, each_price, total_price) VALUES (?, ?, ?, ?, ?)";
            $stmtAdditionalProduct = mysqli_prepare($conn, $insertAdditionalProductSQL);
            for ($i = 0; $i < count($additionalFoodProducts); $i++) {
                $additionalProductPrice = calculateProductPrice($additionalFoodProducts[$i]);
                $totalAdditionalPrice =  $additionalProductPrice * $additionalFoodQuantities[$i];
                mysqli_stmt_bind_param($stmtAdditionalProduct, 'iiidd', $foodOrderID, $additionalFoodProducts[$i], $additionalFoodQuantities[$i], $additionalProductPrice, $totalAdditionalPrice);
                mysqli_stmt_execute($stmtAdditionalProduct);
            }
        }

        // Commit the transaction
        mysqli_commit($conn);

        // echo "Order added successfully!";
        header("Location: ../UserDashboard.php");
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
function calculateTotalOrderPriceCafeProducts($additionalProducts, $additionalQuantities)
{
    $totalPrice = 0;

    foreach ($additionalProducts as $index => $additionalProduct) {
        $additionalProductPrice = calculateProductPrice($additionalProduct, "product_price", "cafe_products");
        $totalPrice += ($additionalProductPrice * $additionalQuantities[$index]);
    }

    return $totalPrice;
}
function calculateTotalOrderPriceFoodProducts($additionalFoodProducts, $additionalFoodQuantities)
{
    $totalPrice = 0;

    foreach ($additionalFoodProducts as $index => $additionalProduct) {
        $additionalProductPrice = calculateProductPrice($additionalProduct, "food_price", "foodcar_products");
        $totalPrice += ($additionalProductPrice * $additionalFoodQuantities[$index]);
    }

    return $totalPrice;
}

// Function to calculate the price of a product (you can replace this with your actual pricing logic)
function calculateProductPrice($productID, $column = 'food_price', $table = 'foodcar_products')
{
    global $conn;

    $query = "SELECT $column FROM $table WHERE id = '$productID'";

    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_array($result);

    return $row[0];
}
