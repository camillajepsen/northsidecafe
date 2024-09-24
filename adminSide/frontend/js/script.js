

//Script for adding rows to items page 
document.addEventListener("DOMContentLoaded", function () {
    function allFieldsFilled(row) {
        const itemName = row.querySelector('.item-name').value.trim();
        const itemCategory = row.querySelector('.item-category').value;
        const itemIcon = row.querySelector('.file-button').value;

        return itemName !== "" && itemCategory !== "" && itemIcon !== "";
    }

    function addItemRow() {
        const table = document.getElementById('item-table');
        const rowTemplate = document.querySelector('.menu-item');
        const newRow = rowTemplate.cloneNode(true);

        // Reset the input values in the new row
        newRow.querySelector('.item-name').value = '';
        newRow.querySelector('.item-category').selectedIndex = 0;
        newRow.querySelector('.milk-option').checked = false;
        newRow.querySelector('.file-button').value = '';
        newRow.querySelector('.action-button').textContent = 'ADD ITEM';

        table.appendChild(newRow);

        attachEventListeners(newRow);
    }

    function attachEventListeners(row) {
        const button = row.querySelector('.action-button');

        button.addEventListener('click', function () {
            if (allFieldsFilled(row)) {
                if (button.textContent === "ADD ITEM") {
                    button.textContent = "REMOVE";
                    addItemRow();
                } else if (button.textContent === "REMOVE") {
                    const table = document.getElementById('item-table');
                    if (table.rows.length > 2) {  // Ensure at least one row remains
                        table.removeChild(row);
                    }
                }
            } else {
                alert("Please fill out all fields.");
            }
        });
    }

    // Attach event listeners to the initial row
    const initialRow = document.querySelector('.menu-item');
    attachEventListeners(initialRow);
});


// Script for setting date to today's date

document.getElementById('startdate').valueAsDate = new Date();

document.getElementById('enddate').valueAsDate = new Date();



