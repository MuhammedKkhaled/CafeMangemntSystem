<?php
session_start();

$page_title = "Cafe Page";
if (isset($_SESSION['username'])) {
    require_once("inc/header.php");
    require_once("inc/sidebar.php");
    require_once("inc/navbar.php");
    require_once("DB/db_config.php");


    //// Get the Full cafe_products 
    $query = "SELECT * FROM `cafe_products`  ";

    // execute the query 
    $result = mysqli_query($conn, $query);

?>


    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-center mb-4">
            <h1 class="h3 mb-0 text-gray-900">الكافيه</h1>

        </div>
        <!-- Content Row -->

        <!-- Begin Cafe Content -->
        <!-- <a href="cafe.php" class="btn btn-primary btn-lg mb-2">
            الكافيه
        </a> -->
        <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4 ">
            <a href="add_cafe_order" class="btn-lg mb-2 text-center btn btn-primary">
                اضافة طلب
            </a>
            <h1 class="h5 mb-0 text-gray-800 text-center">المنيو</h1>
        </div> -->
        <div class="row d-sm-flex align-items-center justify-content-between mb-4">
            <div class="col-md-4">
                <a href="add_cafe_order.php" class="btn-lg mb-2 text-center btn btn-primary">
                    اضافة طلب
                </a>
            </div>
            <div class="col-md-4 text-center">
                <h1 class="h5 mb-0 text-gray-800">المنيو</h1>
            </div>
            <div class="col-md-4"></div>
        </div>

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