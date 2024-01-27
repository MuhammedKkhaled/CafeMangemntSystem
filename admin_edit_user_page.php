<?php
session_start();
$page_title = 'تعديل ';
if (isset($_SESSION['username'])) {

    if ($_SESSION['is_admin'] != 0) {
        require_once("inc/header.php");
        // require_once("inc/sidebar.php");
        // require_once("inc/navbar.php");
        require_once("DB/db_config.php");

        $user_id = $_GET['user_id'];
        $selectQuery = "SELECT * FROM users WHERE id =$user_id";
        $result = mysqli_query($conn, $selectQuery);
        $row = mysqli_fetch_assoc($result);
?>

        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <h1 class="h3 mb-4 text-gray-800">تعديل المستخدم</h1>
                        <!-- Add Product to Stocks Form -->
                        <form id="addProductForm" method="post" action="admin/stocks/updateUser.php?user_id=<?= $user_id  ?>">
                            <div class="form-group">
                                <label for="userName">اسم المستخدم</label>
                                <input type="text" class="form-control" id="userName" name="userName" required value="<?= $row['username']  ?>">
                            </div>
                            <div class="form-group">
                                <label for="password">الرقم السري</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <input type="hidden" class="form-control" name="oldPassword" value="<?= $row['password']  ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">تعديل</button>
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
