/*
#Updated: New file for cart update
*/
function createCartItem(itemDetails) {
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
    <button class="remItem" aria-label="Remove item from cart"  onclick="removeItem(${itemDetails.no})">x</button>
    `; // #Updated: changes added to suit no_milk customization page needs
    return itemContainer;
}

function updateCart() {
    let orderContainer = document.querySelector(".order-box .order-info");
    let itemList = JSON.parse(localStorage.getItem("cart"))

    if (itemList == null)
        return;
    orderContainer.innerHTML = "";
    itemList.forEach(orderItemDetails => {
        let node = createCartItem(orderItemDetails);
        orderContainer.appendChild(node);
    });
}

function removeItem(itemNo) {
    let itemList = JSON.parse(localStorage.getItem("cart"));
    let targetIndex = itemList.findIndex(item => item.no === itemNo);
    itemList.splice(targetIndex, 1);
    itemList = maintainItemNo(itemList);
    localStorage.setItem("cart", JSON.stringify(itemList));
    updateCart();
}

function maintainItemNo(itemList) {
    for (let i = 0; i < itemList.length; i++)
        itemList[i].no = i+1;
    return itemList;
}