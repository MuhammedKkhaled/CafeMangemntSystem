<?php

require_once("../../functions/dd.php");
require_once("../../DB/db_config.php");
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $playstation_id = $_GET['playstation_id'];

    $query = "DELETE FROM playstation_configuration WHERE id = $playstation_id";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    }

    mysqli_close($conn);
}
