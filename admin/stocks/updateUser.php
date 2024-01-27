<?php

require_once("../../functions/dd.php");
require_once("../../DB/db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['user_id'])) {


    $user_id = $_GET['user_id'];
    $userName = $_POST['userName'];
    $password = $_POST['password'];
    $oldPassword = $_POST['oldPassword'];

    if (empty($password)) {
        $hashedPassword  = $oldPassword;
    }

    if (strlen($password) < 6) {
        $_SESSION['message_error'] = "الرقم السري يجب ان يكون 6 ارقام او اكثر ";
        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    }

    $hashedPassword = hash("md5", $password);

    // Prepare and bind the update statement
    $query = "UPDATE users SET
                username = ? ,
                password = ?
                WHERE id = ? ";

    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, 'ssi', $userName, $hashedPassword, $user_id);

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
