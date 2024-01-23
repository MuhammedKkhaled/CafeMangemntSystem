<?php
session_start();

// Database Configuration Included 
require_once("../DB/db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get the order_id
    $orderID = $_GET['order_id'];

    // Get The order Old price
    $oldOrderPrice = $_GET['old_price'];

    if (!empty($_POST['Product']) && (!empty($_POST['Quantity']) && $_POST['Quantity'] > 0)) {
        // Main product data
        $mainProductID = $_POST["Product"];
        $mainQuantity = $_POST["Quantity"];
    } else {
        // Empty data have been sent 
        $_SESSION['error_message'] = "لا تنسى اختيار المنتج الاضافي لمتابعة الطلب";
        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    }

    // Additional products Data (if Available)
    $additionalProducts = isset($_POST['additionalProduct']) ? $_POST["additionalProduct"] : [];
    $additionalQuantities = isset($_POST['additionalQuantity']) ? $_POST["additionalQuantity"] : [];

    try {

        mysqli_begin_transaction($conn);

        // Update Food_order price 
        $updateOrderSQl = "UPDATE `food_orders` 
                            SET `total_price` = ?
                            WHERE `id` = ?";
        $stmtOrder     = mysqli_prepare($conn, $updateOrderSQl);
        $newOrderPrice = calculateTotalOrderPrice($mainProductID, $mainQuantity, $additionalProducts, $additionalQuantities);
        $newOrderPrice += $oldOrderPrice;
        mysqli_stmt_bind_param($stmtOrder, 'di', $newOrderPrice, $orderID);
        mysqli_stmt_execute($stmtOrder);

        // Insert data into food_products_order table for the main product
        $insertMainProductSQL = "INSERT INTO food_products_order (food_order_id, food_product_id, quantity, each_price, total_price) VALUES (?, ?, ?, ?, ?)";
        $stmtMainProduct = mysqli_prepare($conn, $insertMainProductSQL);
        $mainProductPrice = calculateProductPrice($mainProductID);
        $total_price = $mainProductPrice * $mainQuantity;
        mysqli_stmt_bind_param($stmtMainProduct, 'iiidd', $orderID, $mainProductID, $mainQuantity, $mainProductPrice,  $total_price);
        mysqli_stmt_execute($stmtMainProduct);

        // Insert data into food_products_order table for additional products (if available)
        if (!empty($additionalProducts)) {
            $insertAdditionalProductSQL = "INSERT INTO food_products_order (food_order_id, food_product_id, quantity, each_price, total_price) VALUES (?, ?, ?, ?, ?)";
            $stmtAdditionalProduct = mysqli_prepare($conn, $insertAdditionalProductSQL);
            for ($i = 0; $i < count($additionalProducts); $i++) {
                $additionalProductPrice = calculateProductPrice($additionalProducts[$i]);
                $totalAdditionalPrice =  $additionalProductPrice * $additionalQuantities[$i];
                mysqli_stmt_bind_param($stmtAdditionalProduct, 'iiidd', $orderID, $additionalProducts[$i], $additionalQuantities[$i], $additionalProductPrice, $totalAdditionalPrice);
                mysqli_stmt_execute($stmtAdditionalProduct);
            }
        }

        // Commit the transaction 
        mysqli_commit($conn);

        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction in case of an error occurred
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

// Function to calculate the price of a product
function calculateProductPrice($productID)
{
    global $conn;

    $query = "SELECT `food_price` FROM `foodcar_productsw` WHERE id = '$productID'";

    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_array($result);

    return $row[0];
}
