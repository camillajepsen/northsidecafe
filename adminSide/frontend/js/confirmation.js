/*
#Updated: New file for confirmation page
 */
function createReceiptItem(itemDetails) {
    let itemContainer = document.createElement("div");
    itemContainer.className = "addedOrderInfo";
    itemContainer.innerHTML = `
    <p>${itemDetails.no}</p>
    <img src="${itemDetails.imgSrc}" style="width: 100px; height: 100px;">
    <div>
        <p>${itemDetails.name}</p>
        <p>Size: ${itemDetails.size}</p>
        <p>${itemDetails.milk ? "Milk: "+itemDetails.milk : ""}</p>
        <p>${itemDetails.takeawayText}</p>
        <p>${itemDetails.sugarText ? itemDetails.sugarText : ""}</p>
        <p>Cost: $${itemDetails.cost}</p>
    </div>
    `; // #Updated: changes added to suit no_milk customization page needs
    return itemContainer;
}

function generateReceiptData() {
    let reciptElement = document.getElementById("receipt-orderdetails");
    reciptElement.innerHTML = "";
    let itemList = JSON.parse(localStorage.getItem("cart"));
    if (!itemList)
        return;
    itemList.forEach(itemDetails => {
        let node = createReceiptItem(itemDetails);
        reciptElement.appendChild(node);
    })
}

function calculateTotal() {
    let totElement = document.getElementById("receipt-orderamount");
    let itemList = JSON.parse(localStorage.getItem("cart"));
    let total = itemList.map(item => item.cost).reduce((a, b) => a + b);
    totElement.innerHTML = `Total: ${total}`;
}

function placeOrder() {
    let orderList = JSON.parse(localStorage.getItem("orders"));
    orderList = orderList ? orderList : [];
    let orderDate = new Date();
    let cartItems = JSON.parse(localStorage.getItem("cart"));
    if (!cartItems)
        return;
    let orderNo = orderList[orderList.length - 1] ? orderList[orderList.length - 1].no + 1 : 1;
    let order = {
        no: orderNo,
        date: orderDate,
        items: cartItems,
        totalCost: cartItems.map(item => item.cost).reduce((a, b) => a + b)
    }
    orderList.push(order);
    localStorage.setItem("cart", JSON.stringify([]));
    localStorage.setItem("orders", JSON.stringify(orderList));
}