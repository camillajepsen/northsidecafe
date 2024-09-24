/*
#Updated: New file added for payment button
*/

const availableMethods = {
    "cash": document.querySelector(".payment-options .cash-option"),
    "card": document.querySelector(".payment-options .card-option")
}

function enablePaymentUpdate() {
    for (let option in availableMethods) {
        console.log(option)
        availableMethods[option].onclick = (event) => {
            console.log("Inside listener.");
            console.log("for: ", option)
            localStorage.setItem("paymentMethod", option);
            updateColor();
        }
    }
}

function updateColor() {
    let currentOption = localStorage.getItem("paymentMethod");
    for (let option in availableMethods) {
        if (option == currentOption) {
            availableMethods[option].classList.add("selectedPaymentBtn");
            availableMethods[option].classList.remove("defaultPaymentBtn");
        } else {
            availableMethods[option].classList.add("defaultPaymentBtn");
            availableMethods[option].classList.remove("selectedPaymentBtn");
        }
    }
}