function accountFunction() {
    var selectedValue = document.querySelector('select[name="account_id"]').value;
    var otherProductContainer = document.getElementById("accountContainer");
    if (selectedValue !== "") {
        if (selectedValue === "other") {
            otherProductContainer.style.display = "block";
            accountclearFormFields();

        } else {
            otherProductContainer.style.display = "block";
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    accountpopulateFields(data);
                }
            };
            xhttp.open("GET", "order/featchRecord/get_account_data.php?account_id=" + selectedValue, true);
            xhttp.send();
        }
    } else {
        otherProductContainer.style.display = "none";
        return;
    }
}

function accountpopulateFields(data) {
    document.querySelector('input[name="mobile_number"]').value = data.mobile_number;
    document.querySelector('input[name="mobile_number"]').readOnly = true;

    document.querySelector('input[name="email"]').value = data.email;
    document.querySelector('input[name="email"]').readOnly = true;

    document.querySelector('input[name="account_holder_name"]').value = data.account_holder_name;
    document.querySelector('input[name="account_holder_name"]').readOnly = true;

    document.querySelector('input[name="accountcomment"]').value = data.comment;
    document.querySelector('input[name="accountcomment"]').readOnly = true;
}

function accountclearFormFields() {
    document.querySelector('input[name="mobile_number"]').value = "";
    document.querySelector('input[name="mobile_number"]').readOnly = false;

    document.querySelector('input[name="email"]').value = "";
    document.querySelector('input[name="email"]').readOnly = false;

    document.querySelector('input[name="account_holder_name"]').value = "";
    document.querySelector('input[name="account_holder_name"]').readOnly = false;

    document.querySelector('input[name="accountcomment"]').value = "";
    document.querySelector('input[name="accountcomment"]').readOnly = false;

}

