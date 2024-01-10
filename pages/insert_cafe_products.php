<?php
session_start();

// Database Configuration Included
require_once("../DB/db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /// Validate (Required Data)


    if (!empty($_POST['product']) && (!empty($_POST['quantity']) && $_POST['quantity'] > 0)) {
        // Main product data
        $mainProductID = $_POST["product"];
        $mainQuantity = $_POST["quantity"];
    } else {
        // Empty data have been sent 
        $_SESSION['error_message'] = "لا تنسى اختيار المنتج الرئيسي ";
        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    }


    // Additional products data (if available)
    $additionalProducts = isset($_POST["additionalProduct"]) ? $_POST["additionalProduct"] : [];
    $additionalQuantities = isset($_POST["additionalQuantity"]) ? $_POST["additionalQuantity"] : [];

    try {


        // Begin transaction
        mysqli_begin_transaction($conn);

        // Insert data into cafe_orders table
        $insertOrderSQL = "INSERT INTO cafe_orders (total_price, user_id) VALUES (?, ?)";
        $stmtOrder = mysqli_prepare($conn, $insertOrderSQL);
        $totalOrderPrice = calculateTotalOrderPrice($mainProductID, $mainQuantity, $additionalProducts, $additionalQuantities);
        $userID = $_SESSION['user_id'];
        mysqli_stmt_bind_param($stmtOrder, 'di', $totalOrderPrice, $userID);
        mysqli_stmt_execute($stmtOrder);
        $cafeOrderID = mysqli_insert_id($conn); // Get the last inserted ID

        // Insert data into cafe_products_orders table for the main product
        $insertMainProductSQL = "INSERT INTO cafe_products_orders (cafe_order_id, cafe_product_id, quantity, each_price, total_price) VALUES (?, ?, ?, ?, ?)";
        $stmtMainProduct = mysqli_prepare($conn, $insertMainProductSQL);
        $mainProductPrice = calculateProductPrice($mainProductID);
        $total_price = $mainProductPrice * $mainQuantity;
        mysqli_stmt_bind_param($stmtMainProduct, 'iiidd', $cafeOrderID, $mainProductID, $mainQuantity, $mainProductPrice,  $total_price);
        mysqli_stmt_execute($stmtMainProduct);

        // Insert data into cafe_products_orders table for additional products (if available)
        if (!empty($additionalProducts)) {
            $insertAdditionalProductSQL = "INSERT INTO cafe_products_orders (cafe_order_id, cafe_product_id, quantity, each_price, total_price) VALUES (?, ?, ?, ?, ?)";
            $stmtAdditionalProduct = mysqli_prepare($conn, $insertAdditionalProductSQL);
            for ($i = 0; $i < count($additionalProducts); $i++) {
                $additionalProductPrice = calculateProductPrice($additionalProducts[$i]);
                $totalAdditionalPrice =  $additionalProductPrice * $additionalQuantities[$i];
                mysqli_stmt_bind_param($stmtAdditionalProduct, 'iiidd', $cafeOrderID, $additionalProducts[$i], $additionalQuantities[$i], $additionalProductPrice, $totalAdditionalPrice);
                mysqli_stmt_execute($stmtAdditionalProduct);
            }
        }

        // Commit the transaction
        mysqli_commit($conn);

        // echo "Order added successfully!";
        header("Location: ../cafe.php");
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
    $totalPrice = calculateProductPrice($mainProductID) * $mainQuantity; /// 10 * 5 = 50

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
