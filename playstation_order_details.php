<?php
session_start();

// echo "<pre>";
// print_r($_GET);
// exit;

$page_title = 'Playstation Order Details';

if (isset($_SESSION['username'])) {
    require_once("inc/header.php");
    require_once("inc/sidebar.php");
    require_once("inc/navbar.php");
    require_once("DB/db_config.php");

    // Get the order ID from the GET request
    $orderId = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
    $session_id = isset($_GET['session_id']) ? intval($_GET['session_id']) : 0;
    $old_price = isset($_GET['old_price']) ? intval($_GET['old_price']) : 0;


    /// Query to get the session and display it 
    $sessionQuery = "SELECT * FROM `playstation_session` WHERE `id`=$session_id";
    $sessionQueryResult = mysqli_query($conn, $sessionQuery);

    //Query To Get The cafe_proudcts If Is not null (Or Exist In playstation_product_order table)
    $ProductsInPlaystationOrderQuery = " SELECT fp.food_name, ppo.qunatity , ppo.each_price, ppo.total_price
    FROM playstation_product_order AS ppo
    JOIN foodcar_products AS fp ON ppo.foodcar_product_id = fp.id
    WHERE playstation_session_id = $session_id AND foodcar_product_id IS NOT NULL
    
    UNION ALL
    
    SELECT  cp.product_name, ppo.qunatity , ppo.each_price, ppo.total_price
    FROM playstation_product_order AS ppo
    JOIN cafe_products AS cp ON ppo.cafe_product_id = cp.id
    WHERE playstation_session_id = $session_id AND cafe_product_id IS NOT NULL; ";

    $ProductsInPlaystationOrderQueryResult = mysqli_query($conn, $ProductsInPlaystationOrderQuery);


?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-center mb-4">
            <h1 class="h3 mb-0 text-gray-900">تفاصيل الطلب رقم <?= $orderId ?></h1>
        </div>
        <!-- Content Row -->
        <div class="row">
            <div class="form-group">
                <label for="orderTotalPrice">سعر الطلب</label>
                <input type="text" class="form-control" id="orderTotalPrice" name="orderTotalPrice" value="<?= $old_price ?>" readonly>
            </div>
        </div>
        <div class="row align-items-center justify-content-center text-gray-900">
            <h5>
                تفاصيل البلاستيشن من غير الطلبات اللي موجودة فيه
            </h5>
            <!-- Begin The Orders -->
            <!-- Begin The playstation_session -->
            <?php
            if (mysqli_num_rows($sessionQueryResult) > 0) {
                $rows = mysqli_fetch_assoc($sessionQueryResult)
            ?>
                <table class="table table-striped">
                    <thead>
                        <tr class="text-gray-800">
                            <th scope="col">نوع الجهاز</th>
                            <th scope="col"> عدد الدرعات</th>
                            <th scope="col">بادئ الساعة كام </th>
                            <th scope="col">
                                <?php
                                if ($rows["end_time"] == "0000-00-00 00:00:00") {
                                    echo "لسا مخلصش القعدة بتاعته ";
                                } else {

                                    echo "خلص قعدته ";
                                }
                                ?>
                            </th>
                            <th scope="col">
                                السعر الاساسي للساعة
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="">
                            <td><?= $rows['playstation_type'] ?></td>
                            <td><?= $rows['controllers_type'] ?></td>
                            <td><?= date('H:i:s', strtotime($rows['start_time'])) ?></td>
                            <td><?= date('H:i:s', strtotime($rows['end_time'])) ?></td>
                            <td><?= $rows['base_price_for_this_confgurations'] ?></td>
                            <?php
                            // $totalOrderPrice += $rows['product_total_price'];
                            ?>
                        </tr>
                        <tr class="text-gray-800">
                            <td colspan="3" class="text-right"><strong>السعر الإجمالي للطلب</strong></td>
                            <td>
                                <?php
                                if ($rows['total_price'] == 0) {
                                    echo  "لسا ماحسبش";
                                } else {
                                    echo $rows['total_price'];
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            <?php
            }
            ?>
            <!-- end The playstation_session -->
            <hr style="margin-top: 20px; margin-bottom: 20px; border-color: #ccc;">

            <?php
            if ($old_price > 0) {
            ?>
                <h5>
                    تفاصيل الطلبات اللي موجودة في الطلب نفسه
                </h5>
                <?php
                if (mysqli_num_rows($ProductsInPlaystationOrderQueryResult)) {

                ?>
                    <table class="table table-striped">
                        <thead>
                            <tr class="text-gray-800">
                                <th scope="col"> اسم المنتج </th>
                                <th scope="col"> الكمية</th>
                                <th scope="col">سعر المنتج</th>
                                <th scope="col">السعر النهائي</th>

                            </tr>
                        </thead>
                        <?php
                        $totalOrderPrice = 0;
                        while ($rows = mysqli_fetch_assoc($ProductsInPlaystationOrderQueryResult)) {
                        ?>
                            <tbody>
                                <tr class="">
                                    <td><?= $rows['food_name'] ?></td>
                                    <td><?= $rows['qunatity'] ?></td>
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
            <?php
                }
            }
            ?>
            <!-- End The Orders -->
        </div>
        <!-- Content Row -->
        <a href="all_playstation_order.php" class="btn btn-danger">عودة</a>
    </div>
    <!-- /.container-fluid -->

<?php
    require_once("inc/footer.php");
    require_once("inc/scripts.php");
} else {
    header("Location: index.php");
    exit();
}

function nameOFEndTimeRow($session_id)
{
    global $conn;
    $sessionQuery = "SELECT `end_time` FROM `playstation_session` WHERE `id`=$session_id";
    $sessionQueryResult = mysqli_query($conn, $sessionQuery);
    $rows = mysqli_fetch_array($sessionQueryResult);

    if ($rows[0] == "0000-00-00 00:00:00") {
        return "لسا مخلصش القعدة بتاعته ";
    }
    return "خلص قعدته ";
}

?>