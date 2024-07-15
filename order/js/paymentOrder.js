function paymentFunction() {
    var selectedValue = document.querySelector('select[name="card_id"]').value;
    var otherProductContainer = document.getElementById("paymentContainer");
    if (selectedValue !== "") {
        if (selectedValue === "other") {
            otherProductContainer.style.display = "block";
            paymentclearFormFields();
        } else {
            otherProductContainer.style.display = "block";
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    paymentpopulateFields(data);
                }
            };
            xhttp.open("GET", "order/featchRecord/get_payment_data.php?card_id=" + selectedValue, true);
            xhttp.send();
        }
    } else {
        otherProductContainer.style.display = "none";
        return;
    }
}

function paymentpopulateFields(data) {
    document.querySelector('input[name="card_number"]').value = data.card_number;
    document.querySelector('input[name="card_number"]').readOnly = true;

    document.querySelector('input[name="card_holder_name"]').value = data.card_holder_name;
    document.querySelector('input[name="card_holder_name"]').readOnly = true;

    // Set the selected value of the "Bank Name" dropdown
    var bankNameDropdown = document.querySelector('select[name="card_provider_bank"]');
    var selectedBankId = data.card_provider_bank;
    for (var i = 0; i < bankNameDropdown.options.length; i++) {
        if (bankNameDropdown.options[i].value == selectedBankId) {
            bankNameDropdown.selectedIndex = i;
            break;
        }
    }

    document.querySelector('input[name="paymentcomment"]').value = data.comment;
    document.querySelector('input[name="paymentcomment"]').readOnly = true;
}

function paymentclearFormFields() {
    document.querySelector('input[name="card_number"]').value = "";
    document.querySelector('input[name="card_number"]').readOnly = false;

    document.querySelector('input[name="card_holder_name"]').value = "";
    document.querySelector('input[name="card_holder_name"]').readOnly = false;

    // Reset the "Bank Name" dropdown to its default state
    document.querySelector('select[name="card_provider_bank"]').selectedIndex = 0;
    document.querySelector('select[name="card_provider_bank"]').readOnly = false;

    document.querySelector('input[name="paymentcomment"]').value = "";
    document.querySelector('input[name="paymentcomment"]').readOnly = false;
}
