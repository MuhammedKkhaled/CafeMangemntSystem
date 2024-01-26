<?php
session_start();
$page_title = 'Order Details';

if (isset($_SESSION['username'])) {
    require_once("inc/header.php");
    require_once("inc/sidebar.php");
    require_once("inc/navbar.php");
    require_once("DB/db_config.php");

    // Get the order ID from the GET request
    $orderId = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Query to get order details and product names
    $query = "SELECT fp.food_name as 'Product Name', cpo.quantity , cpo.each_price, cpo.total_price 
            FROM cafe_products_orders AS cpo 
            JOIN foodcar_products AS fp ON cpo.food_product_id = fp.id 
            WHERE cafe_order_id = $orderId  AND food_product_id IS NOT NULL 
            UNION ALL
            SELECT cp.product_name, cpo.quantity , cpo.each_price, cpo.total_price 
            FROM cafe_products_orders AS cpo 
            JOIN cafe_products AS cp ON cpo.cafe_product_id = cp.id 
            WHERE cafe_order_id= $orderId  AND cafe_product_id IS NOT NULL
    ";



    // Apply the query
    $result = mysqli_query($conn, $query);


?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-center mb-4">
            <h1 class="h3 mb-0 text-gray-900">تفاصيل الطلب رقم <?= $orderId ?></h1>
        </div>
        <!-- Content Row -->
        <div class="row align-items-center justify-content-center">
            <?php if (mysqli_num_rows($result) > 0) { ?>
                <table class="table table-striped">
                    <thead>
                        <tr class="text-gray-800">
                            <th scope="col">اسم المنتج</th>
                            <th scope="col">الكمية</th>
                            <th scope="col">سعر الوحدة</th>
                            <th scope="col">السعر الإجمالي للمنتج</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalOrderPrice = 0;
                        while ($rows = mysqli_fetch_assoc($result)) { ?>
                            <tr class="">
                                <td><?= $rows['Product Name'] ?></td>
                                <td><?= $rows['quantity'] ?></td>
                                <td><?= $rows['each_price'] ?></td>
                                <td><?= $rows['total_price'] ?></td>
                                <?php
                                $totalOrderPrice += $rows['total_price'];
                                ?>
                            </tr>
                        <?php } ?>
                        <tr class="text-gray-800">
                            <td colspan="3" class="text-right"><strong>السعر الإجمالي للطلب</strong></td>
                            <td><?= $totalOrderPrice ?></td>
                        </tr>
                    </tbody>
                </table>
            <?php } else { ?>
                <div class="alert alert-danger">
                    لا توجد تفاصيل للطلب رقم <?= $orderId ?> حتى الآن.
                </div>
            <?php } ?>
        </div>
        <!-- Content Row -->
        <a href="all_orders.php" class="btn btn-danger">عودة</a>
    </div>
    <!-- /.container-fluid -->

<?php
    require_once("inc/footer.php");
    require_once("inc/scripts.php");
} else {
    header("Location: index.php");
    exit();
}
?>