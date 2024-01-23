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
    $productsQuery = "SELECT cp.product_name, cpo.quantity, cpo.each_price, cpo.total_price AS product_total_price
                      FROM cafe_products_orders cpo
                      JOIN cafe_products cp ON cpo.cafe_product_id = cp.id
                      WHERE cpo.cafe_order_id = $orderId";

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
                                <td><?= $product['product_name'] ?></td>
                                <td><?= $product['quantity'] ?></td>
                                <td><?= $product['each_price'] ?></td>
                                <td><?= $product['product_total_price'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Add a form for adding more products -->
                <div class="container">
                    <div class="col-md-6 offset-md-3">
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
                        <form method="post" action="pages/update_cafe_order.php?order_id=<?= $orderId ?>&old_price=<?= $orderDetails['total_price'] ?>">
                            <h2>إضافة منتج جديد للطلب</h2>
                            <div class="form-group mb-3">
                                <label for="productselect">اختر منتج إضافي</label>
                                <!-- You can populate the dropdown dynamically from the database -->
                                <select class="form-control" id="productselect" name="Product">
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="additionalQuantity">الكمية</label>
                                <input type="number" class="form-control" id="additionalQuantity" name="Quantity" required min="1" value="1">
                            </div>
                            <div class="form-group">
                                <div id="additionalProductFieldsContainer"></div>
                            </div>
                            <button type="submit" class="btn btn-primary mb-3" id="addclick">إضافة المنتج</button>
                        </form>
                        <button type="button" class="btn btn-secondary" id="addMoreProductsBtn">إضافة منتجات آخرى للطلب </button>
                        <div class="form-group mt-3">
                            <a href="all_orders.php" class="btn btn-danger"> رجوع للخلف</a>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Content Row -->
        </div>
        <!-- /.container-fluid -->


        <script>
            document.getElementById("addclick").addEventListener('click', function(event) {
                // event.preventDefault();
                alert("جاري تعديل الاوردر رقم ")
            });

            document.getElementById("addMoreProductsBtn").addEventListener("click", function() {
                addMoreProductFields();
            });

            /// Fetch products and populate the dropdown
            fetch("pages/get_cafe_porducts.php")
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                }).then(data => {
                    var productselect = document.getElementById('productselect');
                    // clear exisiting options
                    productselect.innerHTML = '';

                    // Add a default option
                    var defaultOption = document.createElement('option');
                    defaultOption.value = "";
                    defaultOption.text = "برجاء اختيار المنتج";
                    productselect.appendChild(defaultOption);

                    // Add options based on the fetched data
                    data.forEach(product => {
                        var optionElement = document.createElement('option');
                        optionElement.value = product.id; // Adjust this based on your product data
                        optionElement.text = product.product_name; // Adjust this based on your product data
                        productselect.appendChild(optionElement);
                    });
                })
                .catch(error => console.error('Error fetching product options:', error));

            // Function To addmoreFields 
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
        </script>
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