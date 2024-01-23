<?php

require_once("../DB/db_config.php");

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== "") {


    $orderId = isset($_GET['orderId']) ? intval($_GET['orderId']) : 0;
    $session_id = isset($_GET['session_id']) ? intval($_GET['session_id']) : 0;
    $old_price = isset($_GET['old_price']) ? intval($_GET['old_price']) : 0;


    try {
        // Begin SQL Transaction
        mysqli_begin_transaction($conn);


        /// Update The end_time for this session 
        $updateEndtimeforSession = "UPDATE `playstation_session` SET `end_time` = now() WHERE `id` = ?";
        $stmtUpdateEndtime = mysqli_prepare($conn, $updateEndtimeforSession);
        mysqli_stmt_bind_param($stmtUpdateEndtime, 'i', $session_id);
        mysqli_stmt_execute($stmtUpdateEndtime);

        /// Calculate total price for this session
        $calculateTotalPriceQuery = "SELECT TIMESTAMPDIFF(MINUTE, `start_time`, `end_time`) / 60 * `base_price_for_this_confgurations` AS total_price FROM `playstation_session` WHERE `id` = ?";
        $stmtCalculateTotalPrice = mysqli_prepare($conn, $calculateTotalPriceQuery);
        mysqli_stmt_bind_param($stmtCalculateTotalPrice, 'i', $session_id);
        mysqli_stmt_execute($stmtCalculateTotalPrice);
        mysqli_stmt_bind_result($stmtCalculateTotalPrice, $calculatedTotalPrice);
        mysqli_stmt_fetch($stmtCalculateTotalPrice);


        // Close the statement
        mysqli_stmt_close($stmtCalculateTotalPrice);

        // Update total_price in playstation_session
        $updateTotalPriceQuery = "UPDATE `playstation_session` SET `total_price` = ? WHERE `id` = ?";
        $stmtUpdateTotalPrice = mysqli_prepare($conn, $updateTotalPriceQuery);
        mysqli_stmt_bind_param($stmtUpdateTotalPrice, 'di', $calculatedTotalPrice, $session_id);
        mysqli_stmt_execute($stmtUpdateTotalPrice);

        // Update total_price in playstation_orders
        $updateOrderTotalPriceQuery = "UPDATE `playstation_orders` SET `order_price` = ? WHERE `id` = ?";
        $stmtUpdateOrderTotalPrice = mysqli_prepare($conn, $updateOrderTotalPriceQuery);
        $updatedTotalOrderPrice = $old_price + $calculatedTotalPrice;
        mysqli_stmt_bind_param($stmtUpdateOrderTotalPrice, 'di',  $updatedTotalOrderPrice, $orderId);
        mysqli_stmt_execute($stmtUpdateOrderTotalPrice);

        // Commit the transaction
        mysqli_commit($conn);

        header("Location: ../all_playstation_order.php");
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
    header("Location: ../playstaion.php");
    exit;
}
