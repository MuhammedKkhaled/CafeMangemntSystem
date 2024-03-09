<?php
session_start();

$page_title = "Playstation Menu ";
if (isset($_SESSION['username'])) {
    require_once("inc/header.php");
    require_once("inc/sidebar.php");
    require_once("inc/navbar.php");
    require_once("DB/db_config.php");


    //// Get the Full cafe_products 
    $query = "SELECT * FROM `playstation_configuration`  ";

    // execute the query 
    $result = mysqli_query($conn, $query);

?>


    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-center mb-4">
            <h1 class="h3 mb-0 text-gray-900">اسعار البلاستيشن</h1>

        </div>
        <!-- Content Row -->


        <div class="row">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {


            ?>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <a href="adminEdit_playstation_products.php?product_id=<?= $row['id'] ?>">
                            <!-- Earnings (Monthly) Card Example -->
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">

                                    <div class="row no-gutters align-items-center">

                                        <div class="col mr-2">
                                            <div class="text-md font-weight-bold text-primary text-uppercase mb-1">
                                                <?= $row['playstation_type'] ?>
                                            </div>
                                            <div class="text-md font-weight-bold text-primary text-uppercase mb-1">
                                                <?= $row['controllers_type'] ?>
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?= $row['price_per_hour'] ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-coffee fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
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