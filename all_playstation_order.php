<?php
session_start();
$page_title = 'All Orders';

if (isset($_SESSION['username'])) {
    require_once("inc/header.php");
    require_once("inc/sidebar.php");
    require_once("inc/navbar.php");
    require_once("DB/db_config.php");

    /// get the current date and id for the registered user 
    $userId = $_SESSION["user_id"];

    /// get the orders where the session has end_time = '0000-00-00 00:00:00' and it's registered by the logged-in user
    $query = "SELECT po.id ,  po.playstation_session_id , po.order_price , po.room_id AS 'Room Number' FROM `playstation_orders` po
               JOIN `playstation_session` ps ON po.playstation_session_id = ps.id
              WHERE ps.end_time = '0000-00-00 00:00:00' AND po.user_id = $userId";

    /// apply the query
    $resultForNotEndedOrders = mysqli_query($conn, $query);


    $endedordersForSession = "SELECT po.id ,  po.playstation_session_id , po.order_price  FROM `playstation_orders` po
                                JOIN `playstation_session` ps ON po.playstation_session_id = ps.id
                               WHERE ps.end_time <> '0000-00-00 00:00:00' AND po.user_id = $userId";
    $endedOrdersForSessionResult = mysqli_query($conn, $endedordersForSession);
?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-center mb-4">
            <h1 class="h3 mb-0 text-gray-900">تفاصيل طلبات البلايستيشن </h1>
        </div>

        <h3 class="text-gray-900"> طلبات لسا محاسبتش</h3>
        <div class="row align-items-center justify-content-center">
            <?php
            if (mysqli_num_rows($resultForNotEndedOrders) > 0) {
                $iterator = 0;
            ?>
                <table class="table table-striped">
                    <thead>
                        <tr class="text-gray-800">
                            <th scope="col">رقم الاوردر</th>
                            <th scope="col">سعر الاوردر</th>
                            <th scope="col">كود الاوردر</th>
                            <th scope="col">رقم الغرفة</th>
                            <th scope="col">حركات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($rows = mysqli_fetch_assoc($resultForNotEndedOrders)) { ?>
                            <tr class="">
                                <th scope="row"> <?= ++$iterator ?></th>
                                <td><?= $rows['order_price'] ?></td>
                                <td>
                                    <?= $rows['id'] ?>
                                </td>
                                <td>
                                    <?= $rows['Room Number'] ?>
                                </td>
                                <td>
                                    <a href="playstation_order_details.php?session_id=<?= $rows['playstation_session_id'] ?>&order_id=<?= $rows['id'] ?>&old_price=<?= $rows['order_price'] ?>" class="btn btn-danger"> تفصايل الطلب </a>
                                    <a href="edit_playstation_order.php?session_id=<?= $rows["playstation_session_id"] ?>&order_id=<?= $rows['id'] ?>&old_price=<?= $rows['order_price'] ?>" class="btn btn-info">تعديل / حساب</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php
            } else { ?>
                <div class="alert alert-danger">
                    لا يوجد طلبات حتي الان لسا محاسبتش</div>
            <?php }
            ?>
        </div>

        <h3 class="text-gray-900"> طلبات خلصت وحاسبت ومشيت</h3>
        <div class="row align-items-center justify-content-center">
            <?php
            if (mysqli_num_rows($endedOrdersForSessionResult) > 0) {
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
                        while ($rows = mysqli_fetch_assoc($endedOrdersForSessionResult)) { ?>
                            <tr class="">
                                <th scope="row"> <?= ++$iterator ?></th>
                                <td><?= $rows['order_price'] ?></td>
                                <td>
                                    <?= $rows['playstation_session_id'] ?>
                                </td>
                                <td>
                                    <a href="playstation_order_details.php?session_id=<?= $rows['playstation_session_id'] ?>&order_id=<?= $rows['id'] ?>&old_price=<?= $rows['order_price'] ?>" class="btn btn-danger"> تفصايل الطلب </a>
                                    <a href="" class="btn btn-info">طباعة</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php
            } else { ?>
                <div class="alert alert-danger">
                    لا يوجد طلبات لهذا المستخدم حتى الآن
                </div>
            <?php }
            ?>
        </div>

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