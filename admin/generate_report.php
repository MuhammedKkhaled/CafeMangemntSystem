<?php

// Include your database connection file here
require_once("../DB/db_config.php");

// Check if start_date, end_date, and section parameters are set
if (isset($_GET['start_date']) && isset($_GET['end_date']) && isset($_GET['section'])) {
    // Sanitize input
    $start_date =  $_GET['start_date'];
    $end_date =  $_GET['end_date'];
    $section =  $_GET['section'];

    if ($section == 'foodcar') {
        $query = "SELECT * FROM `food_orders` WHERE `created_at` BETWEEN '$start_date'  AND '$end_date'";
        $result = mysqli_query($conn, $query);
    }
    if ($section == 'cafe') {
        $query = "SELECT * FROM `cafe_orders` WHERE `created_at` BETWEEN '$start_date'  AND '$end_date'";
        $result = mysqli_query($conn, $query);
    }
    if ($section == 'playstation') {
        $query = "SELECT id, order_price AS total_price, user_id, created_at FROM `playstation_orders` WHERE `created_at` BETWEEN '$start_date' AND '$end_date'";
        $result = mysqli_query($conn, $query);
    }



    $orders = array();
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Adjust the fields as per your database schema
            $orders[] = array(
                'id' => $row['id'],
                'total_price' => $row['total_price'],
                'user_id' => $row['user_id'],
                'created_at' => $row['created_at']
            );
        }
        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($orders);
    } else {
        // Return empty array if no data found
        echo json_encode(array());
    }
} else {
    // Return error response if parameters are missing
    echo json_encode(array('error' => 'Missing parameters'));
}
