<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['username'])) {

    require_once("../../functions/dd.php");
    require_once("../../DB/db_config.php");
    date_default_timezone_set("Africa/Cairo");
    // Escape user inputs for security
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
    $created_at = date('Y-m-d h:i:s');
    $admin_id = $_SESSION['user_id'];
    if (empty($product_name)) {
        $_SESSION['message'] = "لا يمكن ان يكون اسم المنتج فارغ ";
        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    }
    if (empty($product_price)) {
        $_SESSION['message'] = "لا يمكن ان يكون سعر المنتج فارغ او يساوي الصفر ";
        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    }

    // Attempt insert query execution
    $insertQuery = "INSERT INTO cafe_products (product_name, product_price, admin_id, created_at) VALUES ('$product_name', '$product_price', '$admin_id', '$created_at')";

    if (mysqli_query($conn, $insertQuery)) {
        $_SESSION['done'] = "تمام يامعلم شاطر ";
        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    } else {
        $_SESSION['message'] = "يوجد خطا الان في البيانات برجاء الرجوع مرة اخري ";
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
