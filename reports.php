<?php
session_start();
$page_title = 'التقارير';
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
                        <h1 class="h3 mb-4 text-gray-800">التقارير الشهرية او اليومية </h1>
                        <!-- Add Product to Stocks Form -->
                        <form id="generateReportForm" onsubmit="fetchAndDisplayOrders(); return false;">
                            <div class="form-group">
                                <label for="start-date">تاريخ البداية:</label>
                                <input type="date" class="form-control" id="start-date" name="start_date" required>
                            </div>
                            <div class="form-group">
                                <label for="end-date">تاريخ النهاية:</label>
                                <input type="date" class="form-control" id="end-date" name="end_date" required>
                            </div>
                            <div class="form-group">
                                <label>اختر القسم:</label><br>
                                <input type="radio" id="foodcar" name="section" value="foodcar" required>
                                <label for="foodcar">المحل</label><br>
                                <input type="radio" id="cafe" name="section" value="cafe">
                                <label for="cafe">تيك اووي</label><br>
                                <input type="radio" id="playstation" name="section" value="playstation">
                                <label for="playstation">البلاستيشن</label>
                            </div>
                            <button type="submit" class="btn btn-primary">احصل على التقارير</button>
                        </form>

                        <div id="resultMessage"></div>
                    </div>
                </div>
            </div>
            <!-- Display Stocks Table -->
            <div class="mt-4">
                <h2>جدول الاوردارت</h2>
                <table class="table" id="reportTable">
                    <thead>
                        <tr>
                            <th scope="col"># </th>
                            <th scope="col">كود الطلب </th>
                            <th scope="col">سعر الاوردر</th>
                            <th scope="col">كود المستخدم </th>
                            <th scope="col">تاريخ الانشاء </th>
                        </tr>
                    </thead>
                    <tbody id="reportBody">

                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.container-fluid -->


        <script>
            function fetchAndDisplayOrders() {
                // Get form inputs
                const startDate = document.getElementById("start-date").value;
                const endDate = document.getElementById("end-date").value;
                const section = document.querySelector('input[name="section"]:checked').value;

                // Construct URL for fetching orders based on the selected section and date range
                const url = `admin/generate_report.php?start_date=${startDate}&end_date=${endDate}&section=${section}`;

                // Fetch data from the server
                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Network response was not ok");
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Update the table with the retrieved orders
                        const tableBody = document.getElementById("reportBody");

                        // Clear existing table rows
                        tableBody.innerHTML = "";
                        let iterator = 0;
                        let totalOrders = 0;

                        // Loop through the retrieved data and populate the table rows
                        data.forEach(orders => {
                            // Populate the table row with order data (adjust as per your data structure)
                            const row = document.createElement("tr");
                            iterator++;
                            totalOrders += parseFloat(orders.total_price); // Calculate total orders
                            row.innerHTML =
                                `<td>${iterator}</td>
                          <td>${orders.id}</td> 
                          <td>${orders.total_price}</td>
                          <td>${orders.user_id}</td>
                          <td>${orders.created_at}</td>`;
                            // Append the row to the table body
                            tableBody.appendChild(row);
                        });

                        // Add a row for the total orders
                        const totalRow = document.createElement("tr");
                        totalRow.innerHTML = `<td colspan="2"></td>
                                      <td><strong>المجموع الكلي </strong></td>
                                      <td><strong>${totalOrders}</strong></td>
                                      <td></td>`;
                        tableBody.appendChild(totalRow);
                    })
                    .catch(error => {
                        console.error("Error fetching data:", error);
                        // Handle error if any
                    });
            }
        </script>


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
