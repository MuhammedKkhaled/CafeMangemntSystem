<?php

require_once("../../functions/dd.php");
require_once("../../DB/db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['food_product_id'])) {


    $food_product_id = $_GET['food_product_id'];
    $food_name = $_POST['food_name'];
    $food_price = $_POST['food_price'];

    // Prepare and bind the update statement
    $query = "UPDATE foodcar_products SET
                food_name = ?,
                food_price = ?
                WHERE id = ?";

    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, 'sii', $food_name, $food_price, $food_product_id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {

        header("Location: ../../carFoodMenu.php");
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
