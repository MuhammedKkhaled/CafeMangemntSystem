<?php

require_once("../../functions/dd.php");
require_once("../../DB/db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $user_id = $_GET['user_id'];
    $is_admin = $_GET['is_admin'];

    if ($is_admin == 1) {
        $_SESSION['error_message'] = "هذا المستخدم ادمن بالفعل ";
        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    }

    // Prepare and bind the update statement
    $query = "UPDATE users SET
                is_admin = 1 
                WHERE id = ?";

    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, 'i',  $user_id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {

        header("Location: ../../users.php");
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
