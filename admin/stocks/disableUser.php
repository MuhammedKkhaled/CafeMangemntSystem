<?php
session_start();
require_once("../../DB/db_config.php");
if ($_SERVER["REQUEST_METHOD"] == "GET") {


    $user_id = $_GET['user_id'];

    if ($user_id == $_SESSION['user_id']) {
        $_SESSION['error_message'] = 'انتا رايح توقف نفسك يسطا دا بجد ؟ ';
        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    }

    $query = "UPDATE users
            SET `is_active` =0
            WHERE id = $user_id";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    }

    mysqli_close($conn);
}
