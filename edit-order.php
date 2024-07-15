

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
							<h5 class="text-uppercase mb-0 mt-0 page-title">Update Order</h5>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-12">
							<ul class="breadcrumb float-right p-0 mb-0">
								<li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
								</li>
								<li class="breadcrumb-item"><a href="#">Order</a></li>
								<li class="breadcrumb-item"><span> Update Order</span></li>
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
					<?php
						include "backend/db_connection.php";
						$orderId = $_GET['orderId'];
						$query = "SELECT orders.*, orders.created_at AS order_created_at, accounts.*, payments.*, products.*, order_status.*
								FROM orders
								INNER JOIN accounts ON orders.account_id = accounts.account_id
								INNER JOIN payments ON orders.card_id = payments.card_id
								INNER JOIN products ON orders.product_id = products.product_id
								INNER JOIN order_status ON orders.order_status = order_status.status_id
								WHERE orderId = $orderId";

						// $query = "SELECT * from orders WHERE orderId = $orderId";

						$results = mysqli_query($conn, $query);										
						$data = mysqli_fetch_all($results, MYSQLI_ASSOC);
						
						foreach ($data as $allDataResult);
						// 	echo "<pre>";
						//     print_r($allDataResult);
						//   die;
					
					?>
				<div class="card">
					<div class="card-body">

							<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
							<form action="backend/update-order.php" id="order_form" method="POST" enctype="multipart/form-data">
								<!-- ****************************** ||Accounts Detail Update ||********************************** -->

								<spain id="otherproductContainer">
									<button type="submit" class="btn btn-primary btn-sm mb-1" id="submit_button">
										<i class="fas fa-sync-alt"></i> Update Order Details
									</button>
									<a href="all-order.php" class="btn btn-secondary btn-sm mb-1" id="cancel_button">
										<i class="fas fa-times"></i> Cancel
									</a>
								</spain>


								<h4 class="card-title"> 
									<img src="assets/img/ac.png" alt="Account Logo" width="25" height="25">
									Accounts Detail Update
								</h4> <br>
								
								<div class="row mt-12">
								<input type="hidden" class="form-control" value="<?php echo $allDataResult['orderId']; ?>" name="orderId" >
									<div class="col-sm-2">
										<div class="form-group">
											<label class="bold-label">Status<span class="required">*</span></label>
											<select id="actionButton" class="form-control select2" name="actionButton">
												<option value="">Action</option>
												<?php
												$sqlProduct = "SELECT * FROM order_status";
												$result = mysqli_query($conn, $sqlProduct);
												foreach ($result as $key => $data) {
													$selected = ($data['status_id'] == $allDataResult['status_id']) ? 'selected' : '';
												?>
													<option value="<?php echo $data['status_id'] ?>" <?php echo $selected ?>><?php echo $data['order_status_label'] ?></option>
												<?php } ?>
											</select>
										</div>
									</div>


									<div class="col-sm-2">
										<div class="form-group">
											<label class="bold-label">Store Name<span class="required">*</span></label>
											<select class="form-control select2" name="account_group" required onchange="fetchAccounts(this.value)">
												<?php
													$query = "SELECT * FROM store";
													$result = mysqli_query($conn, $query);

													if (mysqli_num_rows($result) > 0) {
														while ($row = mysqli_fetch_assoc($result)) {
															$isSelected = ($row['store_id'] == $allDataResult['account_group']) ? 'selected' : '';

															echo '<option value="' . $row['store_id'] . '" ' . $isSelected . '>';
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
									<?php
									$account_groupId = $allDataResult['account_group'];
									$queryAccount = "SELECT * FROM accounts where account_group = $account_groupId ";
									$resultAccount = mysqli_query($conn, $queryAccount);
									?>
									<div class="col-sm-3">
										<div class="form-group">
											<label class="bold-label">Account Detail<span class="required">*</span></label>
											<select class="form-control select2" name="account_id" onchange="accountFunction()" required>
											<?php while ($rowAccount = mysqli_fetch_assoc($resultAccount)) { 
												 $isSelectedAccount = ($rowAccount['account_id'] == $allDataResult['account_id']) ? 'selected' : '';
												?>
												<option value="<?php echo $rowAccount['account_id']?>"  <?php echo $isSelectedAccount ?> ><?php echo $rowAccount['mobile_number'] . '|' . $rowAccount['account_holder_name']; ?>
 												</option>
												<?php } ?>
											</select>
										</div>
									</div>
							
									<div class="col-sm-3">
										<div class="form-group">
											<label class="bold-label">Order No<span class="required"> * </span></label>
											<input type="text" class="form-control" name="order_no" value="<?php echo $allDataResult['order_no']; ?>" id="order_no_input">
											<p id="order_status"></p>
											<span class="error" style="color:red" id="order_no_error"></span>

										</div>
									</div>

									<div class="col-sm-2">
										<div class="form-group">
											<label class="bold-label"> Order Comment </label>
											<input type="text" class="form-control" value="<?php echo $allDataResult['order_create_comment']; ?>" name="order_create_comment" id="order_create_comment">
											<p id="order_status"></p>
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
									Payment Detail Update
								</h4> <br>
								<div class="row mt-12">
									<div class="col-sm-3">
										<div class="form-group">
											<label class="bold-label">Payment Mode<span class="required"> * </span></label>
											<select class="form-control select2" name="payment_mode" required>
											<option value="Credit" <?php echo ($allDataResult['card_type'] == 'Credit') ? 'selected' : ''; ?>>Credit</option>
											<option value="Debit" <?php echo ($allDataResult['card_type'] == 'Debit') ? 'selected' : ''; ?>>Debit</option>
											<option value="Account" <?php echo ($allDataResult['card_type'] == 'Account') ? 'selected' : ''; ?>>Account</option>
											<option value="cod" <?php echo ($allDataResult['card_type'] == 'cod') ? 'selected' : ''; ?>>Cash On Delevery</option>
											</select>
										</div>
									</div>
									<?php
									$cardId = $allDataResult['card_id'];
									$querysqlBankId = "SELECT * FROM payments where card_id = $cardId";
									$resultssqlBankId = mysqli_query($conn, $querysqlBankId);
																			
									while ($resultBankId = mysqli_fetch_assoc($resultssqlBankId)) {
										 $bankId = $resultBankId['card_provider_bank'];
									}
									?>

									<div class="col-sm-3">
										<div class="form-group">
											<label class="bold-label">Card Provider Bank Name <span class="required">*</span></label>
											<select class="form-control select2" name="choosing_card_provider_bank" onchange="paymentModeChange()" required>
												<option value="">--Select--</option>
											    <?php
												
													$querysql = "SELECT * FROM bank_name where bank_status=1";
													$resultssql = mysqli_query($conn, $querysql);
																							
													while ($resultsql = mysqli_fetch_assoc($resultssql)) {
													
														$selected = ($resultsql['bank_id'] == $bankId) ? 'selected' : '';
       													echo "<option value='" . $resultsql['bank_id'] . "' $selected>" . $resultsql['bank_name'] . "</option>";
													} ?>
											</select>
										</div>
									</div>
								
									<div class="col-sm-3">
										<div class="form-group">
											<label class="bold-label">Card No Select<span class="required"> * </span></label>
											<select class="form-control select2" name="card_id" onchange="paymentFunction()" required>
												<option value="">--Select--</option>
												<?php
												
												$sqlBank = "SELECT * FROM payments where card_provider_bank = $bankId ";
												$resultsBank = mysqli_query($conn, $sqlBank);
																						
												while ($resultBank = mysqli_fetch_assoc($resultsBank)) {
												
													$selected = ($resultBank['card_id'] == $allDataResult['card_id']) ? 'selected' : '';
													   echo "<option value='" . $resultBank['card_id'] . "' $selected>" . "XXXX-".$resultBank['card_number'] .' | '. $resultBank['card_holder_name']. "</option>";
												} ?>
											</select>
										</div>
									</div>

									<script type="text/javascript">
										window.onload = function() {
											paymentFunction();
											accountFunction();
										};
									</script>

									<div class="col-sm-3" >
										<div class="form-group">
											<label class="bold-label">Order Price <span class="required">*</span></label>
											<input type="number" class="form-control" value="<?php echo $allDataResult['order_price']; ?>" name="order_price">
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

								 <!-- *********************************** ||product Details Update ***************************************-->
				 				<!-- ####################################################################################################### -->
								<h4 class="card-title"> 
									<img src="assets/img/product.png" alt="Account Logo" width="25" height="25">
									Product Details Update
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
														while ($row = mysqli_fetch_assoc($result)) { 
															$selected = ($allDataResult['brand'] == $row['brand_id']) ? 'selected' : '';?>
														
															<option value="<?php echo $row['brand_id'] ?>" <?php echo $selected ?>><?php echo $row['brand_name'] ?></option>
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
												<?php
												
												$brandId = $allDataResult['brand'];	
												$sqlproducts = "SELECT * FROM products where brand = $brandId ";
												$resultsproducts = mysqli_query($conn, $sqlproducts);
																				
												while ($resultproducts = mysqli_fetch_assoc($resultsproducts)) {
												
													$selected = ($resultproducts['product_id'] == $allDataResult['product_id']) ? 'selected' : '';
													   echo "<option value='" . $resultproducts['product_id'] . "'$selected >" .$resultproducts['model_name'] . "</option>";
												} ?>
											</select>
										</div>
									</div>
									<script type="text/javascript">
										window.onload = function() {
											paymentFunction();
											accountFunction();
											productFunction();
										};
									</script>
									<div class="col-sm-3">
										<div class="form-group">
											<label class="bold-label">Product Color<span class="required"> * </span></label><br>
											<?php
											$colors = ['gold', 'green', 'blue', 'black']; // List of available colors

											foreach ($colors as $color) {
												$checked = ($allDataResult['color'] == $color) ? 'checked' : '';
												?>
												<input type="radio" id="<?php echo $color; ?>" name="color" value="<?php echo $color; ?>" <?php echo $checked; ?>>
												<label for="<?php echo $color; ?>"><span class="color-swatch" style="background-color: <?php echo $color; ?>;"></span> </label>
												<?php
											}
											?>
											<br>
											<span class="error" style="color:red" id="color_error"></span>
										</div>
									</div>

									
									<div class="col-sm-3">
										<div class="form-group">
											<label class="bold-label">Product Variant<span class="required"> * </span></label><br>
											<?php
											$variants = ['4/64', '4/128', '6/128', '8/128', '8/256']; // List of available variants

											foreach ($variants as $variant) {
												$checked = ($allDataResult['varient'] == $variant) ? 'checked' : '';
												?>
												<input type="radio" id="<?php echo str_replace('/', '-', $variant); ?>" name="variant" value="<?php echo $variant; ?>" <?php echo $checked; ?>>
												<label for="<?php echo str_replace('/', '-', $variant); ?>"><span class="variant-swatch"><small><?php echo $variant; ?></small></span> </label>
												<?php
											}
											?>
											<br>
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
												<label>Brand Names</label><br>
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

								<div id="otherproductContainer">
									<button type="submit" class="btn btn-primary btn-sm mb-1" id="submit_button">
										<i class="fas fa-sync-alt"></i> Update Order Details
									</button>
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
	<script src="order/js/checkOrderExistenceUpdate.js"></script>

	 <!-- +============================================+ -->
	 <!-- all the dropdown filter js file  -->
	|<script src="order/fetch.js"></script>        
     <!-- +============================================+ -->

<!--featching the acount detail based on the deopdown of account secton  -->
<script>
      document.getElementById("order_form").onsubmit = function (event) {
        // Prevent the default form submission
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