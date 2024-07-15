<?php
session_start();
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

	<link rel="stylesheet" href="assets/css/style.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
	<div class="main-wrapper">
		<div class="account-page">
			<div class="container">
				<h3 class="account-title text-white">Login</h3>

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
						?>
               		 <!-- #################################################################################################### -->

				<div class="account-box">
					<div class="account-wrapper">
					<style>
    .rounded-image {
        border-radius: 50%;
        overflow: hidden;
        width: 100px; /* Adjust the width as needed */
        height: 180px; /* Adjust the height as needed */
    }
</style>

<div class="account-logo">
    <a href="backend/login.php">
        <img class="rounded-image" src="assets/img/login logo.png" alt="login">
    </a>
</div>
						<form action="backend/login.php" method="POST">
							<div class="form-group">
								<label>Username or Email</label>
								<input type="text" class="form-control" name="username">
							</div>
							<div class="form-group">
								<label>Password</label>
								<input type="password" class="form-control" name="password">
							</div>
							<div class="form-group text-center custom-mt-form-group">
								<button class="btn btn-primary btn-block account-btn" type="submit">Login</button>
							</div>
							<div class="text-center">
								<a href="forgot-password.html">Forgot your password?</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<script src="assets/js/jquery-3.6.0.min.js"></script>

	<script src="assets/js/bootstrap.bundle.min.js"></script>

	<!-- <script src="assets/js/jquery.slimscroll.js"></script> -->

	<script src="assets/js/app.js"></script>
</body>


</html>