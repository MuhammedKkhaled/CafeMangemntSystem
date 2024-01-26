<?php
session_start();
$page_title = 'تعديل المخزن';
if (isset($_SESSION['username'])) {

    if ($_SESSION['is_admin'] != 0) {
        require_once("inc/header.php");
        // require_once("inc/sidebar.php");
        // require_once("inc/navbar.php");
        require_once("DB/db_config.php");

        $product_id = $_GET['product_id'];
        $selectQuery = "SELECT * FROM stocks WHERE id =$product_id";
        $result = mysqli_query($conn, $selectQuery);
        $row = mysqli_fetch_assoc($result);
?>

        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <h1 class="h3 mb-4 text-gray-800">إضافة منتج للمخازن</h1>
                        <!-- Add Product to Stocks Form -->
                        <form id="addProductForm" method="post" action="admin/stocks/updateProduct.php?product_id=<?= $product_id  ?>">
                            <div class="form-group">
                                <label for="product_name">اسم المنتج </label>
                                <input type="text" class="form-control" id="product_name" name="product_name" required value="<?= $row['product_name']  ?>">
                            </div>
                            <div class="form-group">
                                <label for="quantity">الكمية</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required value="<?= $row['quantity']  ?>">
                            </div>
                            <div class="form-group">
                                <label for="product_price">سعر المنتج </label>
                                <input type="number" class="form-control" id="product_price" name="product_price" required value="<?= $row['product_price']  ?>">
                            </div>
                            <div class="form-group">
                                <label for="product_price">نوع المنتج </label>
                                <input type="text" class="form-control" id="type" name="type" required value="<?= $row['type']  ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Add Product</button>
                        </form>
                        <div id="resultMessage"></div>
                    </div>
                </div>
            </div>
            <!-- Display Stocks Table -->
        </div>
        <!-- /.container-fluid -->


<?php
        require_once("inc/footer.php");
        require_once("inc/scripts.php");
    } else {
        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
