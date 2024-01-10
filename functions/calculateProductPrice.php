<?php
require_once("../DB/db_config.php");
function calculateProductPrice($productID)
{
    global $conn;

    // require_once("../DB/db_config.php");
    /// get product using $productID

    $query = "SELECT `product_price` FROM `cafe_products` WHERE id = '$productID'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);

    return $row[0];
}
