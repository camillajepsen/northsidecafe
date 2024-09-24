/*
#Updated: New file added for generating transaction reports
*/
function generateRowString(orderDetails) {
    let dateString = orderDetails.date;
    let totalCost = orderDetails.totalCost;
    let itemString = "";
    let disp_props = ["name", "milk", "size"]
    for (let item of orderDetails.items) {
        for (let prop of disp_props) {
            if (!item[prop])
                continue;
            itemString += `${item[prop]} - `
        }
        itemString = itemString.slice(0, itemString.length-2) +  "<br>";
    }
    let tableRowString = `
    <tr>
        <td class="transaction-date">${dateString}</td>
        <td class="transaction-order">${itemString}</td>
        <td class="transaction-price">$${totalCost}</td>
        <td class="transaction-staff">KS</td>
        <td><img src="logos/printer_beige.png" id="transactions-printer"></td>
    </tr>
    `;
    return tableRowString;
}

function generateTransReports() {
    const reportContainer = document.getElementById("transaction-table");
    let orders = JSON.parse(localStorage.getItem("orders"))
    if (!orders)
        return;
    orders.forEach(order => reportContainer.innerHTML += generateRowString(order));
}