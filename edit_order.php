<?php
session_start();
$page_title = 'Edit Order';

if (isset($_SESSION['username'])) {
    require_once("inc/header.php");
    require_once("inc/sidebar.php");
    require_once("inc/navbar.php");
    require_once("DB/db_config.php");

    // Get the order ID from the GET request
    $orderId = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Query to get order details
    $orderQuery = "SELECT co.id AS order_id, co.total_price
                   FROM cafe_orders co
                   WHERE co.id = $orderId";

    // Query to get all products for the given order
    $productsQuery = "SELECT fp.food_name as 'Product Name', cpo.quantity , cpo.each_price, cpo.total_price 
    FROM cafe_products_orders AS cpo 
    JOIN foodcar_products AS fp ON cpo.food_product_id = fp.id 
    WHERE cafe_order_id= $orderId  AND food_product_id IS NOT NULL 
    
    
    UNION 
    
    SELECT cp.product_name, cpo.quantity , cpo.each_price, cpo.total_price 
    FROM cafe_products_orders AS cpo 
    JOIN cafe_products AS cp ON cpo.cafe_product_id = cp.id 
    WHERE cafe_order_id= $orderId  AND cafe_product_id IS NOT NULL";

    // Apply the queries
    $orderResult = mysqli_query($conn, $orderQuery);
    $productsResult = mysqli_query($conn, $productsQuery);

    // Check if the order exists
    if (mysqli_num_rows($orderResult) > 0) {
        $orderDetails = mysqli_fetch_assoc($orderResult);
?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-center mb-4">
                <h1 class="h3 mb-0 text-gray-900">تفاصيل الطلب رقم <?= $orderId ?></h1>
            </div>
            <!-- Content Row -->
            <div class="row align-items-center justify-content-center">
                <!-- Display existing order details in read-only fields -->
                <div class="form-group">
                    <label for="orderTotalPrice">سعر الطلب</label>
                    <input type="text" class="form-control" id="orderTotalPrice" name="orderTotalPrice" value="<?= $orderDetails['total_price'] ?>" readonly>
                </div>

                <!-- Display existing order product details in a table -->
                <table class="table table-striped">
                    <thead>
                        <tr class="text-gray-800">
                            <th scope="col">اسم المنتج</th>
                            <th scope="col">الكمية</th>
                            <th scope="col">سعر الوحدة</th>
                            <th scope="col">السعر الإجمالي للمنتج</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($product = mysqli_fetch_assoc($productsResult)) {
                        ?>
                            <tr>
                                <td><?= $product['Product Name'] ?></td>
                                <td><?= $product['quantity'] ?></td>
                                <td><?= $product['each_price'] ?></td>
                                <td><?= $product['total_price'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Add a form for adding more products -->
                <div class="container mt-5">

                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="d-sm-flex align-items-center justify-content-center mb-4">
                                <h1 class="h3 mb-0 text-gray-900">إضافة منتجات اخري للطلب</h1>
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
                            <form id="addOrderForm" method="post" action="Pages/update_cafe_order.php">
                                <div class="form-group">
                                    <label for="productSelect"> اختر المنتج الرئيسي</label>
                                    <!-- <input type="text" name="productName" id="" class="form-control" autocomplete="off"> -->
                                    <select class="form-control" id="productSelect" name="product">
                                        <option value="0">برجاء اختيار المنتج</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="quantityInput">الكمية</label>
                                    <input type="number" class="form-control" id="quantityInput" name="quantity" required min="1" value="1">
                                </div>
                                <div class="form-group">
                                    <div id="additionalProductFieldsContainer"></div>
                                </div>
                                <button type="submit" class="btn btn-primary" id="addclick">إضافة الطلب</button>
                            </form>
                            <!-- Add more products button -->

                            <button type="button" class="btn btn-secondary mt-3" id="addMoreProductsBtn">إضافة منتجات آخرى للطلب </button>
                            <button type="button" class="btn btn-secondary mt-3" id="addMoreProductsFood">إضافة منتجات من عربية الاكل </button>
                            <div class="form-group mt-3">
                                <a href="all_orders.php" class="btn btn-danger"> رجوع للخلف</a>
                            </div>

                            <!-- Container to dynamically add more product fields -->
                        </div>
                    </div>
                </div>


                <script>
                    // Example JavaScript code for handling form submission
                    document.getElementById('addclick').addEventListener('click', function(event) {
                        // event.preventDefault();
                        // Add your logic to handle form submission using AJAX or other methods
                        alert('جاري اضافة طلب العميل متنساش تضحك في وشه بقا ');
                    });

                    // Example JavaScript code for handling "Add more products" button click
                    document.getElementById('addMoreProductsBtn').addEventListener('click', function() {
                        // Add your logic to handle adding more products, e.g., show/hide additional form fields
                        addMoreProductFields();
                    });

                    /// Related With food car
                    document.getElementById('addMoreProductsFood').addEventListener('click', function() {
                        // Add your logic to handle adding more products, e.g., show/hide additional form fields
                        addMoreProductFoodFields();
                    });
                    // Fetch products and populate the dropdown
                    fetch('pages/get_cafe_porducts.php')
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! Status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            var productSelect = document.getElementById('productSelect');

                            // Clear existing options (if any)
                            productSelect.innerHTML = '';

                            // Add a default option
                            var defaultOption = document.createElement('option');
                            defaultOption.value = '';
                            defaultOption.text = 'برجاء اختيار المنتج';
                            productSelect.appendChild(defaultOption);

                            // Add options based on the fetched data
                            data.forEach(product => {
                                var optionElement = document.createElement('option');
                                optionElement.value = product.id; // Adjust this based on your product data
                                optionElement.text = product.product_name; // Adjust this based on your product data
                                productSelect.appendChild(optionElement);
                            });
                        })
                        .catch(error => console.error('Error fetching product options:', error));

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
            <!-- Content Row -->
        </div>
        <!-- /.container-fluid -->

<?php
    } else {
        // Order not found, display an error message
        echo '<div class="alert alert-danger">الطلب غير موجود.</div>';
    }

    require_once("inc/footer.php");
    require_once("inc/scripts.php");
} else {
    header("Location: index.php");
    exit();
}
?>