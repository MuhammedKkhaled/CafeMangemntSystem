<?php

require_once("../../functions/dd.php");
require_once("../../DB/db_config.php");
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $food_id = $_GET['food_id'];

    $query = "DELETE FROM foodcar_products WHERE id = $food_id";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    }

    mysqli_close($conn);
}
