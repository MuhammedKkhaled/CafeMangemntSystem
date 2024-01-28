<?php

require_once("../../functions/dd.php");
require_once("../../DB/db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['playstation_id'])) {


    $playstation_id = $_GET['playstation_id'];
    $playstation_type = $_POST['playstation_type'];
    $palystation_price = $_POST['palystation_price'];

    // Prepare and bind the update statement
    $query = "UPDATE playstation_configuration SET
                playstation_type = ?,
                price_per_hour = ?
                WHERE id = ?";

    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, 'sii', $playstation_type, $palystation_price, $playstation_id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {

        header("Location: ../../playstationMenu.php");
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
