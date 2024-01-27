<?php

require_once("../../functions/dd.php");
require_once("../../DB/db_config.php");
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $product_id = $_GET['product_id'];

    $query = "DELETE FROM cafe_products WHERE id = $product_id";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    }

    mysqli_close($conn);
}
