<?php

require_once("../../functions/dd.php");
require_once("../../DB/db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $product_price = $_POST['product_price'];
    $type = $_POST['type'];

    // Prepare and bind the update statement
    $query = "UPDATE stocks SET
                product_name = ?,
                quantity = ?,
                product_price = ?,
                type = ?
                WHERE id = ?";

    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, 'sdisi', $product_name, $quantity, $product_price, $type, $product_id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {

        header("Location: ../../stock.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // Handle invalid request
    header("Location: ../../index.php");
    exit();
}
