<?php
session_start();

$page_title = 'Edit Playstation Order';

if (isset($_SESSION['username'])) {
    require_once("inc/header.php");
    require_once("inc/sidebar.php");
    require_once("inc/navbar.php");
    require_once("DB/db_config.php");

    // Get the order ID from the GET request
    $orderId = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
    $session_id = isset($_GET['session_id']) ? intval($_GET['session_id']) : 0;
    $old_price = isset($_GET['old_price']) ? intval($_GET['old_price']) : 0;
    $room_id = $_GET['room_id'];

    /// Query to get the session and display it 
    $sessionQuery = "SELECT * FROM `playstation_session` WHERE `id`=$session_id";
    $sessionQueryResult = mysqli_query($conn, $sessionQuery);

    //Query To Get The cafe_proudcts If Is not null (Or Exist In playstation_product_order table)
    $ProductsInPlaystationOrderQuery = " SELECT fp.food_name, ppo.qunatity , ppo.each_price, ppo.total_price
    FROM playstation_product_order AS ppo
    JOIN foodcar_products AS fp ON ppo.foodcar_product_id = fp.id
    WHERE playstation_session_id = $session_id AND foodcar_product_id IS NOT NULL
    
    UNION ALL
    
    SELECT  cp.product_name, ppo.qunatity , ppo.each_price, ppo.total_price
    FROM playstation_product_order AS ppo
    JOIN cafe_products AS cp ON ppo.cafe_product_id = cp.id
    WHERE playstation_session_id = $session_id AND cafe_product_id IS NOT NULL; ";

    $ProductsInPlaystationOrderQueryResult = mysqli_query($conn, $ProductsInPlaystationOrderQuery);


?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- <a href="pages/end_playstation_session.php?orderId=<?= $orderId ?>&session_id=<?= $session_id ?>&old_price=<?= $old_price ?>&room_id=<?= $room_id ?>" class="btn btn-primary" id="endcalculations">
            تخليص الحساب
        </a> -->

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-center mb-4">
            <h1 class="h3 mb-0 text-gray-900">تفاصيل الطلب رقم <?= $orderId ?></h1>

        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="form-group">
                <label for="orderTotalPrice">سعر الطلب</label>
                <input type="text" class="form-control" id="orderTotalPrice" name="orderTotalPrice" value="<?= $old_price ?>" readonly>
            </div>
        </div>
        <div class="row align-items-center justify-content-center text-gray-900">
            <h5>
                تفاصيل البلاستيشن من غير الطلبات اللي موجودة فيه
            </h5>
            <!-- Begin The Orders -->
            <!-- Begin The playstation_session -->
            <?php
            if (mysqli_num_rows($sessionQueryResult) > 0) {
                $rows = mysqli_fetch_assoc($sessionQueryResult)
            ?>
                <table class="table table-striped">
                    <thead>
                        <tr class="text-gray-800">
                            <th scope="col">نوع الجهاز</th>
                            <th scope="col"> عدد الدرعات</th>
                            <th scope="col">بادئ الساعة كام </th>
                            <th scope="col">
                                <?php
                                if ($rows["end_time"] == "0000-00-00 00:00:00") {
                                    echo "لسا مخلصش القعدة بتاعته ";
                                } else {

                                    echo "خلص قعدته ";
                                }
                                ?>
                            </th>
                            <th scope="col">
                                السعر الاساسي للساعة
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="">
                            <td><?= $rows['playstation_type'] ?></td>
                            <td><?= $rows['controllers_type'] ?></td>
                            <td><?= date('H:i:s', strtotime($rows['start_time'])) ?></td>
                            <td><?= date('H:i:s', strtotime($rows['end_time'])) ?></td>
                            <td><?= $rows['base_price_for_this_confgurations'] ?></td>
                            <?php
                            // $totalOrderPrice += $rows['product_total_price'];
                            ?>
                        </tr>
                        <tr class="text-gray-800">
                            <td colspan="3" class="text-right"><strong>السعر الإجمالي للطلب</strong></td>
                            <td>
                                <?php
                                if ($rows['total_price'] == 0) {
                                    echo  "لسا ماحسبش";
                                } else {
                                    echo $rows['total_price'];
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            <?php
            }
            ?>
            <!-- end The playstation_session -->
            <hr style="margin-top: 20px; margin-bottom: 20px; border-color: #ccc;">

            <?php
            if ($old_price > 0) {
            ?>
                <h5>
                    تفاصيل الطلبات اللي موجودة في الطلب نفسه
                </h5>
                <?php
                if (mysqli_num_rows($ProductsInPlaystationOrderQueryResult)) {

                ?>
                    <table class="table table-striped">
                        <thead>
                            <tr class="text-gray-800">
                                <th scope="col"> اسم المنتج </th>
                                <th scope="col"> الكمية</th>
                                <th scope="col">سعر المنتج</th>
                                <th scope="col">السعر النهائي</th>

                            </tr>
                        </thead>
                        <?php
                        $totalOrderPrice = 0;
                        while ($rows = mysqli_fetch_assoc($ProductsInPlaystationOrderQueryResult)) {
                        ?>
                            <tbody>
                                <tr class="">
                                    <td><?= $rows['food_name'] ?></td>
                                    <td><?= $rows['qunatity'] ?></td>
                                    <td><?= $rows['each_price'] ?></td>
                                    <td><?= $rows['total_price'] ?></td>
                                    <?php
                                    $totalOrderPrice += $rows['total_price'];
                                    ?>
                                </tr>
                            <?php } ?>
                            <tr class="text-gray-800">
                                <td colspan="3" class="text-right"><strong>السعر الإجمالي للطلب</strong></td>
                                <td><?= $totalOrderPrice ?></td>
                            </tr>
                            </tbody>
                    </table>
            <?php
                }
            }
            ?>
            <!-- End The Orders -->
        </div>
        <!-- Content Row -->
        <a href="all_playstation_order.php" class="btn btn-danger">عودة</a>

        <!-- Add a form for adding more products -->
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="d-sm-flex align-items-center justify-content-center mb-4">
                        <h1 class="h3 mb-0 text-gray-900"> اضافة منتج للطلب الخاص بالبلاستيشن</h1>
                    </div>
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
                    <form id="addOrderForm" method="post" action="Pages/update_playstation_order.php?orderid=<?= $orderId ?>&session_id=<?= $session_id ?>&old_price=<?= $old_price ?>">
                        <div class="form-group">
                            <div id="additionalProductFieldsContainer"></div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="addclick">إضافة الطلب</button>
                    </form>
                    <!-- Add more products button -->

                    <button type="button" class="btn btn-secondary mt-3" id="addMoreProductsBtn">إضافة منتجات من الكافيه</button>
                    <button type="button" class="btn btn-secondary mt-3" id="addMoreProductsFood">إضافة منتجات من عربية الاكل </button>
                    <div class="form-group mt-3">
                        <a href="all_playstation_order.php" class="btn btn-danger"> رجوع للخلف</a>
                    </div>

                    <!-- Container to dynamically add more product fields -->
                </div>
            </div>
        </div>
        <script>
            // Example JavaScript code for handling form submission
            document.getElementById('addclick').addEventListener('click', function(event) {
                // Add your logic to handle form submission using AJAX or other methods
                var orderNumber = "<?= $orderId ?>";
                alert('جاري تعديل الطلب رقم ' + orderNumber);
            });
            document.getElementById('endcalculations').addEventListener('click', function(event) {
                // Add your logic to handle form submission using AJAX or other methods
                var orderNumber = "<?= $orderId ?>";
                alert('جاري انهاء الطلب رقم ' + orderNumber);
            });

            // Example JavaScript code for handling "Add more products" button click (Related With Cafe)
            document.getElementById('addMoreProductsBtn').addEventListener('click', function() {
                // Add your logic to handle adding more products, e.g., show/hide additional form fields
                addMoreProductFields();
            });

            /// Related With food car
            document.getElementById('addMoreProductsFood').addEventListener('click', function() {
                // Add your logic to handle adding more products, e.g., show/hide additional form fields
                addMoreProductFoodFields();
            });

            function addMoreProductFields() {
                // Create new label for the dropdown menu
                var newProductLabel = document.createElement('label');
                newProductLabel.innerHTML = 'اختر المنتج';
                newProductLabel.setAttribute('for', 'additionalProduct[]');

                // Create new dropdown menu
                var newProductSelect = document.createElement('select');
                newProductSelect.className = 'form-control';
                newProductSelect.name = 'additionalProduct[]'; // Use an array to handle multiple selections

                // TODO: Add options to the new dropdown menu (you can fetch these dynamically from your database)
                fetch('pages/get_cafe_porducts.php')
                    .then(response => response.json())
                    .then(data => {
                        // Populate the dropdown menu with options
                        data.forEach(option => {
                            var optionElement = document.createElement('option');
                            optionElement.value = option.id; // Set the value based on your product data
                            optionElement.text = option.product_name; // Set the display text based on your product data
                            newProductSelect.appendChild(optionElement);
                        });
                    })
                    .catch(error => console.error('Error fetching product options:', error));

                // Create new label for the quantity input field
                var newQuantityLabel = document.createElement('label');
                newQuantityLabel.innerHTML = 'الكمية';
                newQuantityLabel.setAttribute('for', 'additionalQuantity[]');

                // Create new quantity input field
                var newQuantityInput = document.createElement('input');
                newQuantityInput.type = 'number';
                newQuantityInput.className = 'form-control';
                newQuantityInput.name = 'additionalQuantity[]'; // Use an array to handle multiple inputs
                newQuantityInput.required = true;
                newQuantityInput.value = 1;
                newQuantityInput.min = 1;

                // Append the new labels and fields to the container
                document.getElementById('additionalProductFieldsContainer').appendChild(newProductLabel);
                document.getElementById('additionalProductFieldsContainer').appendChild(newProductSelect);
                document.getElementById('additionalProductFieldsContainer').appendChild(newQuantityLabel);
                document.getElementById('additionalProductFieldsContainer').appendChild(newQuantityInput);
            }


            function addMoreProductFoodFields() {
                // Create new label for the dropdown menu
                var newProductLabel = document.createElement('label');
                newProductLabel.innerHTML = 'اختر المنتج من قائمة الطعام';
                newProductLabel.setAttribute('for', 'additionalfoodproducts[]');

                // Create new dropdown menu
                var newProductSelect = document.createElement('select');
                newProductSelect.className = 'form-control';
                newProductSelect.name = 'additionalfoodproducts[]'; // Use an array to handle multiple selections

                // TODO: Add options to the new dropdown menu (you can fetch these dynamically from your database)
                fetch('pages/get_food_car_products.php')
                    .then(response => response.json())
                    .then(data => {
                        // Populate the dropdown menu with options
                        data.forEach(option => {
                            var optionElement = document.createElement('option');
                            optionElement.value = option.id; // Set the value based on your product data
                            optionElement.text = option.food_name; // Set the display text based on your product data
                            newProductSelect.appendChild(optionElement);
                        });
                    })
                    .catch(error => console.error('Error fetching product options:', error));

                // Create new label for the quantity input field
                var newQuantityLabel = document.createElement('label');
                newQuantityLabel.innerHTML = 'الكمية';
                newQuantityLabel.setAttribute('for', 'additionalFoodQuantity[]');

                // Create new quantity input field
                var newQuantityInput = document.createElement('input');
                newQuantityInput.type = 'number';
                newQuantityInput.className = 'form-control';
                newQuantityInput.name = 'additionalFoodQuantity[]'; // Use an array to handle multiple inputs
                newQuantityInput.required = true;
                newQuantityInput.value = 1;
                newQuantityInput.min = 1;

                // Append the new labels and fields to the container
                document.getElementById('additionalProductFieldsContainer').appendChild(newProductLabel);
                document.getElementById('additionalProductFieldsContainer').appendChild(newProductSelect);
                document.getElementById('additionalProductFieldsContainer').appendChild(newQuantityLabel);
                document.getElementById('additionalProductFieldsContainer').appendChild(newQuantityInput);
            }
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