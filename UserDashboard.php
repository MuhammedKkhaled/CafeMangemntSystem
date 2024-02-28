<?php
session_start();

$page_title = "Menu Page ";
if (isset($_SESSION['username'])) {
    require_once("inc/header.php");
    require_once("inc/sidebar.php");
    require_once("inc/navbar.php");
    require_once("DB/db_config.php");



?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">الاصناف </h1>
        </div>
        <!-- Content Row -->
        <!-- Begin Cafe Content -->
        <a href="add_cafe_order.php" class="btn btn-primary btn-lg mb-5">
            تيك اوي
        </a>
        <!-- Begin Food Car Content  -->
        <a href="add_food_order.php" class="btn btn-primary btn-lg mb-5">
            ترابيزات
        </a>
        <!-- End Food Car Content  -->
        <!-- Begin Playstaion Content  -->
        <a href="add_playstaion_order.php" class="btn btn-primary btn-lg mb-5">
            بلاستيسشن
        </a>
        <!-- End Playstaion Content  -->
        <!-- Content Row -->
        <!-- Content Row -->
    </div>
    <!-- /.container-fluid -->

    <style>
        /* Add CSS for space between links */
        .container-fluid {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            /* تحديد محور العناصر ليكون على اليمين */
        }

        .container-fluid a {
            display: block;
            margin-bottom: 20px;
            padding: 10px 20px;
            /* تحديد حجم الهامش الداخلي للأزرار */
            border-radius: 5px;
            /* تقويس زوايا الأزرار */
            background-color: #007bff;
            /* لون خلفية الأزرار */
            color: #fff;
            /* لون نص الأزرار */
            text-decoration: none;
            /* إزالة تأثير التحتية */
            transition: background-color 0.3s;
            /* تغيير لون الخلفية بشكل سلس عند التحويل */
        }

        .container-fluid a:hover {
            background-color: #0056b3;
            /* لون الخلفية عند تحويل المؤشر */
        }

        /* تغيير المسافة بين كل زر والآخر */
        .container-fluid a+a {
            margin-bottom: 15px;
        }
    </style>



<?php
    require_once("inc/footer.php");
    require_once("inc/scripts.php");
} else {
    header("Location: index.php");
    exit();
}
?>