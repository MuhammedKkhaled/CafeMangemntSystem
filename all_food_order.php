<?php

session_start();
$page_title = 'All Food Orders';

if (isset($_SESSION['username'])) {
    require_once("inc/header.php");
    require_once("inc/sidebar.php");
    require_once("inc/navbar.php");
    require_once("DB/db_config.php");

    // Get the current date and user ID for the logged-in user
    $currentDate = date("Y-m-d");
    $userId = $_SESSION["user_id"];

    // Get the food orders created today by the logged-in user
    $query = "SELECT * FROM `food_orders` WHERE DATE(`created_at`) = '$currentDate' AND `user_id` = $userId";

    // Apply the query
    $result = mysqli_query($conn, $query);

?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-center mb-4">
            <h1 class="h3 mb-0 text-gray-900">تفاصيل طلبات الطعام اليوم</h1>
        </div>

        <!-- Content Row -->
        <div class="row align-items-center justify-content-center">
            <?php
            if (mysqli_num_rows($result) > 0) {
                $iterator = 0;
            ?>
                <table class="table table-striped">
                    <thead>
                        <tr class="text-gray-800">
                            <th scope="col">رقم الاوردر</th>
                            <th scope="col">سعر الاوردر</th>
                            <th scope="col">كود الاوردر</th>
                            <th scope="col">حركات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($rows = mysqli_fetch_assoc($result)) { ?>
                            <tr class="">
                                <th scope="row"> <?= ++$iterator ?></th>
                                <td><?= $rows['total_price'] ?></td>
                                <td>
                                    <?= $rows['id'] ?>
                                </td>
                                <td>
                                    <a href="food_order_details.php?id=<?= $rows["id"] ?>" class="btn btn-success"> تفصايل الطلب </a>
                                    <a href="edit_food_order.php?id=<?= $rows["id"] ?>" class="btn btn-info">تعديل </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php
            } else { ?>
                <div class="alert alert-danger">
                    لا يوجد طلبات لهذا المستخدم في هذا اليوم حتى الآن
                </div>
            <?php }
            ?>
        </div>
        <!-- Content Row -->

        <!-- Content Row -->
        <a href="foodcar.php" class="btn btn-danger">عودة للخلف</a>
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