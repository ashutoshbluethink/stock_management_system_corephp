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

</head>

<body>

	<div class="main-wrapper">

		<?php
		include 'header.php';
		include 'sidebar.php';
		
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
				<div class="page-content">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-6 col-12">
											<form action="backend/product_backend.php" method="POST" enctype="multipart/form-data">
												<div class="form-group">
													<label>Brand Name</label>
													<select class="form-control" name="brand_name">
														<option value="MI">MI</option>
														<option value="Samsung">Samsung</option>
														<option value="Realme">Realme</option>
														<option value="Vivo">Vivo</option>
														<option value="Oppo">Oppo</option>
														<option value="Infinix">Infinix</option>
														<option value="OnePlus">OnePlus</option>
														<option value="Other">Other</option>
													</select>
												</div>
												<div class="form-group">
													<label>Model Name</label>
													<input type="text" class="form-control" name="model_name">
												</div>
												<div class="form-group">
													<label>Price</label>
													<input type="text" class="form-control" name="price">
												</div>
												<div class="form-group">
													<label>Image</label>
													<input type="file" name="product_image" accept="image/*" class="form-control">
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
</body>



</html>