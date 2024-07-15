// <!--featching the acount detail based on the deopdown of account secton  -->
function fetchAccounts(storeName) {
    var accountIdSelect = document.querySelector('select[name="account_id"]');
    var loader = document.getElementById("loader"); // Assuming you have a loader element with ID "loader"

    loader.style.display = "block";

    accountIdSelect.innerHTML = '<option value="">--Select--</option>';

    if (storeName !== '') {
        // Make an AJAX request to the server to fetch accounts based on the selected store name
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'order/fetch_accounts.php?store_name=' + encodeURIComponent(storeName), true);
        xhr.onload = function () {
            // Hide the loader when the response is received
            loader.style.display = "none";

            if (xhr.status === 200) {
                var accounts = JSON.parse(xhr.responseText);

                if (accounts.length > 0) {
                    accounts.forEach(function (account) {
                        var option = document.createElement('option');
                        option.value = account.account_id;
                        option.textContent = account.mobile_number + ' | ' + account.account_holder_name;
                        accountIdSelect.appendChild(option);
                    });

                    // Add an "Other" option for no specific account found
                    var otherOption = document.createElement('option');
                    otherOption.value = 'other';
                    otherOption.textContent = 'Other';
                    accountIdSelect.appendChild(otherOption);
                } else {
                    var option = document.createElement('option');
                    option.textContent = 'No accounts found';
                    option.disabled = true;
                    accountIdSelect.appendChild(option);

                    // Add an "Other" option for no specific account found
                    var otherOption = document.createElement('option');
                    otherOption.value = 'other';
                    otherOption.textContent = 'Other';
                    accountIdSelect.appendChild(otherOption);
                }
            }
        };
        xhr.send();
    }
}


// Based on dropdown filter the record from the data base in card section 

function paymentModeChange() {

    // Get the selected payment mode and card provider bank
    var paymentMode = document.querySelector('select[name="payment_mode"]').value;
    var cardProviderBank = document.querySelector('select[name="choosing_card_provider_bank"]').value;
    if (paymentMode !== '' && cardProviderBank !== '') {
        // Make an AJAX request to fetch card details based on payment mode and card provider bank
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'order/fetch_card_details.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Parse the JSON response
                var cardDetails = JSON.parse(xhr.responseText);

                // Populate the card dropdown with fetched card details
                var cardDropdown = document.querySelector('select[name="card_id"]');
                cardDropdown.innerHTML = '<option value="">--Select--</option>';

                if (cardDetails.length > 0) {
                    // Add options for each card
                    cardDetails.forEach(function(card) {
                        var option = document.createElement('option');
                        option.value = card.card_id;
                        option.textContent = 'XXXX-' + card.card_number + ' | ' + card.card_holder_name;
                        cardDropdown.appendChild(option);
                    });
                } else {
                    // No payment options found
                    var option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'No payment options found';
                    option.disabled = true;
                    cardDropdown.appendChild(option);
                }

                // Add an "Other" option for no specific payment option found
                var otherOption = document.createElement('option');
                otherOption.value = 'other';
                otherOption.textContent = 'Other';
                cardDropdown.appendChild(otherOption);

                // Disable the "Other" option if no payment options found
                if (cardDetails.length === 0) {
                    otherOption.disabled = false;
                }
            }
        };
        
        // Send the payment mode and card provider bank as parameters in the AJAX request
        xhr.send('payment_mode=' + encodeURIComponent(paymentMode) + '&choosing_card_provider_bank=' + encodeURIComponent(cardProviderBank));
    }
}

// Function to handle AJAX request and update filter the broduct based on the brand select 

function updateProductOptions(selectedBrand) {
    var productSelect = document.getElementById('productSelect');
    // Clear existing options
    productSelect.innerHTML = '<option value="">--Select--</option>';
  
    if (selectedBrand === '') {
      return; // No brand selected, exit the function
    }
  
    // Send AJAX request to retrieve filtered products
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var products = JSON.parse(xhr.responseText);
  
        if (products.length === 0) {
          // No records found
          var option = document.createElement('option');
          option.textContent = 'No records found !';
          productSelect.appendChild(option);
        } else {
          // Populate the product options
          for (var i = 0; i < products.length; i++) {
            var option = document.createElement('option');
            option.value = products[i].product_id;
            option.textContent = products[i].brand_name + " | " + products[i].model_name + " | " + products[i].price;
            productSelect.appendChild(option);
          }
        }
        // Add the "Other" option
        var otherOption = document.createElement('option');
        otherOption.value = 'other';
        otherOption.textContent = 'Other';
        productSelect.appendChild(otherOption);
      }
    };
  
    xhr.open('GET', 'order/filter_products.php?brand=' + encodeURIComponent(selectedBrand), true);
    xhr.send();
  }
  