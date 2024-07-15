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
	<title>MKSP - add-Product</title>
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
							<h5 class="text-uppercase mb-0 mt-0 page-title">Add Product</h5>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-12">
							<ul class="breadcrumb float-right p-0 mb-0">
								<li class="breadcrumb-item"><a href="dashboard.php"><I class="fas fa-home"></i> Home</a>
								</li>
								<li class="breadcrumb-item"><a href="add-card.php">Product</a></li>
								<li class="breadcrumb-item"><span> Add Product</span></li>
							</ul>
						</div>
					</div>
				</div>

                <!-- //massage manager  -->
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
                <!-- //massage manager  -->
				<div class="page-content">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-6 col-12">
											<form action="backend/add-product.php" method="POST" enctype="multipart/form-data">
												<div class="form-group">
													<label>Select The Product Brand Name</label>
													<select class="form-control select2" name="brand_name">
													<?php
													$query = "SELECT * FROM product_brand_name";
													$result = mysqli_query($conn, $query);
													if (mysqli_num_rows($result) > 0) {
														while ($row = mysqli_fetch_assoc($result)) { ?>
															<option value="<?php echo $row['brand_id'] ?>"><?php echo $row['brand_name'] ?></option>
														<?php
														}
													} else {
														echo '<option value="">No stores available</option>';
													}
													?>
													</select>
												</div>

												<div class="form-group">
													<label>Product Model Detail</label>
													<input type="text" class="form-control" placeholder="Enter the Product Name" name="model_name">
												</div>
												<div class="form-group">
													<label>Price</label>
													<input type="text" class="form-control" placeholder="Rs 0.00" name="price">
												</div>
												<div class="container">
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label>Image</label>
																<input type="file" onchange="previewImage(this);" name="product_image" accept="image/*" class="form-control">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label>Image Preview</label><br>
																<img id="imagePreview" src="assets/img/brand_logo/placeholder.jpg" alt="imagePreview" width="80" height="80">
															</div>
														</div>
													</div>
												</div>


												<div class="form-group">
													<label>Comment</label>
													<textarea class="form-control" name="comment"></textarea>
												</div>
												<div class="form-group text-center custom-mt-form-group">
													<button class="btn btn-primary mr-2" type="submit">Submit</button>
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

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

<script>
    function previewImage(input) {
        var preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '';
        }
    }
</script>
</body>



</html>