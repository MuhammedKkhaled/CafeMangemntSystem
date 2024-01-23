<?php
// Include your database configuration file
require_once("../DB/db_config.php");

// Query to fetch product options from the database
$query = "SELECT id , food_name FROM foodcar_products";
$result = mysqli_query($conn, $query);

if ($result) {
    // $row = mysqli_fetch_assoc($result);
    // echo  "<pre>";
    // print_r($row);
    // exit();

    $productOptions = array();

    // Fetch product options and store them in an array
    while ($row = mysqli_fetch_assoc($result)) {
        $productOptions[] = $row;
    }

    // Return the product options as JSON
    header('Content-Type: application/json');
    echo json_encode($productOptions);
} else {
    // Handle the case where the query fails
    echo "Error fetching product options: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
