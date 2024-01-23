<?php
session_start();

$page_title = "Add cafe Order";
if (isset($_SESSION['username'])) {
    require_once("inc/header.php");
    // require_once("inc/sidebar.php");
    // require_once("inc/navbar.php");
    require_once("DB/db_config.php");


    //// Get the Full cafe_products 


?>


    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->

        <!-- Content Row -->

        <!-- Begin Cafe Content -->
        <!-- <a href="cafe.php" class="btn btn-primary btn-lg mb-2">
            الكافيه
        </a> -->
        <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4 ">
            <a href="add_cafe_order" class="btn-lg mb-2 text-center btn btn-primary">
                اضافة طلب
            </a>
            <h1 class="h5 mb-0 text-gray-800 text-center">المنيو</h1>
        </div> -->
        <!-- <div class="row d-sm-flex align-items-center justify-content-between mb-4">
            <div class="col-md-4">
                <a href="add_cafe_order" class="btn-lg mb-2 text-center btn btn-primary">
                    اضافة طلب
                </a>
            </div>
            <div class="col-md-4 text-center">
                <h1 class="h5 mb-0 text-gray-800">المنيو</h1>
            </div>
            <div class="col-md-4"></div>
        </div> -->

        <!-- <div class="row">

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-md font-weight-bold text-primary text-uppercase mb-1">
                                    Hamada Yel3ab
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Akhoya
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-coffee fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->


        <!-- Content Row -->

        <!-- Content Row -->
        <!-- chatGpt Content -->
        <!-- ... Your existing HTML code ... -->
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
                    <form id="addOrderForm" method="post" action="Pages/insert_playstation_order.php">
                        <div class="form-group">
                            <label for="">نوع الجهاز</label>
                            <!-- <input type="text" name="productName" id="" class="form-control" autocomplete="off"> -->
                            <!-- <select class="form-control" id="productSelect" name="product">
                                <option value="0">برجاء اختيار المنتج</option>
                            </select> -->
                            <div class="">
                                <label for="ps4">PS4</label>
                                <input type="radio" name="playstationproduct" id="ps4" value="ps4">
                            </div>
                            <!-- <label for="ps5"> PS5</label> -->
                            <div class="">
                                <label for="ps5">PS5</label>
                                <input type="radio" name="playstationproduct" id="ps5" value="ps5">
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="">سنجل ولا مالتي </label>
                            <!-- <input type="text" name="productName" id="" class="form-control" autocomplete="off"> -->
                            <!-- <select class="form-control" id="productSelect" name="product">
                                <option value="0">برجاء اختيار المنتج</option>
                            </select> -->
                            <div class="">
                                <label for="single">سنجل </label>
                                <input type="radio" name="playstationControllerType" id="single" value="single">
                            </div>
                            <!-- <label for="ps5"> PS5</label> -->
                            <div class="">
                                <label for="multi">مالتي</label>
                                <input type="radio" name="playstationControllerType" id="multi" value="multi">
                            </div>

                        </div>
                        <!-- <div class="form-group">
                            <label for="quantityInput">الكمية</label>
                            <input type="number" class="form-control" id="quantityInput" name="quantity" required min="1" value="1">
                        </div> -->
                        <div class="form-group">
                            <div id="additionalProductFieldsContainer"></div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="addclick">إضافة الطلب</button>
                    </form>
                    <!-- Add more products button -->

                    <button type="button" class="btn btn-secondary mt-3" id="addMoreProductsBtn">إضافة منتجات من الكافيه</button>
                    <button type="button" class="btn btn-secondary mt-3" id="addMoreProductsFood">إضافة منتجات من عربية الاكل </button>
                    <div class="form-group mt-3">
                        <a href="playstaion.php" class="btn btn-danger"> رجوع للخلف</a>
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

            // Fetch products and populate the dropdown
            // fetch('pages/get_playstation_products.php')
            //     .then(response => {
            //         if (!response.ok) {
            //             throw new Error(`HTTP error! Status: ${response.status}`);
            //         }
            //         return response.json();
            //     })
            //     .then(data => {
            //         var productSelect = document.getElementById('productSelect');

            //         // Clear existing options (if any)
            //         productSelect.innerHTML = '';

            //         // Add a default option
            //         var defaultOption = document.createElement('option');
            //         defaultOption.value = '';
            //         defaultOption.text = 'برجاء اختيار المنتج';
            //         productSelect.appendChild(defaultOption);

            //         // Add options based on the fetched data
            //         data.forEach(product => {
            //             var optionElement = document.createElement('option');
            //             optionElement.value = product.id; // Adjust this based on your product data
            //             optionElement.text = product.playstation_type; // Adjust this based on your product data
            //             productSelect.appendChild(optionElement);
            //         });
            //     })
            //     .catch(error => console.error('Error fetching product options:', error));

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