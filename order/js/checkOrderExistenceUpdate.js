// Function to check if the order ID exists
function checkOrderExistence() {
    var orderNo = document.getElementById('order_no_input').value;

    // Make an AJAX request to the server-side script
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'order/check_orderUpdate.php?order_no=' + orderNo, true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var orderExists = JSON.parse(xhr.responseText);

        var orderStatusElement = document.getElementById('order_status');
        var submitButton = document.getElementById('submit_button');
        
        if (orderExists) {
          orderStatusElement.style.color = 'red';
          orderStatusElement.textContent = 'This order no already exists!';
          
          // Disable the submit button
          submitButton.disabled = true;
        } else {
          orderStatusElement.style.color = '';
          orderStatusElement.textContent = '';
          
          // Enable the submit button
          submitButton.disabled = false;
        }
      }
    };
    xhr.send();
  }

  // Add event listener to the input field
  var orderInput = document.getElementById('order_no_input');
  orderInput.addEventListener('blur', checkOrderExistence);