<?php
// Include your database connection file here
require_once("../DB/db_config.php");

// Check if start_date and end_date parameters are set
if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    // Sanitize input
    $start_date = mysqli_real_escape_string($conn, $_GET['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_GET['end_date']);

    // Query to retrieve orders data for the foodcar section
    $query = "SELECT * FROM foodcar_orders WHERE order_date BETWEEN '$start_date' AND '$end_date'";

    $result = mysqli_query($conn, $query);

    $orders = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $orders[] = $row;
        }
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($orders);
} else {
    // Return error response if parameters are missing
    echo json_encode(array('error' => 'Missing parameters'));
}
