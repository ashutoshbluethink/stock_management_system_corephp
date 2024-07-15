<?php
session_start();
?>
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

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
  
        $card_id = $_GET['card_id'];
        $query = "SELECT * FROM payments WHERE card_id = $card_id";
        $result = mysqli_query($conn, $query);
        $card = mysqli_fetch_assoc($result);
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
								<li class="breadcrumb-item"><span> Edit Card</span></li>
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
                    if (isset($_SESSION['successMessage']) && !empty($_SESSION['successMessage'])) {
						echo $_SESSION['successMessage'];
                        echo '<script>
                        $(document).ready(function() {
                            toastr.success("' . $_SESSION['successMessage'] . '", "", { 
                                timeOut: 5000, 
                                progressBar: true,
                                positionClass: "toast-top-center"
                            });
                        });
                        </script>';
                        $_SESSION['successMessage'] = ""; // Clear the session variable
                    }
                    ?>
                    <!-- #################################################################################################### -->

				<div class="page-content">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                            <form action="backend/edit-card.php" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="card_id" value="<?php echo $card['card_id']; ?>">
                                                <div class="row mt-3">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Card Type <span class="required">*</span></label>
                                                            <select class="form-control select" name="card_type" onchange="toggleCardFields(this)">
                                                                <option value="Credit" <?php if ($card['card_type'] === 'Credit') echo 'selected'; ?>>Credit</option>
                                                                <option value="Debit" <?php if ($card['card_type'] === 'Debit') echo 'selected'; ?>>Debit</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Card Type <span class="required">*</span></label>
                                                            <select class="form-control select" name="account_type">
                                                                <option value="self" <?php if ($card['account_type'] === 'self') echo 'selected'; ?>>Self</option>
                                                                <option value="custom" <?php if ($card['account_type'] === 'custom') echo 'selected'; ?>>Custom</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Card Provider Company <span class="required">*</span></label>
                                                            <select class="form-control select" name="card_provider_company">
                                                                <option value="other" <?php if ($card['card_provider_company'] === 'other') echo 'selected'; ?>>Other</option>
                                                                <option value="flipcart" <?php if ($card['card_provider_company'] === 'flipcart') echo 'selected'; ?>>Flipcart</option>
                                                                <option value="amazon" <?php if ($card['card_provider_company'] === 'amazon') echo 'selected'; ?>>Amazon</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Card Number last 4 digits <span class="required">*</span></label>
                                                            <input type="text" class="form-control" placeholder="XXXX-XXXX-XXXX-XXXX-4" name="card_number" id="card_number" maxlength="4" value="<?php echo $card['card_number']; ?>">
                                                            <p id="card_status"></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Card Holder Name <span class="required">*</span></label>
                                                            <input type="text" class="form-control" name="card_holder_name" value="<?php echo $card['card_holder_name']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Card Provider Bank Name <span class="required">*</span></label>
                                                            <select class="form-control select" name="card_provider_bank" required>
                                                                <option value="">--Select--</option>
                                                                <?php
                                                                $query = "SELECT * FROM bank_name where bank_status=1";
                                                                $results = mysqli_query($conn, $query);
                                                                while ($result = mysqli_fetch_assoc($results)) {
                                                                    $selected = ($result['bank_id'] == $card['card_provider_bank']) ? 'selected' : '';
                                                                    echo "<option value='" . $result['bank_id'] . "' $selected>" . $result['bank_name'] . "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Expiration Date</label>
                                                            <input type="text" class="form-control" name="expiration_date" placeholder="MM/YYYY" value="<?php echo $card['expiration_date']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Cvv</label>
                                                            <input type="number" name="cvv" class="form-control" value="<?php echo $card['cvv']; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3" id="billingCardFields">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Billing Date</label>
                                                            <input type="date" name="billing_date" class="form-control" min="1" max="31" value="<?php echo $card['billing_date']; ?>">
                                                            <p id="error-message" style="color: red; display: none;"></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Card Limit</label>
                                                            <input type="number" name="card_limit" class="form-control" value="<?php echo $card['card_limit']; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Upload Image</label>
                                                            <input type="file" name="image" accept="image/*" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Comment</label>
                                                            <textarea class="form-control" name="comment"><?php echo $card['comment']; ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                        <label class="focus-label">Status</label>
                                                            <select name="card_status" class="select form-control">
                                                                <option value="">--All--</option>
                                                                <option value="1" <?php if (isset($card['card_status']) && $card['card_status'] === "1") echo 'selected'; ?>>Active</option>
                                                                <option value="0" <?php if (isset($card['card_status']) && $card['card_status'] === "0") echo 'selected'; ?>>Inactive</option>
                                                            </select>
                                                            
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-group text-center custom-mt-form-group">
                                                    <button class="btn btn-warning mr-2" type="submit" name="submit">Update</button>
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
    
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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
    xhr.open('GET', 'order/check_card_number_edit.php?card_number=' + card_number, true);
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