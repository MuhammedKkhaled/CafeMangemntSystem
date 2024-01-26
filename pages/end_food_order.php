<?php

require_once("../DB/db_config.php");
require_once("../functions/dd.php");
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== "") {


    $orderId = isset($_GET['orderId']) ? intval($_GET['orderId']) : 0;
    $table_id = isset($_GET['table_id']) ? intval($_GET['table_id']) : 0;
    date_default_timezone_set("Africa/cairo");
    $currentTimestamp = date('Y-m-d H:i:s');

    try {
        // Begin SQL Transaction
        mysqli_begin_transaction($conn);

        $updateTableAvilability = "UPDATE tables SET is_available = 1 WHERE id = ?";
        $stmtUpdateAvilability = mysqli_prepare($conn, $updateTableAvilability);
        mysqli_stmt_bind_param($stmtUpdateAvilability, 'i', $table_id);
        mysqli_stmt_execute($stmtUpdateAvilability);


        $updateOrder = "UPDATE food_orders SET 
        table_id = NULL ,
        ended_at = ? 
        WHERE id = ?";
        $stmtUpdateOrder = mysqli_prepare($conn, $updateOrder);
        mysqli_stmt_bind_param($stmtUpdateOrder, 'si', $currentTimestamp, $orderId);
        mysqli_stmt_execute($stmtUpdateOrder);

        // Commit the transaction
        mysqli_commit($conn);

        header("Location: ../all_food_order.php");
        exit;
    } catch (Exception $e) {
        // Rollback the transaction in case of an exception
        mysqli_rollback($conn);
        echo "Error: " . $e->getMessage();
        exit;
    } finally {
        // Close the connection
        mysqli_close($conn);
    }

    // ... continue with the rest of your code ...

} else {
    header("Location: ../all_food_order.php");
    exit;
}
