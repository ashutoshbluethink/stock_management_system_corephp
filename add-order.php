<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$role = $_SESSION['role'];
$last_login_at = $_SESSION['last_login_at'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Preschool - Bootstrap Admin Template</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">

	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">

	<link rel="stylesheet" href="assets/css/select2.min.css">

	<link rel="stylesheet" href="assets/css/style.css">

	<link rel="stylesheet" href="order/custom.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<!-- custom css file name -->
<style>
	.required {
  color: red;
}
</style>
</head>

<body>

	<div class="main-wrapper">

	<?php
		include 'header.php';
		include 'sidebar.php';
		include "backend/db_connection.php";
		?>

		<div class="page-wrapper">
			<div class="content container-fluid">
				<div class="page-header">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-12">
							<h5 class="text-uppercase mb-0 mt-0 page-title">Add New Order</h5>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-12">
							<ul class="breadcrumb float-right p-0 mb-0">
								<li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
								</li>
								<li class="breadcrumb-item"><a href="#">Order</a></li>
								<li class="breadcrumb-item"><span> Add Order</span></li>
							</ul>
						</div>
					</div>
				</div>
				<!-- ####################################################################################################### -->
				<script src="assets/js/jquery-3.6.0.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
                <?php
                    if (isset($_SESSION['errorMessage']) && !empty($_SESSION['errorMessage'])) {
                        echo '<script>
                        $(document).ready(function() {
                            toastr.error("' . $_SESSION['errorMessage'] . '", "", { 
                                timeOut: 5000, 
                                progressBar: true,
                                positionClass: "toast-top-center"
                            });
                        });
                        </script>';
                        $_SESSION['errorMessage'] = ""; // Clear the session variable
                    }
					if (isset($_SESSION['ordersuccessMessage']) && !empty($_SESSION['ordersuccessMessage'])) {
                        echo '<script>
                        $(document).ready(function() {
                            toastr.success("' . $_SESSION['ordersuccessMessage'] . '", "", { 
                                timeOut: 5000, 
                                progressBar: true,
                                positionClass: "toast-top-center"
                            });
                        });
                        </script>';
                        $_SESSION['ordersuccessMessage'] = ""; // Clear the session variable
                    }
                    ?>
                    <!-- #################################################################################################### -->
					
				<div class="row">

				<div class="col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">

							<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
							<form action="backend/add-order.php" id="order_form" method="POST" enctype="multipart/form-data">
								<!-- ****************************** ||Accounts Detail Entered ||********************************** -->
								<h4 class="card-title"> 
									<img src="assets/img/ac.png" alt="Account Logo" width="25" height="25">
									Accounts Detail Entered
								</h4> <br>
								
								<div class="row mt-12">
									<div class="col-sm-3">
										<div class="form-group">
											<label class="bold-label">Store Name<span class="required">*</span></label>
											<select class="form-control select2" name="account_group" required onchange="fetchAccounts(this.value)">
												<option value="">--Select--</option>
												<?php
													$query = "SELECT * FROM store";
													$result = mysqli_query($conn, $query);
													if (mysqli_num_rows($result) > 0) {
														while ($row = mysqli_fetch_assoc($result)) {
															echo '<option value="' . $row['store_id'] . '">';
															echo '<img src="assets/img/store_logo/' . $row['store_img'] . '" alt="Store Logo" width="40" height="27">';
															echo $row['store_name'];
															echo '</option>';
														}
													} else {
														echo '<option value="">No stores available</option>';
													}
													
												?>
											</select>
										</div>
										
									</div>
									
									<div class="col-sm-3">
									<div class="loader" id="loader" style="display: none;"><img src="assets/img/output-onlinegiftools.gif" alt="Account Logo" width="35" height="35" ></div>
										<div class="form-group">
											<label class="bold-label">Account Detail<span class="required">*</span></label>
											<select class="form-control select2" name="account_id" onchange="accountFunction()" required>
												<option value="">--Select--</option>
												<option value="Other">Other Store</option>
											</select>
										</div>
									</div>

									<div class="col-sm-3">
										<div class="form-group">
											<label class="bold-label">Order No<span class="required"> * </span></label>
											<input type="text" class="form-control" name="order_no" id="order_no_input">
											<p id="order_status"></p>
											<span class="error" style="color:red" id="order_no_error"></span>

										</div>
									</div>

									<div class="col-sm-3">
										<!-- <div class="form-group">
											<label class="bold-label"> Order Comment </label>
											<input type="text" class="form-control" name="order_create_comment" id="order_create_comment">
											<p id="order_status"></p>
										</div>

										<div class="col-sm-3"> -->
										<div class="form-group">
											<label class="bold-label">Location<span class="required"> * </span></label>
											<select class="form-control select2" name="order_location" required>
												<option value="">--Select--</option>
												<option value="Gorabazar">Gorabazar</option>
												<option value="sichee vibhag">sichee vibhag</option>
												<option value="Mishar Bazar">Mishar Bazar</option>
												<option value="MahuaBaag">MahuaBaag</option>
											</select>
										</div>
										<p id="order_status"></p>
										<span class="error" style="color:red" id="order_no_error"></span>
									</div>

									</div>
								</div>
								
									<!-- ################################################################################ -->
								<div id="accountContainer" style="display: none; background-color: rgb(189 184 184); padding: 20px; border-radius: 5px; margin: 30px;">
									<div class="row mt-12">
										<div class="col-sm-3">
											<div class="form-group">
												<label style="color: #333;">Mobile Number</label>
												<input type="text" class="form-control" name="mobile_number">
											</div>
										</div>
									
										<div class="col-sm-3">
											<div class="form-group">
												<label style="color: #333;">Email</label>
												<input type="text" class="form-control" name="email">
											</div>
										</div>
									
										<div class="col-sm-3">
											<div class="form-group">
												<label style="color: #333;">Account Holder Name</label>
												<input type="text" class="form-control" name="account_holder_name">
											</div>
										</div>

										<div class="col-sm-3">
											<div class="form-group">
												<label style="color: #333;">Comment</label>
												<input type="text" class="form-control" name="accountcomment">
											</div>
										</div>
									
									
									</div>
								</div>

								<!-- *************************************|| Payment Detail Box ||******************************************* -->
								<!-- ######################################################################################### -->
								<h4 class="card-title"> 
									<img src="assets/img/payment-logo.png" alt="Account Logo" width="25" height="25">
									Payment Detail Entered
								</h4> <br>
								<div class="row mt-12">
									<div class="col-sm-3">
										<div class="form-group">
											<label class="bold-label">Payment Mode<span class="required"> * </span></label>
											<select class="form-control select2" name="payment_mode" required>
												<option value="">--Select--</option>
												<option value="Credit">Credit</option>
												<option value="Debit">Debit</option>
												<option value="Account">Account</option>
												<option value="cod">COD</option>
											</select>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label class="bold-label">Card Provider Bank Name <span class="required">*</span></label>
											<select class="form-control select2" name="choosing_card_provider_bank" onchange="paymentModeChange()" required>
												<option value="">--Select--</option>
											    <?php
												
													$querysql = "SELECT * FROM bank_name where bank_status=1";
													$resultssql = mysqli_query($conn, $querysql);
																							
													while ($resultsql = mysqli_fetch_assoc($resultssql)) {
													
														echo "<option value='" . $resultsql['bank_id'] . "'>" . $resultsql['bank_name'] . "</option>";
													} ?>
											</select>
										</div>
									</div>
							
									<div class="col-sm-3">
										<div class="form-group">
											<label class="bold-label">Card No Select<span class="required"> * </span></label>
											<select class="form-control select2" name="card_id" onchange="paymentFunction()" required>
												<option value="">--Select--</option>
												<option value="other">Other</option>
											</select>
										</div>
									</div>
									<div class="col-sm-3" >
										<div class="form-group">
											<label class="bold-label">Order Price <span class="required">*</span></label>
											<input type="number" class="form-control" placeholder="Rs 0.00" name="order_price">
											<span class="error" style="color:red" id="order_price_error"></span>

										</div>
									</div>
								</div>
								<!-- ############################################################################################ -->
								<div id="paymentContainer" style="display: none; background-color: rgb(189 184 184); padding: 20px; border-radius: 5px; margin: 30px;">
									
									<div class="row mt-12">
										<div class="col-sm-3">
											<div class="form-group">
												<label>Card Number (last 4 digits)</label>
												<input type="text" class="form-control" name="card_number" maxlength="4">
											</div>
										</div>
									
										<div class="col-sm-3">
											<div class="form-group">
												<label>Card Holder Name</label>
												<input type="text" class="form-control" name="card_holder_name">
											</div>
										</div>

										<div class="col-sm-3" style="display: none;">
											<div class="form-group">
												<label>Card Holder Bank Name</label>
												<input type="text" class="form-control" name="card_holder_bank_name">
											</div>
										</div>
									
										<div class="col-sm-3">
											<div class="form-group">
												<label>Bank Name</label><br>
												<select class="form-control" name="card_provider_bank">
													<option value="">--Select--</option>
													<?php
													$querysql = "SELECT * FROM bank_name where bank_status=1";
													$resultssql = mysqli_query($conn, $querysql);

													while ($resultsql = mysqli_fetch_assoc($resultssql)) {

														echo "<option value='" . $resultsql['bank_id'] . "'>" . $resultsql['bank_name'] . "</option>";
													} ?>
												</select>
											</div>
										</div>

	
										<div class="col-sm-3">
											<div class="form-group">
												<label>Payment Comment</label>
												<input type="text" class="form-control" name="paymentcomment">
											</div>
										</div>

									</div>

								</div>

								 <!-- *********************************** ||product Details Entered ***************************************-->
				 				<!-- ####################################################################################################### -->
								<h4 class="card-title"> 
									<img src="assets/img/product.png" alt="Account Logo" width="25" height="25">
									Product Details Entered
								</h4> <br>
								<div class="row mt-12">
									<div class="col-sm-3">
										<div class="form-group">
											<label class="bold-label">Brand Name</label>
											<select class="form-control select2" name="brand_name" id="brandSelect" onchange="updateProductOptions(this.value)">
												<option value="">--Select--</option>
												<?php
													$query = "SELECT * FROM product_brand_name";
													$result = mysqli_query($conn, $query);
													if (mysqli_num_rows($result) > 0) {
														while ($row = mysqli_fetch_assoc($result)) { ?>
															<option value="<?php echo $row['brand_id'] ?>"><?php echo $row['brand_name'] ?></option>
														<?php
														}
													} else {
														echo '<option value="">No product available</option>';
													}
												?>
											</select>
										</div>
									</div>
									

									<div class="col-sm-3">
										<div class="form-group">
											<label class="bold-label">Product Detail Select<span class="required"> * </span></label>
											<select class="form-control select2" name="product_id" id="productSelect" onchange="productFunction()" required>
												<option value="">--Select--</option>
												
											</select>
										</div>
									</div>

									<div class="col-sm-3">
										<div class="form-group">
											<label class="bold-label">Product Color<span class="required"> * </span></label><br>

											<?php
											include "backend/db_connection.php";

											$color_query = "SELECT * FROM product_colors";
											$color_result = mysqli_query($conn, $color_query);

											if ($color_result) {
												while ($color_row = mysqli_fetch_assoc($color_result)) {
													echo '<input type="radio" id="' . $color_row['color_name'] . '" name="color" value="' . $color_row['color_name'] . '">';
													echo '<label for="' . $color_row['color_name'] . '"><span class="color-swatch" style="background-color: ' . $color_row['color_code'] . '"></span></label>';
												}
											} else {
												echo '<span class="error" style="color:red">Error fetching colors from the database</span>';
											}
											?>

											<span class="error" style="color:red" id="color_error"></span>
										</div>
									</div>

									
									<div class="col-sm-3">
										<div class="form-group">
											<label class="bold-label">Product Varient<span class="required"> * </span></label><br>
											<input type="radio" id="4-64" name="variant" value="4/64">
											<label for="4-64"><span class="variant-swatch"><Small>4/64</Small></span> </label>
											<input type="radio" id="4-128" name="variant" value="4/128">
											<label for="4-128"><span class="variant-swatch"><Small>4/128</Small></span> </label>
											<input type="radio" id="6-128" name="variant" value="6/128">
											<label for="6-128"><span class="variant-swatch"><Small>6/128</Small></span> </label>
											<input type="radio" id="8-128" name="variant" value="8/128">
											<label for="8-128"><span class="variant-swatch"><Small>8/128</Small></span> </label>
											<input type="radio" id="8-256" name="variant" value="8/256">
											<label for="8-256"><span class="variant-swatch"><Small>8/256</Small></span> </label></br>
											<span class="error" style="color:red" id="variant_error"></span>
										</div>
									</div>
									
								</div>
								<!-- ################################################################################################### -->
							
								<style>
									.select2-selection__rendered {
										width: 263px;
									}
								</style>
								<div id="productContainer" style="display: none; background-color: rgb(189 184 184); padding: 20px; border-radius: 5px; margin: 30px;">
									
									<div class="row mt-12">

										<div class="col-sm-3">
											<div class="form-group">
												<label>Brand Name</label><br>
												<select class="form-control" id="product_brand_name" name="product_brand_name">
												 <option value="">--Select--</option>
												<?php
													$query = "SELECT * FROM product_brand_name";
													$result = mysqli_query($conn, $query);
													if (mysqli_num_rows($result) > 0) {
														while ($row = mysqli_fetch_assoc($result)) { ?>
															<option value="<?php echo $row['brand_id'] ?>"><?php echo $row['brand_name'] ?></option>
														<?php
														}
													} else {
														echo '<option value="">No product available</option>';
													}
												?>
												</select>
											</div>
										</div>
									
										<div class="col-sm-3">
											<div class="form-group">
												<label>Model Name</label>
												<input type="text" class="form-control" id="model_name" name="model_name">
											</div>
										</div>
								
										<div class="col-sm-3">
											<div class="form-group">
												<label>Price <span class="required">*</span></label>
												<input type="text" class="form-control" name="price">
											</div>
										</div>

										<div class="col-sm-3">
											<div class="form-group">
												<label>Model Comment</label>
												<input type="text" class="form-control" id="productcomment" name="productcomment">
											</div>
										</div>
									</div>
								</div>

								<!-- order comment and excepted delelvery date  -->
								<h4 class="card-title"> 
									<!-- <img src="assets/img/payment-logo.png" alt="Account Logo" width="25" height="25"> -->
									Other Details Entered
								</h4>
								<br>
								<div class="row mt-12">
									<div class="col-sm-3">
										<div class="form-group">
											<label class="bold-label">Expected Delivery Date<span class="required"> * </span></label>
											<input type="date" class="form-control" name="expected_delivery_date" id="expectedDeliveryDate" required>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label class="bold-label">Order Comment</label>
											<input type="text" class="form-control" name="order_create_comment" placeholder="Add any comments related to the order">
										</div>
									</div>
								</div>
								

								<script>
									// Set Expected Delivery Date to 3 days from the current date
									const today = new Date();
									today.setDate(today.getDate() + 3);
									const formattedDate = today.toISOString().split('T')[0];
									document.getElementById('expectedDeliveryDate').value = formattedDate;
								</script>


								<div id="otherproductContainer">
									<button type="submit" class="btn btn-primary btn-lg mb-3" id="submit_button">Create Order</button>
								</div>	
							</form>
						    <!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
							
						</div>
					</div>
				</div>

				
				</div>
				</div>

			</div>
		</div>
	</div>


	<?php
		include 'notification.php';
	?>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
	<script src="assets/js/jquery-3.6.0.min.js"></script>

	<script src="assets/js/bootstrap.bundle.min.js"></script>

	<!-- <script src="assets/js/jquery.slimscroll.js"></script> -->
	<script src="assets/js/select2.min.js"></script>

	<script src="assets/js/app.js"></script>

	<script src="assets/js/jquery.dataTables.min.js"></script>

	<script src="order/js/accountOrder.js"></script>
	<script src="order/js/paymentOrder.js"></script>
	<script src="order/js/productOrder.js"></script>
	<script src="order/js/checkOrderExistence.js"></script>

	 <!-- +============================================+ -->
	|<script src="order/fetch.js"></script>        
     <!-- +============================================+ -->

<script>
      document.getElementById("order_form").onsubmit = function (event) {
        event.preventDefault();

        // Clear previous error messages
        document.querySelectorAll('.error').forEach(span => span.textContent = '');

        // Get the input fields and error message element
        const orderNoInput = document.getElementById("order_no_input");
        const orderPriceInput = document.getElementsByName("order_price")[0];
        const colorInputs = document.getElementsByName("color");
        const variantInputs = document.getElementsByName("variant");
        const errorMessage = document.getElementById("error_message");

        // Validate the order number field
        if (orderNoInput.value.trim() === "") {
          document.getElementById("order_no_error").textContent = "Order number is required.";
          return;
        }

        // Validate the order price field
        if (orderPriceInput.value.trim() === "") {
          document.getElementById("order_price_error").textContent = "Order price is required.";
          return;
        }

        // Validate at least one color is selected
        const isColorSelected = Array.from(colorInputs).some(input => input.checked);
        if (!isColorSelected) {
          document.getElementById("color_error").textContent = "Product color is required.";
          return;
        }

        // Validate that a variant is selected
        const isVariantSelected = Array.from(variantInputs).some(input => input.checked);
        if (!isVariantSelected) {
          document.getElementById("variant_error").textContent = "Product variant is required.";
          return;
        }

        // If all validations pass, you can submit the form programmatically
        this.submit();
      };
    </script>

</body>

</html>