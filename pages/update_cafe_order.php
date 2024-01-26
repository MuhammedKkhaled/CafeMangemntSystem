<?php
session_start();

//// DataBase Configuration Included 
require_once("../DB/db_config.php");
require_once("../functions/dd.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // dd($_POST);
    // dd($_GET);
    ///Get the order_id
    $orderID = $_GET['order_id'];
    /// Get The order Old price
    $oldOrderPrice = $_GET['old_price'];



    // if (!empty($_POST['product']) && (!empty($_POST['quantity']) && $_POST['quantity'] > 0)) {
    //     // Main product data
    //     $mainProductID = $_POST["product"];
    //     $mainQuantity = $_POST["quantity"];
    // } else {
    //     // Empty data have been sent 
    //     $_SESSION['error_message'] = "لا تنسى اختيار المنتج الاضافي لمتابعة الطلب";
    //     $referrerPage = $_SERVER['HTTP_REFERER'];
    //     header("Location: $referrerPage");
    //     exit();
    // }

    /// Additional products Data (if Available)
    $additionalProducts = isset($_POST['additionalProduct']) ? $_POST["additionalProduct"] : [];
    $additionalQuantities = isset($_POST['additionalQuantity']) ? $_POST["additionalQuantity"] : [];

    /// Additional Food products Data (if Available)
    $additionalfoodproducts = isset($_POST['additionalfoodproducts']) ? $_POST["additionalfoodproducts"] : [];
    $additionalFoodQuantities = isset($_POST['additionalFoodQuantity']) ? $_POST["additionalFoodQuantity"] : [];

    try {

        mysqli_begin_transaction($conn);

        /// Update Cafe_order price 
        $updateOrderSQl = "UPDATE `cafe_orders` 
                            SET `total_price` = ?
                            WHERE `id` = ?";
        $stmtOrder = mysqli_prepare($conn, $updateOrderSQl);
        $newOrderPrice = calculateTotalOrderPrice($additionalProducts, $additionalQuantities);
        $newOrderPrice += $oldOrderPrice;
        $orderFoodProductPrice = calculateTotalOrderPriceForFoodProudcts($additionalfoodproducts, $additionalFoodQuantities);
        $newOrderPrice += $orderFoodProductPrice;
        mysqli_stmt_bind_param($stmtOrder, 'di', $newOrderPrice, $orderID);
        mysqli_stmt_execute($stmtOrder);

        // // Insert data into cafe_products_orders table for the main product
        // $insertMainProductSQL = "INSERT INTO cafe_products_orders (cafe_order_id, cafe_product_id, quantity, each_price, total_price) VALUES (?, ?, ?, ?, ?)";
        // $stmtMainProduct = mysqli_prepare($conn, $insertMainProductSQL);
        // $mainProductPrice = calculateProductPrice($mainProductID);
        // $total_price = $mainProductPrice * $mainQuantity;
        // mysqli_stmt_bind_param($stmtMainProduct, 'iiidd', $orderID, $mainProductID, $mainQuantity, $mainProductPrice,  $total_price);
        // mysqli_stmt_execute($stmtMainProduct);

        // Insert data into cafe_products_orders table for additional products (if available)
        if (!empty($additionalProducts)) {
            $insertAdditionalProductSQL = "INSERT INTO cafe_products_orders (cafe_order_id, cafe_product_id, quantity, each_price, total_price) VALUES (?, ?, ?, ?, ?)";
            $stmtAdditionalProduct = mysqli_prepare($conn, $insertAdditionalProductSQL);
            for ($i = 0; $i < count($additionalProducts); $i++) {
                $additionalProductPrice = calculateProductPrice($additionalProducts[$i]);
                $totalAdditionalPrice =  $additionalProductPrice * $additionalQuantities[$i];
                mysqli_stmt_bind_param($stmtAdditionalProduct, 'iiidd', $orderID, $additionalProducts[$i], $additionalQuantities[$i], $additionalProductPrice, $totalAdditionalPrice);
                mysqli_stmt_execute($stmtAdditionalProduct);
            }
        }


        // Insert data into cafe_products_orders table for additional products (if available)
        if (!empty($additionalfoodproducts)) {
            $insertAdditionalProductSQL = "INSERT INTO cafe_products_orders (cafe_order_id, food_product_id, quantity, each_price, total_price) VALUES (?, ?, ?, ?, ?)";
            $stmtAdditionalProduct = mysqli_prepare($conn, $insertAdditionalProductSQL);
            for ($i = 0; $i < count($additionalfoodproducts); $i++) {
                $additionalProductPrice = calculateFoodProductPrice($additionalfoodproducts[$i]);
                $totalAdditionalPrice =  $additionalProductPrice * $additionalFoodQuantities[$i];
                mysqli_stmt_bind_param($stmtAdditionalProduct, 'iiidd', $orderID, $additionalfoodproducts[$i], $additionalFoodQuantities[$i], $additionalProductPrice, $totalAdditionalPrice);
                mysqli_stmt_execute($stmtAdditionalProduct);
            }
        }

        /// Commit the transaction 
        mysqli_commit($conn);


        header("Location: ../all_orders.php");
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
function calculateTotalOrderPrice($additionalProducts, $additionalQuantities)
{
    $totalPrice = 0; /// 10 * 5 = 50

    foreach ($additionalProducts as $index => $additionalProduct) {
        $additionalProductPrice = calculateProductPrice($additionalProduct);
        $totalPrice += ($additionalProductPrice * $additionalQuantities[$index]);
    }

    return $totalPrice;
}

// Function to calculate the price of a product (you can replace this with your actual pricing logic)
function calculateProductPrice($productID)
{
    global $conn;

    $query = "SELECT `product_price` FROM `cafe_products` WHERE id = '$productID'";

    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_array($result);

    return $row[0];
}

// / Function to calculate the total order price For Food products only
function calculateTotalOrderPriceForFoodProudcts($additionalfoodproducts, $additionalfoodQuantities)
{

    $totalPrice = 0;
    foreach ($additionalfoodproducts as  $index => $additionalfoodproduct) {
        $additionalFoodProductPrice = calculateFoodProductPrice($additionalfoodproduct);
        $totalPrice += ($additionalFoodProductPrice * $additionalfoodQuantities[$index]);
    }

    return $totalPrice;
}

// Function to calculate the price of a food product 
function calculateFoodProductPrice($foodProductPrice)
{
    global $conn;

    $query = "SELECT `food_price` FROM `foodcar_products` WHERE id = '$foodProductPrice'";

    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_array($result);

    return $row[0];
}
