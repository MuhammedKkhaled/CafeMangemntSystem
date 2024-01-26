<?php
session_start();
$page_title = 'المخازن';
if (isset($_SESSION['username'])) {

    if ($_SESSION['is_admin'] != 0) {
        require_once("inc/header.php");
        require_once("inc/sidebar.php");
        require_once("inc/navbar.php");
        require_once("DB/db_config.php");
?>

        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <h1 class="h3 mb-4 text-gray-800">إضافة منتج للمخازن</h1>
                        <!-- Add Product to Stocks Form -->
                        <form id="addProductForm" method="post" action="admin/stocks/add_product.php">
                            <div class="form-group">
                                <label for="product_name">اسم المنتج </label>
                                <input type="text" class="form-control" id="product_name" name="product_name" required>
                            </div>
                            <div class="form-group">
                                <label for="quantity">الكمية</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                            </div>
                            <div class="form-group">
                                <label for="product_price">سعر المنتج </label>
                                <input type="number" class="form-control" id="product_price" name="product_price" required>
                            </div>
                            <div class="form-group">
                                <label for="product_price">نوع المنتج </label>
                                <input type="text" class="form-control" id="type" name="type" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Product</button>
                        </form>
                        <div id="resultMessage"></div>
                    </div>
                </div>
            </div>
            <!-- Display Stocks Table -->
            <div class="mt-4">
                <h2>جدول المخازن</h2>
                <table class="table" id="stocksTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">اسم المنتج</th>
                            <th scope="col">الكمية</th>
                            <th scope="col">سعر المنتج</th>
                            <th scope="col">نوع المنتج</th>
                            <th scope="col">تاريخ الإنشاء</th>
                            <th scope="col">حركات </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $iterator = 0;
                        // Retrieve and display stocks data from the database
                        $selectQuery = "SELECT * FROM stocks";
                        $result = mysqli_query($conn, $selectQuery);
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<th scope='row'>" . ++$iterator . "</th>";
                                echo "<td>" . $row['product_name'] . "</td>";
                                echo "<td>" . $row['quantity'] . "</td>";
                                echo "<td>" . $row['product_price'] . "</td>";
                                echo "<td>" . $row['type'] . "</td>";
                                echo "<td>" . $row['created_at'] . "</td>";
                        ?>
                                <td>
                                    <a href="admin/stocks/deleteProduct.php?product_id=<?= $row['id'] ?>" class="btn btn-danger"> مسح المنتج</a>
                                    <a href="admin_edit_stock_page.php?product_id=<?= $row['id'] ?>" class="btn btn-info"> تعديل المنتج </a>
                                </td>
                        <?php
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>لا توجد بيانات في جدول المخازن</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
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
