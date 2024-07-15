<?php
 session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Product list</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

	<!-- CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="assets/css/select2.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
	<link rel="stylesheet" href="dist/css/adminlte.min2167.css?v=3.2.0">
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
							<h5 class="text-uppercase mb-0 mt-0 page-title">Card</h5>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-12">
							<ul class="breadcrumb float-right p-0 mb-0">
								<li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
								</li>
								<li class="breadcrumb-item"><a href="#">Card</a></li>
								<li class="breadcrumb-item"><span> All Card</span></li>
							</ul>
						</div>
					</div>
				</div>

                <!-- //massage manager  -->
                <!-- ####################################################################################################### -->

                <script src="assets/js/jquery-3.6.0.min.js"></script>
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
                <!-- //massage manager  -->

				<div class="row">
					<div class="col-sm-4 col-12">
					</div>
					<div class="col-sm-8 col-12 text-right add-btn-col">
						<a href="add-card.php" class="btn btn-primary float-right btn-rounded"><i
								class="fas fa-plus"></i> Add Card</a>
						<div class="view-icons">
							<a href="all-card.php" class="grid-view btn btn-link"><i class="fas fa-th"></i></a>
							<a href="card-list.php" class="list-view btn btn-link active"><i
									class="fas fa-bars"></i></a>
						</div>
					</div>
				</div>
					<div class="content-page">
					<form action="" method="POST">
						<div class="row filter-row">
							<div class="col-sm-6 col-md-3">
								<div class="form-group form-focus select-focus">
									<select name="price-filter" class="select form-control">
										<option value="">--All--</option>
										<option value="5k-10k" <?php if (isset($_POST['price-filter']) && $_POST['price-filter'] === "5k-10k") echo 'selected'; ?>>5k to 10k</option>
										<option value="10k-15k" <?php if (isset($_POST['price-filter']) && $_POST['price-filter'] === "10k-15k") echo 'selected'; ?>>10k to 15k</option>
										<option value="15k-20k" <?php if (isset($_POST['price-filter']) && $_POST['price-filter'] === "15k-20k") echo 'selected'; ?>>15k to 20k</option>
										<option value="20k-30k" <?php if (isset($_POST['price-filter']) && $_POST['price-filter'] === "20k-30k") echo 'selected'; ?>>20k to 30k</option>
										<option value="30k-50k" <?php if (isset($_POST['price-filter']) && $_POST['price-filter'] === "30k-50k") echo 'selected'; ?>>30k to 50k</option>
									</select>
									<label class="focus-label">Price Range</label>
								</div>
							</div>
							<div class="col-sm-6 col-md-3">
								<div class="form-group form-focus select-focus">
									<select name="status-filter" class="select form-control">
										<option value="">--All--</option>
										<option value="1" <?php if (isset($_POST['status-filter']) && $_POST['status-filter'] === "1") echo 'selected'; ?>>Active</option>
										<option value="0" <?php if (isset($_POST['status-filter']) && $_POST['status-filter'] === "0") echo 'selected'; ?>>Inactive</option>
									</select>
									<label class="focus-label">Status</label>
								</div>
							</div>
							<div class="col-sm-6 col-md-3">
								<div class="form-group form-focus select-focus">
									<select name="brand-filter" class="select form-control">
										<option value="">--All--</option>
										<?php
										$query = "SELECT * FROM product_brand_name";
										$result = mysqli_query($conn, $query);
										if (mysqli_num_rows($result) > 0) {
											while ($row = mysqli_fetch_assoc($result)) { ?>
												<option value="<?php echo $row['brand_id'] ?>" <?php if (isset($_POST['brand-filter']) && $_POST['brand-filter'] == $row['brand_id']) echo 'selected'; ?>><?php echo $row['brand_name'] ?></option>
											<?php
											}
										} else {
											echo '<option value="">No product available</option>';
										}
										?>
									</select>
									<label class="focus-label">Brand Name</label>
								</div>
							</div>
							<div class="col-sm-6 col-md-3">
								<button type="submit" class="btn btn-search rounded btn-block mb-3">Search</button>
							</div>
						</div>
					</form>

					</div>
					<div class="row">
						<div class="col-md-12 mb-3">
							<div class="table-responsive">
							<table id="example1" class="table table-bordered table-striped">
									<thead class="thead-light">
										<tr>
											<th>Products ID</th>
											<th>brand </th>
											<th>model_name</th>
											<th>Brand Image</th>
											<th>price</th>
											<th>comment</th>
											<th>created_at</th>
											<th>Status</th>
											<th class="text-right">Action</th>
										</tr>
									</thead>
									<tbody>

									<?php
										$whereClause = "1 = 1"; 

										if (isset($_POST['price-filter']) && !empty($_POST['price-filter'])) {
											$priceFilter = $_POST['price-filter'];
											if ($priceFilter === "5k-10k") {
												$whereClause .= " AND price >= 5000 AND price <= 10000";
											} elseif ($priceFilter === "10k-15k") {
												$whereClause .= " AND price >= 10000 AND price <= 15000";
											} elseif ($priceFilter === "15k-20k") {
												$whereClause .= " AND price >= 15000 AND price <= 20000";
											} elseif ($priceFilter === "20k-30k") {
												$whereClause .= " AND price >= 20000 AND price <= 30000";
											} elseif ($priceFilter === "30k-50k") {
												$whereClause .= " AND price >= 30000 AND price <= 50000";
											}
										}

										if (isset($_POST['status-filter']) && ($_POST['status-filter'] === "1" || $_POST['status-filter'] === "0")) {
											$statusFilter = $_POST['status-filter'];
											$whereClause .= " AND productstatus = $statusFilter";
										}

										if (isset($_POST['brand-filter']) && !empty($_POST['brand-filter'])) {
											$brandFilter = $_POST['brand-filter'];
											$whereClause .= " AND brand = $brandFilter";
										}

										$query = "SELECT * FROM products WHERE $whereClause";

										$results = mysqli_query($conn, $query);

										while ($result = mysqli_fetch_assoc($results)) {
											// Output the filtered product data
										// }
										?>

										<?php
										
											// $query = "SELECT * FROM products";
											// $results = mysqli_query($conn, $query);
											// while ($result = mysqli_fetch_assoc($results)) {
										?>
										<tr>
											<td>
												<h2>
												
												<a href="#" class="avatar"><?php echo $result['product_id']; ?></a>
												</h2>
											</td>
											<td>
												<h2>
													<?php
													$brand=$result['brand'];
														$query_Brand = "SELECT * FROM product_brand_name where brand_id = $brand";
															$result_Brand  = mysqli_query($conn, $query_Brand );
															$Brand_data = mysqli_fetch_assoc($result_Brand );
														?>
													<a href="#"> 
													<img id="imagePreview" src="assets/img/brand_logo/<?php echo $Brand_data['brand_img'] ?>" alt="imagePreview" width="40" height="30">
													<?php echo $Brand_data['brand_name'] ?>
														</a>
												</h2>
											</td>

											<td><?php echo $result['model_name']; ?></td>
											<td><?php echo '<img src="uploads/product/' . $result['product_image'] . '" alt="Product Logo" width="40" height="27">' ?></td>
											<td><?php echo $result['price']; ?>
											<td><?php echo $result['comment']; ?></td>
											<td><?php echo $result['created_at']; ?></td>

											<td>
												<a href="backend/product_status.php?product_id_list=<?php echo $result['product_id']; ?>">
													<span class="<?php echo ($result['productstatus'] == 1) ? 'badge badge-success' : 'badge badge-danger'; ?>">
													<?php echo ($result['productstatus'] == 1) ? 'Active' : 'Inactive'; ?>
													</span>
												</a>
											</td>
																								
											<td class="text-right">
												<a href="product_edit.php?product_id_list=<?php echo $result['product_id']; ?>" class="btn btn-primary btn-sm mb-1">
													<i class="far fa-edit"></i>
												</a>
												<button type="submit" data-toggle="modal" data-target="#delete_employee"
													class="btn btn-danger btn-sm mb-1">
													<i class="far fa-trash-alt"></i>
												</button>
											</td>
										</tr>
									<?php
									}
									?>
									</tbody>
								</table>
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
	<script src="assets/js/jquery.dataTables.min.js"></script>
	<script src="assets/js/dataTables.bootstrap4.min.js"></script>
	<script src="assets/js/select2.min.js"></script>
	<script src="assets/js/moment.min.js"></script>
	<script src="assets/plugins/datetimepicker/js/tempusdominus-bootstrap-4.min.js"></script>
	<script src="assets/js/app.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

	
	<script src="plugins/jquery/jquery.min.js"></script>
	<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="plugins/jszip/jszip.min.js"></script>
	<script src="plugins/pdfmake/pdfmake.min.js"></script>
	<script src="plugins/pdfmake/vfs_fonts.js"></script>
	<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
	<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

		<div id="delete_employee" class="modal" role="dialog">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content modal-md">
					<div class="modal-header">
						<h4 class="modal-title">Delete student</h4>
					</div>
					<form>
						<div class="modal-body">
							<p>Are you sure want to delete this?</p>
							<div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
								<button type="submit" class="btn btn-danger">Delete</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script>
	$(function () {
			$("#example1").DataTable({
				"responsive": true,
				"lengthChange": false,
				"autoWidth": false,
				"buttons": ["pdf", "print"],
				"order": [[0, "desc"]],
				"pageLength": 10 
			}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
		});
	</script>
</html>