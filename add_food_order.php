<?php
session_start();

$page_title = "Add food Order";
if (isset($_SESSION['username'])) {
    require_once("inc/header.php");
    require_once("DB/db_config.php");
?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="d-sm-flex align-items-center justify-content-center mb-4">
                        <h1 class="h3 mb-0 text-gray-900">طلب الاوردر</h1>
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

                    <form id="addOrderForm" method="post" action="Pages/insert_food_car_order.php">
                        <div class="form-group">
                            <label for="tableSelect"> اختر الطاولة</label>
                            <select class="form-control" id="tableSelect" name="table">
                                <option value="0">برجاء اختيار الطاولة</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div id="additionalProductFieldsContainer"></div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="addclick">إضافة الطلب</button>
                    </form>

                    <!-- Add more products button -->
                    <button type="button" class="btn btn-secondary mt-3" id="addMoreProductsBtn">إضافة منتجات من العربية </button>
                    <button type="button" class="btn btn-secondary mt-3" id="addMoreCafeProductsBtn">إضافة منتجات من الكافيه </button>

                    <div class="form-group mt-3">
                        <a href="foodcar.php" class="btn btn-danger"> رجوع للخلف</a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Fetch available tables and populate the dropdown
            fetch('pages/get_tables_data.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error!  Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    var tableSelect = document.getElementById('tableSelect');

                    tableSelect.innerHTML = "";
                    // Add Default option
                    var defaultOption = document.createElement('option');
                    defaultOption.value = "";
                    defaultOption.text = "برجاء اختيار الطاولة";
                    tableSelect.appendChild(defaultOption);

                    data.forEach(table => {
                        if (table.is_available == 1) {
                            var optionElement = document.createElement('option');
                            optionElement.value = table.id;
                            optionElement.text = `Table ${table.table_number}`;
                            tableSelect.appendChild(optionElement);
                        }
                    });
                })
                .catch(error => console.error('Error fetching table data:', error));

            // Example JavaScript code for handling form submission
            document.getElementById('addclick').addEventListener('click', function(event) {
                alert('جاري اضافة طلب العميل متنساش تضحك في وشه بقا ');
            });

            // Example JavaScript code for handling "Add more products" button click
            document.getElementById('addMoreProductsBtn').addEventListener('click', function() {
                addMoreProductFields('pages/get_food_car_products.php', 'additionalFoodProduct[]', 'اختر الاكلة المطلوبة');
            });
            document.getElementById('addMoreCafeProductsBtn').addEventListener('click', function() {
                addMoreCafeProductFields();
            });

            function addMoreCafeProductFields() {
                // Create new label for the dropdown menu
                var newProductLabel = document.createElement('label');
                newProductLabel.innerHTML = 'اختر المنتج';
                newProductLabel.setAttribute('for', 'additionalCafeProduct[]');

                // Create new dropdown menu
                var newProductSelect = document.createElement('select');
                newProductSelect.className = 'form-control';
                newProductSelect.name = 'additionalCafeProduct[]'; // Use an array to handle multiple selections

                // var defaultOption = document.createElement('option');
                // defaultOption.value = "";
                // // defaultOption.text = "اختر المشروب المطلوب";
                // newProductSelect.appendChild(defaultOption);

                // TODO: Add options to the new dropdown menu (you can fetch these dynamically from your database)
                fetch('pages/get_cafe_porducts.php')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();
                    })
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
                newQuantityLabel.setAttribute('for', 'additionalCafeQuantity[]');

                // Create new quantity input field
                var newQuantityInput = document.createElement('input');
                newQuantityInput.type = 'number';
                newQuantityInput.className = 'form-control';
                newQuantityInput.name = 'additionalCafeQuantity[]'; // Use an array to handle multiple inputs
                newQuantityInput.required = true;
                newQuantityInput.value = 1;
                newQuantityInput.min = 1;

                // Append the new labels and fields to the container
                document.getElementById('additionalProductFieldsContainer').appendChild(newProductLabel);
                document.getElementById('additionalProductFieldsContainer').appendChild(newProductSelect);
                document.getElementById('additionalProductFieldsContainer').appendChild(newQuantityLabel);
                document.getElementById('additionalProductFieldsContainer').appendChild(newQuantityInput);
            }

            function addMoreProductFields(apiEndpoint, inputName, defaultOptionText) {
                // Create new label for the dropdown menu
                var newProductLabel = document.createElement('label');
                newProductLabel.innerHTML = 'اختر المنتج';
                newProductLabel.setAttribute('for', inputName);

                // Create new dropdown menu
                var newProductSelect = document.createElement('select');
                newProductSelect.className = 'form-control';
                newProductSelect.name = inputName; // Use an array to handle multiple selections

                // var defaultOption = document.createElement('option');
                // defaultOption.value = "";
                // defaultOption.text = defaultOptionText;
                // newProductSelect.appendChild(defaultOption);

                // Fetch and add options to the new dropdown menu
                fetch(apiEndpoint)
                    .then(response => response.json())
                    .then(data => {
                        // Populate the dropdown menu with options
                        data.forEach(option => {
                            var optionElement = document.createElement('option');
                            optionElement.value = option.id; // Set the value based on your product data
                            optionElement.text = option.food_name || option.product_name; // Set the display text based on your product data
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

        <!-- ... Your existing PHP code ... -->

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