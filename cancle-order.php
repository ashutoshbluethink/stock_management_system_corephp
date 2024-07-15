<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Order List</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

	<!-- CSS -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
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

	<!-- <style>
		table#example1 tbody td {
			font-size: 12px;
		}
	</style> -->

</head>
<body>
	<div class="main-wrapper">
		<?php
		include 'header.php'; // Include header file
		include 'sidebar.php'; // Include sidebar file
		?>
		<div class="page-wrapper">
			<div class="content container-fluid">
				<div class="page-header">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-12">
							<h5 class="text-uppercase mb-0 mt-0 page-title">Order List</h5>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-12">
							<ul class="breadcrumb float-right p-0 mb-0">
								<li class="breadcrumb-item"><a href="index.html"><i class="fas fa-home"></i> Home</a></li>
								<li class="breadcrumb-item"><a href="#">Orders</a></li>
								<li class="breadcrumb-item"><span> Orders List</span></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4 col-12">
					</div>
					<div class="col-sm-8 col-12 text-right add-btn-col">
						<a href="add-order.php" class="btn btn-primary float-right btn-rounded"><i class="fas fa-plus"></i> Add Orders</a>
					</div>
				</div>
				<div class="content-page">
					<div class="row">
						<div class="col-lg-12 mb-3">
							<div class="table-responsive">
								<table id="example1" class="table table-bordered table-striped">
									<thead class="thead-dark">
										<tr>
											<!-- <th>dest_region_id</th> -->
											<th>Country</th>
											<th>Region/State</th>
											<th>Region Name</th>
											<th>Zip/Postal Code</th>
											<th>Order Subtotal (and above)</th>
											<th>Shipping Price</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$host = 'localhost';
										$dbName = 'gkakhhuhfz';
										$username = 'root';
										$password = 'admin@123';
										$countryId = 'QA'; 
										$regionId = 'CA'; 

										$mysqli = new mysqli($host, $username, $password, $dbName);

										if ($mysqli->connect_error) {
											die("Connection failed: " . $mysqli->connect_error);
										}

										// $sql = "SELECT * FROM shipping_tablerate WHERE dest_country_id = '$countryId' ";
										

										$sql = "SELECT
										st.*,
										dcr.*
										FROM shipping_tablerate st
										LEFT JOIN directory_country_region dcr
										ON st.dest_region_id = dcr.region_id
										WHERE st.dest_country_id = '$countryId'";

										$result = $mysqli->query($sql);

										if ($result) {
											while ($row = $result->fetch_assoc()) {
												echo '<tr>';
												// echo '<td>' . $row['dest_region_id'] . '</td>';
												echo '<td>' . $row['dest_country_id'] . '</td>';
												echo '<td>' . $row['code'] . '</td>';
												echo '<td>' . $row['default_name'] . '</td>';
												echo '<td>' . $row['dest_zip'] . '</td>';
												// echo '<td>' . $row['condition_name'] . '</td>';
												echo '<td>' . 1 . '</td>';
												echo '<td>' . $row['price'] . '</td>';
												echo '</tr>';
											}
										} 
										?>
									</tbody>
								</table>
								code
							</div>
						</div>
					</div>
				</div>
				<?php
				include 'notification.php';
				?>
			</div>
		</div>
		<div id="delete_employee" class="modal" role="dialog">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content modal-md">
					<div class="modal-header">
						<h4 class="modal-title">Delete student</h4>
					</div>
					<form>
						<div class="modal-body">
							<p>Are you sure want to delete this?</p>
							<div class="m-t-20">
								<a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
								<button type="submit" class="btn btn-danger">Delete</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- JavaScript -->
	<script src="assets/js/jquery-3.6.0.min.js"></script>
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<script src="assets/js/jquery.dataTables.min.js"></script>
	<script src="assets/js/dataTables.bootstrap4.min.js"></script>
	<script src="assets/js/select2.min.js"></script>
	<script src="assets/js/moment.min.js"></script>
	<script src="assets/plugins/datetimepicker/js/tempusdominus-bootstrap-4.min.js"></script>
	<script src="assets/js/app.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	
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

	<script src="order/update_order_status.js"></script>

	<div id="order_status" class="modal" role="dialog">
		<div class="modal-dialog modal-dialog-centered-top">
			<div class="modal-content modal-md">
				<div class="modal-header">
					<h4 class="modal-title">Update Order Status</h4>
				</div>
				<form>
					<div class="modal-body">
						<p>Are you sure you want to Update the Order Status <span class="confirmationButtonValue"></span> ?</p>
						<div class="m-t-20">
							<a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
							<button type="submit" class="btn btn-success"><span class="confirmationButtonValue"></span></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>


	<script>
		$(function () {
			$("#example1").DataTable({
				"responsive": true,
				"lengthChange": false,
				"autoWidth": false,
				"buttons": ["pdf", "print", "csv"],
				"order": [[0, "desc"]] 
			}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
		});

	</script>

</body>

</html>
