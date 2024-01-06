<?php
session_start();

$page_title = "Add cafe Order";
if (isset($_SESSION['username'])) {
    require_once("inc/header.php");
    // require_once("inc/sidebar.php");
    // require_once("inc/navbar.php");
    require_once("DB/db_config.php");


    //// Get the Full cafe_products 


?>


    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-center mb-4">
            <h1 class="h3 mb-0 text-gray-900">طلب الاوردر</h1>
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
        <!-- <div class="row d-sm-flex align-items-center justify-content-between mb-4">
            <div class="col-md-4">
                <a href="add_cafe_order" class="btn-lg mb-2 text-center btn btn-primary">
                    اضافة طلب
                </a>
            </div>
            <div class="col-md-4 text-center">
                <h1 class="h5 mb-0 text-gray-800">المنيو</h1>
            </div>
            <div class="col-md-4"></div>
        </div> -->

        <!-- <div class="row">

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-md font-weight-bold text-primary text-uppercase mb-1">
                                    Hamada Yel3ab
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Akhoya
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-coffee fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->


        <!-- Content Row -->

        <!-- Content Row -->
        <!-- chatGpt Content -->

        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form id="addOrderForm">
                    <div class="form-group">
                        <label for="productSelect">اختر المنتج</label>
                        <select class="form-control" id="productSelect" name="product">

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantityInput">الكمية</label>
                        <input type="number" class="form-control" id="quantityInput" name="quantity" required>
                    </div>
                    <button type="submit" class="btn btn-primary">إضافة الطلب</button>
                </form>

                <!-- Add more products button -->
                <button type="button" class="btn btn-secondary mt-3" id="addMoreProductsBtn">إضافة منتجات أخرى</button>
            </div>
        </div>
        <!-- End Add Order Form -->

        <!-- Add your JavaScript code here to handle form submission and other interactions -->
        <script>
            // Example JavaScript code for handling form submission
            document.getElementById('addOrderForm').addEventListener('submit', function(event) {
                event.preventDefault();
                // Add your logic to handle form submission using AJAX or other methods
                alert('Order added successfully!');
            });

            // Example JavaScript code for handling "Add more products" button click
            document.getElementById('addMoreProductsBtn').addEventListener('click', function() {
                // Add your logic to handle adding more products, e.g., show/hide additional form fields
                alert('Add more products logic goes here!');
            });
        </script>
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