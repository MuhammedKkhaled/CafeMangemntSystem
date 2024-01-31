Kareem Emad
<?php
// Include your database connection file here
require_once("../DB/db_config.php");

// Check if start_date and end_date parameters are set
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
        // Sanitize and validate input
        $start_date = mysqli_real_escape_string($conn, $_GET['start_date']);
        $end_date = mysqli_real_escape_string($conn, $_GET['end_date']);

        // Validate date format (example: YYYY-MM-DD)
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $start_date) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $end_date)) {
            echo json_encode(array('error' => 'Invalid date format'), JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Query using prepared statement
        $query = "SELECT * FROM cafe_orders WHERE created_at BETWEEN ? AND ?";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $start_date, $end_date);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            $orders = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $orders[] = $row;
            }

            // Return JSON response
            echo json_encode($orders, JSON_UNESCAPED_UNICODE);
        } else {
            // Return error response if prepared statement fails
            echo json_encode(array('error' => 'Prepared statement failed'), JSON_UNESCAPED_UNICODE);
        }
    } else {
        // Return error response if parameters are missing
        echo json_encode(array('error' => 'Missing parameters'), JSON_UNESCAPED_UNICODE);
    }
} else {
    // Handle other request methods (e.g., POST)
    echo json_encode(array('error' => 'Invalid request method'), JSON_UNESCAPED_UNICODE);
}
?>