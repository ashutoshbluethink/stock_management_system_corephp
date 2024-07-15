function productFunction() {
    var selectedValue = document.querySelector('select[name="product_id"]').value;
    var productContainer = document.getElementById("productContainer");
  
    if (selectedValue !== "") {
        if (selectedValue === "other") {
            productContainer.style.display = "block";
            productclearFormFields();

        } else {
            // alert(selectedValue);
            // Clear previous color swatches
            $('#colorSwatches').empty();

            // AJAX request to fetch colors for selected product
            $.ajax({
                url: 'order/featchRecord/fetch_colors.php',
                type: 'GET',
                data: { product_id: selectedValue },
                dataType: 'json',
                success: function(response) {
                    if (response.colors.length > 0) {
                        $.each(response.colors, function(index, color) {
                            var swatch = $('<div class="color-swatch"></div>');
                            var radio = $('<input type="radio" name="color" value="' + color.color_id + '" title="' + color.color_name + '">');
                            var label = $('<label>' + color.color_name + '</label>');
                            
                            swatch.append(radio).append(label);
                            $('#colorSwatches').append(swatch);
                
                            // Add click event to apply red border on select
                            swatch.click(function() {
                                $('.color-swatch').css('border', 'none'); // Remove border from all swatches
                                swatch.css('border', '2px solid red'); // Apply red border to the selected swatch
                            });
                        });
                    } else {
                        $('#color_error').text('No colors found for the selected product');
                    }
                },
                error: function(xhr, status, error) {
                    $('#color_error').text('Error fetching colors from the database');
                }  
            });
            productContainer.style.display = "block";
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    productpopulateFields(data);
                }
            };
            xhttp.open("GET", "order/featchRecord/get_product_data.php?product_id=" + selectedValue, true);
            xhttp.send();
        }
    } else {
        productContainer.style.display = "none";
        return;
    }
}

function productpopulateFields(data) {
    document.querySelector('select[name="product_brand_name"]').value = data.brand;
    document.querySelector('select[name="product_brand_name"]').readOnly = true;

    document.querySelector('input[name="model_name"]').value = data.model_name;
    document.querySelector('input[name="model_name"]').readOnly = true;

    document.querySelector('input[name="price"]').value = data.price;
    document.querySelector('input[name="price"]').readOnly = true;
  
    document.querySelector('input[name="productcomment"]').value = data.comment;
    document.querySelector('input[name="productcomment"]').readOnly = true;
    
}


function productclearFormFields() {
    document.querySelector('select[name="product_brand_name"]').value = "";
    document.querySelector('select[name="product_brand_name"]').readOnly = false;

    document.querySelector('input[name="model_name"]').value = "";
    document.querySelector('input[name="model_name"]').readOnly = false;

    document.querySelector('input[name="price"]').value = "";
    document.querySelector('input[name="model_name"]').readOnly = false;

    document.querySelector('input[name="productcomment"]').value = "";
    document.querySelector('input[name="productcomment"]').readOnly = false;


}

