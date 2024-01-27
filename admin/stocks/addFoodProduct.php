<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['username'])) {

    require_once("../../functions/dd.php");
    require_once("../../DB/db_config.php");
    date_default_timezone_set("Africa/Cairo");
    // Escape user inputs for security
    $food_name = mysqli_real_escape_string($conn, $_POST['food_name']);
    $food_price = mysqli_real_escape_string($conn, $_POST['food_price']);
    $created_at = date('Y-m-d h:i:s');
    $admin_id = $_SESSION['user_id'];
    if (empty($food_name)) {
        $_SESSION['message_error'] = "لا يمكن ان يكون اسم المنتج فارغ ";
        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    }
    if (empty($food_price) || $food_price <= 0) {
        $_SESSION['message_error'] = "لا يمكن ان يكون سعر المنتج فارغ او يساوي الصفر ";
        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    }

    // Attempt insert query execution
    $insertQuery = "INSERT INTO foodcar_products (food_name, food_price, admin_id, created_at) VALUES ('$food_name', '$food_price', '$admin_id', '$created_at')";

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
