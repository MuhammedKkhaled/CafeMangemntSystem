<?php

require_once("../../functions/dd.php");
require_once("../../DB/db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['cafe_product_id'])) {


    $cafe_product_id = $_GET['cafe_product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];

    // Prepare and bind the update statement
    $query = "UPDATE cafe_products SET
                product_name = ?,
                product_price = ?
                WHERE id = ?";

    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, 'sii', $product_name, $product_price, $cafe_product_id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {

        header("Location: ../../cafeMenu.php");
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
