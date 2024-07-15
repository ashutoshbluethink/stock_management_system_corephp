$(document).ready(function () {
    var selectedOrderIds = [];

    // Check all checkbox
    $('#checkAll').change(function () {
        $('.orderCheckbox').prop('checked', $(this).prop('checked'));
        toggleButtons();
        updateSelectedOrderInfo();
    });

    // Individual checkbox
    $('.orderCheckbox').change(function () {
        toggleButtons();
        updateSelectedOrderInfo();
    });

    // Function to update selected order information
    function updateSelectedOrderInfo() {
        selectedOrderIds = [];
        $('.orderCheckbox:checked').each(function () {
            var href = $(this).closest('tr').find('a').attr('href');
            var orderId = href.split('=')[1];
            selectedOrderIds.push(orderId);
        });
        var selectedCount = selectedOrderIds.length;
        $('.selectedOrderCount').text(selectedCount);
        $('.selectedOrderIds').text(selectedOrderIds.join(', '));
    }

    // Toggle buttons based on checkbox selection
    function toggleButtons() {
        var anyCheckboxChecked = $('.orderCheckbox:checked').length > 0;
        $('#actionButton').toggle(anyCheckboxChecked);
    }

    // Handle form submission
    $('#order_status form').submit(function (event) {
        event.preventDefault(); // Prevent the default form submission
        var orderStatus = $('#actionButton').val();
        var checkedOrders = selectedOrderIds; // Use the global array
        var vendor_id = $('#vendor_select').val();

        var selectedDate = $('#selectedDate').val(); // Get selected date
        var service_charge = $('#service_charge').val();

        $.ajax({
            url: 'order/update_order_status.php',
            method: 'POST',
            data: {
                orderIds: checkedOrders,
                orderStatus: orderStatus,
                selectedDate: selectedDate, 
                service_charge: service_charge,  // Pass selected date to the server
                vendor_id: vendor_id,
            },
            success: function (response) {
                console.log(response);
                var messageClass = response === 'success' ? 'alert-success' : 'alert-danger';
                var messageText = response === 'success' ? 'Order status updated successfully' : 'Order status not updated (Error)';
                var message = $('<div class="alert ' + messageClass + '">' + messageText + '</div>');
                $('.page-header').prepend(message);
                setTimeout(function () {
                    location.reload();
                }, 2000);
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
                var errorMessage = $('<div class="alert alert-danger">Order status not updated (Error)</div>');
                $('.page-header').prepend(errorMessage);
            }
        });

        $('#order_status').modal('hide'); // Hide the modal dialog
    });

    // Update confirmation message based on selected dropdown value
    $('#actionButton').change(function () {
        var selectedValue = $(this).find(":selected").text();
        $('.confirmationButtonValue').text(selectedValue);
        $('#order_status').modal('show');
    });

    // Handle "Close" button click
    $('#closeModalBtn').click(function () {
        $('.orderCheckbox').prop('checked', false); // Uncheck all checkboxes
        toggleButtons();
        updateSelectedOrderInfo();
    });

    // Initialize datepicker
    // $('.datepicker').datepicker({
    //     dateFormat: 'yy-mm-dd'
    // });
});