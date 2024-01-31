document.addEventListener("DOMContentLoaded", function() {
document.getElementById("date-range-button").addEventListener("click", fetchReportsByDateRange);

function fetchReportsByDateRange() {
const startDate = document.getElementById("start-date").value;
const endDate = document.getElementById("end-date").value;

fetchOrdersData("cafe_orders.php", startDate, endDate, "cafe-orders");
fetchOrdersData("Playstation_orders.php", startDate, endDate, "playstation-orders");
fetchOrdersData("foodCar_orders.php", startDate, endDate, "foodcar-orders");
}

function fetchOrdersData(endpoint, startDate, endDate, elementId) {
fetch(endpoint + "?start_date=" + startDate + "&end_date=" + endDate)
.then(response => {
if (!response.ok) {
throw new Error("Network response was not ok");
}
return response.json();
})
.then(data => {
// Update the corresponding tab content
document.getElementById(elementId).innerHTML = `<h2>Orders Data</h2>` + displayOrdersData(data);
})
.catch(error => {
console.error("Error fetching data:", error);
document.getElementById(elementId).innerHTML = `<h2>Error</h2>
<p>An error occurred while fetching data.</p>`;
});
}

function displayOrdersData(data) {
// Format and display the orders data as per your requirements
// You can use HTML markup to structure the data within the tab content
}
});