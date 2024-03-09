<?php
session_start();

$page_title = "Add cafe Order";
if (isset($_SESSION['username'])) {
    require_once("inc/header.php");
    // require_once("inc/sidebar.php");
    // require_once("inc/navbar.php");
    require_once("DB/db_config.php");




?>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- ... Your existing HTML code ... -->
        <div class="container mt-5">

            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="d-sm-flex align-items-center justify-content-center mb-4">
                        <h1 class="h3 mb-0 text-gray-900">اضافة المنتج </h1>
                    </div>
                    <?php
                    if (isset($_SESSION['message']) || isset($_SESSION['message'])) {
                    ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong> ياعم فوق بقا فوق </strong> <span class="alert-message"> <?= $_SESSION['message'] ?></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php }
                    unset($_SESSION['message']);
                    ?>
                    <?php
                    if (isset($_SESSION['done']) || isset($_SESSION['done'])) {
                    ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>
                                جدع يالفتة والله
                            </strong> <span class="alert-message"> <?= $_SESSION['done'] ?></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php }
                    unset($_SESSION['done']);
                    ?>
                    <form method="post" action="admin/stocks/addCafeProduct.php">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">اسم المشروب</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="product_name" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">سعر المنتج </label>
                            <input type="number" class="form-control" id="exampleInputPassword1" min="1" name="product_price" required>
                        </div>
                        <button type="submit" class="btn btn-primary">اضافة</button>
                    </form>
                    <!-- Add more products button -->
                    <div class="form-group mt-3">
                        <a href="cafeMenu.php" class="btn btn-danger"> رجوع للخلف</a>
                    </div>

                    <!-- Container to dynamically add more product fields -->
                </div>
            </div>
        </div>

        <!-- ... Your existing PHP code ... -->

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