<!DOCTYPE html>
<html lang="en">


<head>
	<meta charset="utf-8">
	<title>MKSP - add-card</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">

	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">

	<link rel="stylesheet" href="assets/plugins/datetimepicker/css/tempusdominus-bootstrap-4.min.css">

	<link rel="stylesheet" href="assets/css/select2.min.css">

	<link rel="stylesheet" href="assets/plugins/datetimepicker/css/tempusdominus-bootstrap-4.min.css">

	<link rel="stylesheet" href="assets/css/style.css">
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
							<h5 class="text-uppercase mb-0 mt-0 page-title">add card</h5>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-12">
							<ul class="breadcrumb float-right p-0 mb-0">
								<li class="breadcrumb-item"><a href="dashboard.php"><I class="fas fa-home"></i> Home</a>
								</li>
								<li class="breadcrumb-item"><a href="add-card.php">Card</a></li>
								<li class="breadcrumb-item"><span> Add Card</span></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="page-content">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-6 col-12">
											<form action="backend/add-card.php" method="POST" enctype="multipart/form-data">
											<div class="col-sm-12" style="text-align: center; background-color: #f0f0f0; padding: 5px;">
												<p style="font-weight: bold; color: #333;">* Fields marked with an asterisk are mandatory</p>
											</div>
											<div class="row mt-3">
												<div class="col-sm-6">
													<div class="form-group">
														<label class="font-weight-bold" >Card Type <span class="required">*</span></label>
														<select class="form-control select" name="card_type"onchange="toggleCardFields(this)">
															<option value="Credit">Credit</option>
															<option value="Debit">Debit</option>
														</select>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="font-weight-bold" >Card Type <span class="required">*</span> </label>
														<select class="form-control select" name="account_type">
															<option value="self">Self</option>
															<option value="custom">Custom</option>
														</select>
													</div>
												</div>
											</div>

											<div class="row mt-3">

												<div class="col-sm-6">
													<div class="form-group">
														<label class="font-weight-bold" >Card Provider Company <span class="required">*</span></label>
														<div class="input-group select-group">
															<select class="form-control select" name="card_provider_company">
																<option value="other">Other</option>
																<option value="flipcart">Flipcart</option>
																<option value="amazon">Amazon</option>
															</select>
														</div>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group">
														<label class="font-weight-bold" >Card Provider Bank Name <span class="required">*</span> </label>
														<select class="form-control select" name="card_provider_bank" required>
                                                            <option value="">--Select--</option>
                                                            <?php $query = "SELECT * FROM bank_name where bank_status=1";
                                                            $results = mysqli_query($conn, $query);
                                                            										
                                                            while ($result = mysqli_fetch_assoc($results)) {
                                                         
                                                                echo "<option value='" . $result['bank_id'] . "'>" . $result['bank_name'] . "</option>";
                                                            } ?>
                                                            </select>
													</div>
												</div>
											</div>
												
											<div class="row mt-3">
												<div class="col-sm-6">
													<div class="form-group">
														<label class="font-weight-bold" >Card Holder Name <span class="required">*</span> </label>
														<div class="input-group">
															<div class="input-group-prepend">
																<span class="input-group-text"><i class="fas fa-user"></i></span>
															</div>
															<input type="text" class="form-control" name="card_holder_name">
														</div>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group">
														<label class="font-weight-bold">Card Number <span class="required">*</span></label>
														<div class="input-group">
															<div class="input-group-prepend">
																<span class="input-group-text"><i class="fas fa-credit-card"></i></span>
															</div>
															<input type="text" class="form-control with-logo" placeholder="XXXX" name="card_number" id="card_number" maxlength="4">
														</div>
														<p id="card_status"></p>
													</div>
												</div>
											</div>
											<div class="row mt-3">
												<div class="col-sm-6">
													<div class="form-group">
														<label class="font-weight-bold">Expiration Date</label>
														<div class="input-group">
															<span class="input-group-text">
																<i class="fas fa-calendar"></i>
															</span>
															<input type="text" class="form-control" name="expiration_date" placeholder="MM/YYYY" aria-label="Expiration Date">
															<div class="input-group-append">
															</div>
														</div>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group">
														<label class="font-weight-bold">Cvv</label>
														<div class="input-group">
															<span class="input-group-prepend">
																<span class="input-group-text"><i class="fas fa-credit-card"></i></span>
															</span>
															<input type="number" name="cvv" class="form-control" placeholder="Enter CVV" aria-label="CVV">
														</div>
													</div>
												</div>

											</div>

											<div class="row mt-3" id="billingCardFields">
												<div class="col-sm-6">
													<div class="form-group">
														<label class="font-weight-bold">Billing Date</label>
														<div class="input-group">
															<span class="input-group-prepend">
																<span class="input-group-text"><i class="fas fa-calendar"></i></span>
															</span>
															<input type="number" name="billing_date" class="form-control" min="1" max="31" placeholder="Enter Billing Date" aria-label="Billing Date">
														</div>
														<p id="error-message" style="color: red; display: none;"></p>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group">
														<label class="font-weight-bold">Card Limit</label>
														<div class="input-group">
															<span class="input-group-prepend">
																<span class="input-group-text"><i class="fas fa-credit-card"></i></span>
															</span>
															<input type="number" name="card_limit" class="form-control" placeholder="Enter Card Limit" aria-label="Card Limit">
														</div>
													</div>
												</div>
											</div>

											<div class="row mt-3">
												<div class="col-sm-6">
													<div class="form-group">
														<label class="font-weight-bold">Upload Image</label>
														<div class="input-group">
															<span class="input-group-text">
																<i class="fas fa-upload"></i>
															</span>
															<input type="file" name="image" accept="image/*" class="form-control" aria-label="Upload Image">
															<div class="input-group-append">
														
															</div>
														</div>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group">
														<label class="font-weight-bold" >Comment</label>
														<textarea class="form-control" name="comment"></textarea>
													</div>
												</div>
											</div>

												<div class="form-group text-center custom-mt-form-group">
													<button class="btn btn-primary mr-2" type="submit" name="submit">Submit</button>
													<button class="btn btn-secondary" type="reset">Cancel</button>
												</div>
											</form>
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
		</div>
	</div>



	<script src="assets/js/jquery-3.6.0.min.js"></script>

	<script src="assets/js/bootstrap.bundle.min.js"></script>

	<!-- <script src="assets/js/jquery.slimscroll.js"></script> -->

	<script src="assets/js/select2.min.js"></script>

	<script src="assets/js/moment.min.js"></script>
	<script src="assets/plugins/datetimepicker/js/tempusdominus-bootstrap-4.min.js"></script>

	<script src="assets/js/app.js"></script>
</body>

<script>
function toggleCardFields(selectElement) {
  var billingCardFields = document.getElementById("billingCardFields");
  if (selectElement.value === "Debit") {
    billingCardFields.style.display = "none";
  } else {
    billingCardFields.style.display = "block";
  }
}



 // Function to check if the order ID exists
 function checkcardExistence() {
    var card_number = document.getElementById('card_number').value;
	
    // Make an AJAX request to the server-side script
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'order/check_card_number.php?card_number=' + card_number, true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var card_numberExists = JSON.parse(xhr.responseText);

        var cardStatusElement = document.getElementById('card_status');
        var submitButton = document.getElementById('submit_button');
        
        if (card_numberExists) {
          cardStatusElement.style.color = 'red';
          cardStatusElement.textContent = 'This card no already exists!';
		  submitButton.disabled = true;
          
          // Disable the submit button
          submitButton.disabled = true;
        } else {
          cardStatusElement.style.color = '';
          cardStatusElement.textContent = '';
          
          // Enable the submit button
          submitButton.disabled = false;
        }
      }
    };
    xhr.send();
  }

  // Add event listener to the input field
  var cardInput = document.getElementById('card_number');
  cardInput.addEventListener('blur', checkcardExistence);


</script>



</html>