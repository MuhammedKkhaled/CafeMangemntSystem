<?php
session_start();

$page_title = "Playstation Page";
if (isset($_SESSION['username'])) {
    require_once("inc/header.php");
    require_once("inc/sidebar.php");
    require_once("inc/navbar.php");
    require_once("DB/db_config.php");

    $query  =  "SELECT * FROM `playstation_configuration`";
    $result =  mysqli_query($conn, $query);
?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-center mb-4">
            <h1 class="h3 mb-0 text-gray-900">البلايستيشن</h1>
        </div>
        <!-- Content Row -->

        <!-- Begin Cafe Content -->
        <div class="row d-sm-flex align-items-center justify-content-between mb-4">

            <div class="col-md-4 text-center">
                <!-- <h1 class="h5 mb-0 text-gray-800">الاسعار</h1> -->
            </div>
            <div class="col-md-4 text-center">
                <a href="all_playstation_order.php" class="btn-lg mb-2 text-center btn btn-primary">
                    معرفة تفاصيل الاوردارات
                </a>
            </div>
            <div class="col-md-4"></div>
        </div>
        <div class="row">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($rows = mysqli_fetch_assoc($result)) {
            ?>
                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-md font-weight-bold text-primary text-uppercase mb-1">
                                            <?= $rows['playstation_type'] ?>
                                        </div>
                                        <div class="text-md font-weight-bold text-primary text-uppercase mt-2">
                                            <?= $rows['controllers_type'] ?>
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?= $rows['price_per_hour'] ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-gamepad fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>

        <!-- Content Row -->
    </div>
    <!-- <div class="col-md-4">
        <a href="add_playstaion_order.php" class="btn-lg mb-2 text-center btn btn-primary">
            اضافة طلب
        </a>
    </div> -->
    <!-- /.container-fluid -->

<?php
    require_once("inc/footer.php");
    require_once("inc/scripts.php");
} else {
    header("Location: index.php");
    exit();
}
?>