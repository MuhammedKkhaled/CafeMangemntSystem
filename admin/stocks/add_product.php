<?php
session_start();




if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['username'])) {



    require_once("../../functions/dd.php");
    require_once("../../DB/db_config.php");
    date_default_timezone_set("Africa/Cairo");
    // Escape user inputs for security
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $created_at = date('Y-m-d h:i:s');

    // Attempt insert query execution
    $insertQuery = "INSERT INTO stocks (product_name, quantity, product_price, type, created_at) VALUES ('$product_name', '$quantity', '$product_price', '$type', '$created_at')";

    if (mysqli_query($conn, $insertQuery)) {

        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    } else {
        $_SESSION['message_error'] = "يوجد خطا الان في البيانات برجاء الرجوع مرة اخري ";
        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    }


    // Close connection
    mysqli_close($conn);
} else {
    header("Location: ../index.php");
    exit();
}
