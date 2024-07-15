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
											<th>
												<!-- <input type="checkbox" id="checkAll"> -->
												<select id="actionButton" style="display: none;" class="form-control selectl" name="actionButton">
													<option value="">Action</option>
													<?php
														include "backend/db_connection.php";
														$sqlProduct = "SELECT * FROM order_status";
														$result = mysqli_query($conn, $sqlProduct);
														foreach ($result as $key => $data) {
													?>
													<option value="<?php echo $data['status_id'] ?>"><?php echo $data['order_status_label'] ?></option>
												<?php } ?>
												</select>
											</th>
											<th>OrderID</th>
											<th>Acccount</th>
											<th>Payment</th>
											<th>Product</th>
											<th>Purcehs price</th>
											<th>Created At</th>
											<th>Updated At</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$query = "SELECT 
										orders.*, 
										orders.created_at AS order_created_at, 
										orders.updated_at AS order_updated_at,
										accounts.*, 
										payments.*, 
										products.*, 
										order_status.*
										FROM orders 
										LEFT JOIN accounts ON orders.account_id = accounts.account_id 
										LEFT JOIN payments ON orders.card_id = payments.card_id 
										LEFT JOIN products ON orders.product_id = products.product_id 
										LEFT JOIN order_status ON orders.order_status = order_status.status_id
										WHERE orders.order_status=1 ORDER BY orders.orderId DESC";

										$results = mysqli_query($conn, $query);										
										while ($result = mysqli_fetch_assoc($results)) {
										
										?>
											<tr>
												<td><input type="checkbox" class="orderCheckbox"></td>
												<td>
													<h2>
														<?php
														$store_id=$result['account_group'];
														 $query_store = "SELECT * FROM store where store_id = $store_id";
																$result_store  = mysqli_query($conn, $query_store );
																$store_data = mysqli_fetch_assoc($result_store );
															?>
														<a href="order-profile.php?orderid=<?php echo $result['orderId']; ?>"> 
														<img id="imagePreview" src="assets/img/store_logo/<?php echo $store_data['store_img'] ?>" alt="imagePreview" width="40" height="30">
														<!-- -------------------------------- -->
														<?php
															$text = $result['order_no']; // Assuming $result['order_no'] contains your text

															$line = '';
															$lineCount = 0;

															for ($i = 0; $i < strlen($text); $i++) {
																$char = $text[$i];
																$line .= $char;
																$lineCount++;

																if ($lineCount >= 20) {
																	echo $line . "<br>"; // Output the line with a line break
																	$line = '';
																	$lineCount = 0;
																}
															}

															if (!empty($line)) {
																echo $line; // Output any remaining characters
															}
															?>

														<!-- -------------------------------- -->
														  <!-- order_detail.php new page for order detail  -->
														 </a>
													</h2>
												</td>
												<td><?php echo 
												$result['mobile_number'] . "<br>" .
												$result['account_holder_name']; 
												?></td>
												<?php
												$card_number=$result['card_provider_bank'];
												if(isset($card_number)) {
													$querybank = "SELECT * FROM bank_name where bank_id = $card_number";
													$resultbank = mysqli_query($conn, $querybank);
													$bank_data = mysqli_fetch_assoc($resultbank);
												
												}
												?>
												<td>
												<img id="imagePreview" src="assets/img/bank_logo/<?php echo $bank_data['bank_img'] ?>" alt="imagePreview" width="40px" height="40px">
												<?php 
													echo $result['card_number'] . " || " . substr($result['card_holder_name'], 0, 15);
													echo"<br>";
													echo $result['card_type']. " || " . $result['account_type'];
												 ?>
												
												 </td>

												<?php
												$brandid=$result['brand'];
												if(isset($brandid)) {
												$querybrand = "SELECT * FROM product_brand_name where brand_id = $brandid ";
												$resultbrand = mysqli_query($conn, $querybrand);
												$brand_data = mysqli_fetch_assoc($resultbrand);
												}
												?>

												<td> <img id="imagePreview" src="assets/img/brand_logo/<?php echo $brand_data['brand_img'] ?>" alt="imagePreview" width="40px" height="40px">
													<?php echo
													 $result['model_name']. " -"  . 
													 $result['varient'] . "  " .
													 $result['color'] ;
												 
													 ?></td>
												<td>
													<?php echo '<img src="uploads/product/' . $result['product_image'] . '" alt="Product Logo" width="40px" height="40px">'; ?>
													<?php echo '₹ ' . number_format($result['order_price'], 2) ."<br>"; ?>
													<?php echo 'Regu. Pric. ₹' . number_format($result['price'], 2); ?>

												</td>

												<td><?php echo date('d M Y', strtotime($result['order_created_at'])); ?><br><?php echo date('h:i A', strtotime($result['order_created_at'])); ?>
											    </td>

												<td><?php echo date('d M Y', strtotime($result['order_updated_at'])); ?><br><?php echo date('h:i A', strtotime($result['order_updated_at'])); ?>
											    </td>
												
												<td>
													<img src="assets/img/store_logo/<?php echo $result['order_status_img'] ?>" alt="Logo" width="50" height="50"><br>
													<?php  echo $result['order_status_label'] ?>
												</td>
												
												<td class="text-right">
													<a href="edit-order.php?orderId=<?php echo $result['orderId']; ?>" class="btn btn-primary btn-sm mb-1">
														<i class="far fa-edit"></i>
													</a>
													<button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
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
				"buttons": ["pdf", "print"],
				"order": [[0, "desc"]] 
			}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
		});

	</script>

</body>

</html>
