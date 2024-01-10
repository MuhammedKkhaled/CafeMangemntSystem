<?php

session_start();
$page_title = 'Orders Details';

if (isset($_SESSION['username'])) {
    require_once("inc/header.php");
    require_once("inc/sidebar.php");
    require_once("inc/navbar.php");
    require_once("DB/db_config.php");

    /// get the currentdate and id for registered user 
    $currentDate = date("Y-m-d");
    $userId = $_SESSION["user_id"];
   
    /// get the orders where it's created_date today and it's registered by the logged in user
    $query = "SELECT * FROM `cafe_orders` WHERE date(`created_at`) = '$currentDate' And `user_id` =$userId";

    ///apply the query
    $result = mysqli_query($conn, $query);

?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-center mb-4">
            <h1 class="h3 mb-0 text-gray-900">تفاصيل طلبات اليوم </h1>

        </div>
        <!-- Content Row -->

        <!-- Begin Cafe Content -->
        <!-- 
        <div class="row d-sm-flex align-items-center justify-content-between mb-4">
            <div class="col-md-4">
                <a href="add_cafe_order.php" class="btn-lg mb-2 text-center btn btn-primary">
                    اضافة طلب
                </a>
            </div>
            <div class="col-md-4 text-center">
                <h1 class="h5 mb-0 text-gray-800">المنيو</h1>
            </div>
            <div class="col-md-4 text-center">
                <a href="orders_details.php" class="btn-lg mb-2 text-center btn btn-primary">
                    معرفة تفاصيل الاوردارات
                </a>
            </div>
            <div class="col-md-4"></div>
        </div> -->

        <div class="row">
            <?php
            if (mysqli_num_rows($result) > 0) {
            ?>
                <table class="table table-striped">
                    <thead>
                        <tr class="text-gray-800">
                            <th scope="col">رقم الاوردر</th>
                            <th scope="col">سعر الاوردر</th>
                            <th scope="col">كود الاوردر</th>
                            <th scope="col">حركات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="">
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                    </tbody>
                </table>
            <?php } else {
                echo "مفيش اوردارت";
            }
            ?>
        </div>
        <!-- Content Row -->

        <!-- Content Row -->
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