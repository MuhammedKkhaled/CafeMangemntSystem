<?php
session_start();

// Database Configuration Included 
require_once("../DB/db_config.php");
require_once("../functions/dd.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // dd($_POST);


    // Additional Food products Data (if Available)
    $additionalFoodProducts = isset($_POST['additionalFoodProduct']) ? $_POST["additionalFoodProduct"] : [];
    $additionalFoodQuantities = isset($_POST['additionalFoodQuantity']) ? $_POST["additionalFoodQuantity"] : [];

    // Additional Cafe products Data (if Available)
    $additionalCafeProducts = isset($_POST['additionalCafeProduct']) ? $_POST["additionalCafeProduct"] : [];
    $additionalCafeQuantities = isset($_POST['additionalCafeQuantity']) ? $_POST["additionalCafeQuantity"] : [];

    // Get the order_id
    $orderID = $_GET['order_id'];

    // Get The order Old price
    $oldOrderPrice = $_GET['old_price'];

    if (empty($additionalFoodProducts) && empty($additionalCafeProducts)) {
        // Empty data have been sent 
        $_SESSION['error_message'] = "لا تنسى اختيار المنتج الاضافي لمتابعة الطلب";
        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    }


    try {

        // Begin transaction
        mysqli_begin_transaction($conn);

        // Insert data into cafe_orders table
        $updateOrderStmt = "UPDATE food_orders SET total_price = ? WHERE id = $orderID";
        $stmtOrder = mysqli_prepare($conn, $updateOrderStmt);
        $totalOrderPriceForCafe = calculateTotalOrderPriceCafeProducts($additionalCafeProducts, $additionalCafeQuantities);
        $totalOrderPriceForFood = calculateTotalOrderPriceFoodProducts($additionalFoodProducts, $additionalFoodQuantities);
        $totalOrderPrice = $totalOrderPriceForCafe + $totalOrderPriceForFood;
        $totalOrderPrice += $oldOrderPrice;
        $userID = $_SESSION['user_id'];
        mysqli_stmt_bind_param($stmtOrder, 'i', $totalOrderPrice);
        mysqli_stmt_execute($stmtOrder);



        // Insert data into cafe_products_orders table for additional products (if available)
        if (!empty($additionalCafeProducts)) {
            $insertAdditionalProductSQL = "INSERT INTO food_products_order (food_order_id, cafe_product_id, quantity, each_price, total_price) VALUES (?, ?, ?, ?, ?)";
            $stmtAdditionalProduct = mysqli_prepare($conn, $insertAdditionalProductSQL);
            for ($i = 0; $i < count($additionalCafeProducts); $i++) {
                $additionalCafeProductPrice = calculateProductPrice($additionalCafeProducts[$i], "product_price", "cafe_products");
                $totalAdditionalPrice =  $additionalCafeProductPrice * $additionalCafeQuantities[$i];
                mysqli_stmt_bind_param($stmtAdditionalProduct, 'iiidd', $orderID, $additionalCafeProducts[$i], $additionalCafeQuantities[$i], $additionalCafeProductPrice, $totalAdditionalPrice);
                mysqli_stmt_execute($stmtAdditionalProduct);
            }
        }

        if (!empty($additionalFoodProducts)) {
            $insertAdditionalProductSQL = "INSERT INTO food_products_order (food_order_id, food_product_id, quantity, each_price, total_price) VALUES (?, ?, ?, ?, ?)";
            $stmtAdditionalProduct = mysqli_prepare($conn, $insertAdditionalProductSQL);
            for ($i = 0; $i < count($additionalFoodProducts); $i++) {
                $additionalProductPrice = calculateProductPrice($additionalFoodProducts[$i]);
                $totalAdditionalPrice =  $additionalProductPrice * $additionalFoodQuantities[$i];
                mysqli_stmt_bind_param($stmtAdditionalProduct, 'iiidd', $orderID, $additionalFoodProducts[$i], $additionalFoodQuantities[$i], $additionalProductPrice, $totalAdditionalPrice);
                mysqli_stmt_execute($stmtAdditionalProduct);
            }
        }

        // Commit the transaction
        mysqli_commit($conn);

        // echo "Order added successfully!";
        header("Location: ../all_food_order.php");
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
