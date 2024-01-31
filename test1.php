<!DOCTYPE html>
<html lang="ar" dir="rtl"> <!-- Set language to Arabic and direction to RTL -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقارير المبيعات</title>
    <style>
        /* Your CSS styles */
    </style>
</head>

<body>
    <h1>تقارير المبيعات</h1>
    <form action="#" style="display: flex; flex-direction: column; align-items: flex-start;">
        <!-- اختيار التاريخ -->
        <div style="margin-bottom: 10px;">
            <label for="start-date">تاريخ البداية:</label>
            <input type="date" id="start-date" name="start_date">
        </div>
        <div style="margin-bottom: 10px;">
            <label for="end-date">تاريخ النهاية:</label>
            <input type="date" id="end-date" name="end_date">
        </div>
        <button id="date-range-button">احصل على التقارير</button>
    </form>

    <!-- Tabs -->
    <div class="tab" onclick="openTab('cafe-orders')">الكافيه</div>
    <div class="tab" onclick="openTab('playstation-orders')">البلايستيشن</div>
    <div class="tab" onclick="openTab('foodcar-orders')">فودكار</div>

    <!-- حاويات التقارير -->
    <div id="cafe-orders" class="report-section tab-content"></div>
    <div id="playstation-orders" class="report-section tab-content"></div>
    <div id="foodcar-orders" class="report-section tab-content"></div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function fetchAndDisplayOrders(endpoint, elementId, reportTitle) {
                fetch(endpoint)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Network response was not ok");
                        }
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById(elementId).innerHTML = `<h2>${reportTitle}</h2>` + displayData(data);
                    })
                    .catch(error => {
                        console.error("Error fetching data:", error);
                        document.getElementById(elementId).innerHTML = `<h2>${reportTitle}</h2><p>حدث خطأ أثناء جلب البيانات.</p>`;
                    });
            }

            function displayData(data) {
                let html = "<ul>";
                data.forEach(record => {
                    html += `<li>التاريخ: ${record.date}, المبيعات: ${record.sales}</li>`;
                });
                html += "</ul>";
                return html;
            }

            function fetchOrdersByDateRange(endpoint, elementId, reportTitle) {
                const startDate = document.getElementById("start-date").value;
                const endDate = document.getElementById("end-date").value;

                fetchAndDisplayOrders(`${endpoint}?start_date=${startDate}&end_date=${endDate}`, elementId, reportTitle);
            }

            document.getElementById("date-range-button").addEventListener("click", function() {
                fetchOrdersByDateRange("pages/cafe_orders.php", "cafe-orders", "تقرير الكافيه");
                fetchOrdersByDateRange("pages/playstation_orders.php", "playstation-orders", "تقرير البلايستيشن");
                fetchOrdersByDateRange("pages/foodcar_orders.php", "foodcar-orders", "تقرير الفودكار");
            });

            // Initial load (you may want to load data for default date range or current date)
            fetchOrdersByDateRange("pages/cafe_orders.php", "cafe-orders", "تقرير الكافيه");
            fetchOrdersByDateRange("pages/playstation_orders.php", "playstation-orders", "تقرير البلايستيشن");
            fetchOrdersByDateRange("pages/foodcar_orders.php", "foodcar-orders", "تقرير الفودكار");
        });

        function openTab(tabName) {
            const tabs = document.querySelectorAll('.tab');
            const tabContents = document.querySelectorAll('.tab-content');

            tabContents.forEach(content => {
                content.classList.remove('active');
            });
            tabs.forEach(tab => {
                tab.classList.remove('active');
            });

            document.getElementById(tabName).classList.add('active');
            event.currentTarget.classList.add('active');
        }
    </script>
</body>

</html>