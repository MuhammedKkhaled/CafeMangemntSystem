<?php
session_start();

$page_title = "Menu Page ";
if (isset($_SESSION['username'])) {
    require_once("inc/header.php");
    require_once("inc/sidebar.php");
    require_once("inc/navbar.php");
    require_once("DB/db_config.php");


    //// Get the Full cafe_products 
    $query = "SELECT * FROM `cafe_products` LIMIT 8 ";

    // execute the query 
    $result = mysqli_query($conn, $query);

    /// Get The full  food form foodcar_products
    $food_query = "SELECT * FROM `foodcar_products` LIMIT 8 ";

    /// Execute The query 
    $food_query_result = mysqli_query($conn, $food_query);


    /// Playstation Query 
    $playstationQuery = "SELECT * FROM `playstation_configuration`  LIMIT 8";

    /// Execute The query 
    $playstationQueryResult = mysqli_query($conn, $playstationQuery);
?>


    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">الاصناف </h1>

        </div>
        <!-- Content Row -->

        <!-- Begin Cafe Content -->
        <a href="cafe.php" class="btn btn-primary btn-lg mb-2">
            الكافيه
        </a>


        <div class="row">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {


            ?>
                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-md font-weight-bold text-primary text-uppercase mb-1">
                                            <?= $row['product_name'] ?>
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?= $row['product_price'] ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-coffee fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--End Cafe Content  -->
            <?php
                }
            }
            ?>
        </div>


        <!-- Begin Food Car Content  -->
        <a href="foodcar.php" class="btn btn-primary btn-lg mb-2">
            العربية
        </a>
        <div class="row">
            <?php
            if (mysqli_num_rows($food_query_result) > 0) {
                while ($rows = mysqli_fetch_assoc($food_query_result)) {

            ?>
                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-md font-weight-bold text-primary text-uppercase mb-1">
                                            <?= $rows['food_name'] ?>
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?= $rows['food_price'] ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-pizza-slice fa-2x text-gray-300"></i>
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
        <!-- End Food Car Content  -->

        <!-- Begin Playstaion Content  -->

        <a href="playstaion.php" class="btn btn-primary btn-lg mb-2">
            بلاستيسشن
        </a>
        <div class="row">
            <?php
            if (mysqli_num_rows($playstationQueryResult) > 0) {
                while ($playstationRows = mysqli_fetch_assoc($playstationQueryResult)) {

            ?>
                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-md font-weight-bold text-primary text-uppercase mb-1">
                                            <?= $playstationRows['playstation_type'] ?>
                                        </div>
                                        <div class="text-md font-weight-bold text-primary text-uppercase mt-2">
                                            <?= $playstationRows['controllers_type'] ?>
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?= $playstationRows['price_per_hour'] ?>
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
        <!-- End Playstaion Content  -->

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