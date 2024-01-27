<?php
session_start();
$page_title = 'المستخدمين الحاليين';
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
                        <h1 class="h3 mb-4 text-gray-800">إضافة مستخدم للنظام</h1>
                        <!-- Add Product to Stocks Form -->
                        <form id="addProductForm" method="post" action="admin/stocks/addUser.php">
                            <div class="form-group">
                                <label for="userName">اسم المستخدم </label>
                                <input type="text" class="form-control" id="userName" name="userName" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="email">الايميل</label>
                                <input type="email" class="form-control" id="email" name="email" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="password">الباسورد</label>
                                <input type="password" class="form-control" id="password" name="password" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="admin">اختار نوع المستخدم</label>
                                <select class="form-control" id="admin" name="is_admin" required>
                                    <option value="">برجاء اختيار نوع المستخدم </option>
                                    <option value="1">ادمن </option>
                                    <option value="0">مستخدم عادي </option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">اضافة مستخدم جديد</button>
                        </form>


                        <div id="resultMessage"></div>
                    </div>
                </div>
            </div>
            <!-- Display Stocks Table -->
            <div class="mt-4">
                <?php
                if (isset($_SESSION['error_message'])) {
                ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong> ياعم فوق بقا فوق </strong> <span class="alert-message"> <?= $_SESSION['error_message'] ?></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php }
                unset($_SESSION['error_message']);
                ?>
                <h2>جدول المستخدمين</h2>
                <table class="table" id="stocksTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">اسم المستخدم</th>
                            <th scope="col">الايميل </th>
                            <th scope="col">نوع المستخدم</th>
                            <th scope="col">تاريخ الإنشاء</th>
                            <th scope="col">حركات </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $iterator = 0;
                        // Retrieve and display stocks data from the database
                        $selectQuery = "SELECT * FROM users";
                        $result = mysqli_query($conn, $selectQuery);
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<th scope='row'>" . ++$iterator . "</th>";
                                echo "<td>" . $row['username'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                if ($row['is_admin'] == 1) {
                                    echo "<td>" . "ادمن" . "</td>";
                                } else {
                                    echo "<td>" . "مستخدم عادي" . "</td>";
                                }
                        ?>
                                <?php
                                echo "<td>" . $row['created_at'] . "</td>";
                                ?>
                                <td class="d-flex justify-content-between">
                                    <a href="admin/stocks/deleteUser.php?user_id=<?= $row['id'] ?>" class="btn btn-danger mr-2 btn-sm"> مسح المستخدم من النظام</a>
                                    <a href="admin/stocks/makeUserAdmin.php?user_id=<?= $row['id'] ?>&is_admin=<?= $row['is_admin'] ?>" class="btn btn-success mr-2 btn-sm"> تحويل المستخدم لادمن</a>
                                    <a href="admin_edit_user_page.php?user_id=<?= $row['id'] ?>" class="btn btn-info btn-sm"> تعديل المستخدم</a>
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
