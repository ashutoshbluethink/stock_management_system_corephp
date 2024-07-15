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
	<link rel="stylesheet" href="assets/css/custon.css"> 	<!-- Include Custom css -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>
<body>
	<div class="main-wrapper">
		<?php
		include 'header.php'; // Include header file
		include 'sidebar.php'; // Include sidebar file
		include "backend/db_connection.php";

		?>

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
		<div class="page-wrapper">
			<div class="content container-fluid">
				<div class="page-header">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-12">
							<h5 class="text-uppercase mb-0 mt-0 page-title">Order List</h5>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-12">
							<ul class="breadcrumb float-right p-0 mb-0">
								<li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
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
						<div class="view-icons">
							<a href="all-order.php" class="grid-view btn btn-link"><i class="fas fa-th"></i></a>
							<a href="all-order-grid.php" class="list-view btn btn-link active"><i
									class="fas fa-bars"></i></a>
						</div>
					</div>
				</div>
				<div class="content-page">


					<form action="" method="POST" action="">
						<div class="row filter-row">
							<div class="col-sm-6 col-md-3">
								<div class="form-group form-focus select-focus">
									<select id="status_filter" name="status_filter"  class="select form-control">
										<option value="All">All</option>
										<?php
											$sqlProduct = "SELECT * FROM order_status";
											$result = mysqli_query($conn, $sqlProduct);
											foreach ($result as $key => $data) {
												$selected = ($data['status_id'] == $_POST['status_filter']) ? 'selected' : '';
												echo '<option value="' . $data['status_id'] . '" ' . $selected . '>' . $data['order_status_label'] . '</option>';
											}
										?>
									</select>
									<label class="focus-label">Select Order Status</label>
								</div>
							</div>

							<div class="col-sm-6 col-md-3">
								<div class="form-group form-focus select-focus">
									<select id="orderDate" name="orderDate" class="select form-control">
									<option value="All" <?php if (isset($_POST['orderDate']) && $_POST['orderDate'] == 'All') echo 'selected'; ?>>All</option>
									<option value="Today" <?php if (isset($_POST['orderDate']) && $_POST['orderDate'] == 'Today') echo 'selected'; ?>>Today</option>
									<option value="LastWeek" <?php if (isset($_POST['orderDate']) && $_POST['orderDate'] == 'LastWeek') echo 'selected'; ?>>Last Week</option>
									<option value="LastMonth" <?php if (isset($_POST['orderDate']) && $_POST['orderDate'] == 'LastMonth') echo 'selected'; ?>>Last Month</option>
									<option value="LastYear" <?php if (isset($_POST['orderDate']) && $_POST['orderDate'] == 'LastYear') echo 'selected'; ?>>Last Year</option>
									</select>
									<label class="focus-label">Select Order Date</label>
								</div>
							</div>
							<div class="col-sm-6 col-md-2">
								<div class="form-group form-focus">
									<input type="date" name="fromDate" class="form-control" value="<?php echo isset($_POST['fromDate']) ? $_POST['fromDate'] : ''; ?>">
									<label class="focus-label">From Date</label>
								</div>
							</div>


							<div class="col-sm-6 col-md-2">
								<div class="form-group form-focus">
									<input type="date" name="toDate" class="form-control" value="<?php echo isset($_POST['toDate']) ? $_POST['toDate'] : ''; ?>">
									<label class="focus-label">To Date</label>
								</div>
							</div>


							<div class="col-sm-6 col-md-2">
								<button type="submit" name="submit" class="btn btn-search rounded btn-block mb-3">Filter</button>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-lg-12 mb-3">
							<div class="table-responsive">
								<table id="example1" class="table table-bordered table-striped">
									<thead class="thead-dark">
										<tr>
											<th>
												<!-- <input type="checkbox" id="checkAll"> -->
												<select id="actionButton" class="form-control select2" style="display: none;" class="form-control selectl" name="actionButton">
													<option value="">Action</option>
													<?php
														$sqlProduct = "SELECT * FROM order_status";
														$result = mysqli_query($conn, $sqlProduct);
														foreach ($result as $key => $data) {
													?>
													<option value="<?php echo $data['status_id'] ?>"><?php echo $data['order_status_label'] ?></option>
												<?php } ?>
												</select>
											</th>
											<th>Image</th>
											<th>OrderID</th>
											<th>Acccount</th>
											<th>Payment</th>
											<th>Product</th>
											<th>Created At</th>
											<th>Updated At</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<!-- -------------------------- -->
										<?php
										// Define the base SQL query
										$sqlQuery = "SELECT 
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
											LEFT JOIN order_status ON orders.order_status = order_status.status_id";

											// Initialize an array to store the conditions
											$conditions = [];

											// Add condition for order status
											if (isset($_POST['status_filter']) && $_POST['status_filter'] !== 'All') {
												$statusFilter = $_POST['status_filter'];
												$conditions[] = "orders.order_status = $statusFilter";
											}

											if (isset($_POST['orderDate']) && $_POST['orderDate'] !== 'All') {
										
												$orderDateFilter = $_POST['orderDate'];
												if ($orderDateFilter === 'Today') {
													$conditions[] = "DATE(orders.updated_at) = CURDATE()";
												} elseif ($orderDateFilter === 'LastWeek') {
													$conditions[] = "DATE(orders.updated_at) BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE()";
												} elseif ($orderDateFilter === 'LastMonth') {
													$conditions[] = "DATE(orders.updated_at) BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE()";
												} elseif ($orderDateFilter === 'LastYear') {
													$conditions[] = "DATE(orders.updated_at) BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 YEAR) AND CURDATE()";
												}
											}

											if (!empty($_POST['fromDate'])) {
												$fromDate = date('Y-m-d', strtotime($_POST['fromDate']));
												$conditions[] = "DATE(orders.updated_at) >= '$fromDate'";
											}
											
											// Add condition for the To Date
											if (!empty($_POST['toDate'])) {
												$toDate = date('Y-m-d', strtotime($_POST['toDate']));
												$conditions[] = "DATE(orders.updated_at) <= '$toDate'";
											}

											if (!empty($conditions)) {
												$sqlQuery .= " WHERE " . implode(" AND ", $conditions);
											}
											
										$sqlQuery .= " ORDER BY orders.orderId DESC LIMIT 100";
										$results = mysqli_query($conn, $sqlQuery);
										
										$count =1;

										while ($result = mysqli_fetch_assoc($results)) {
										
										?>
											<tr>
												<td>
													<input type="checkbox" class="orderCheckbox">
												</td>

												<?php
													$store_id=$result['account_group'];
													$query_store = "SELECT * FROM store where store_id = $store_id";
													$result_store  = mysqli_query($conn, $query_store );
													$store_data = mysqli_fetch_assoc($result_store );
												?>
												
												<td>
													<div class="order-info">
														<div class="order-image1">
															<a href="order-profile.php?orderid=<?php echo $result['orderId']; ?>" title="<?php echo $brand_data['brand_name'] ?>" data-toggle="tooltip">
																<img alt="Order image" src="uploads/product/<?php echo $result['product_image'] ?>" alt="imagePreview" width="40px" height="40px">
															</a>
														</div>
														<div class="order-details">
															<div class="badge badge-danger">
															<span class="text">
																&#x20B9; <?php echo number_format($result['order_price'], 2, '.', ','); ?>
															</span>
															</div>
															<div class="price">
															<span class="text">
																<s>&#x20B9; <?php echo $result['price']?></s></span>

															</div>
															<div class="comment">
																<?php $result['comment']; ?>
															</div>
														</div>
													</div>
												</td>
												<!-- --------------------------------------- -->
												<td>
													<div style="float: left; margin-right: 10px;">
														<a href="order-profile.php?orderid=<?php echo $result['orderId']; ?>" title="<?php echo $store_data['store_name'] ?>" data-toggle="tooltip">
															<img alt="Order image" src="assets/img/store_logo/<?php echo $store_data['store_img'] ?>" width="35px" height="35px" style="border-radius: 50%;">
														</a>
													</div>

													<div>
														<small>
															<a href="order-profile.php?orderid=<?php echo $result['orderId']; ?>" title="<?php echo $store_data['store_name'] ?>" data-toggle="tooltip" style="color: #333; text-decoration: none;">
																<?php echo "#".$result['order_no'];?>
															</a>
														</small>
														<p>
															<i class="fas fa-map-marker-alt"></i> <?php echo $result['order_location'];?>
														</p>
													</div>
												</td>


												<!-- -------------------------------------- -->

												<td>
													<i class="fas fa-mobile-alt"></i> <?php echo $result['mobile_number']; ?><br>
													<i class="fas fa-user"></i> <?php echo $result['account_holder_name']; ?>
												</td>

												<?php
												$card_number=$result['card_provider_bank'];
												if(isset($card_number)) {
													$querybank = "SELECT * FROM bank_name where bank_id = $card_number";
													$resultbank = mysqli_query($conn, $querybank);
													$bank_data = mysqli_fetch_assoc($resultbank);
												
												}
												?>
												<td>
													<div class="order-info">
														<div class="order-image">
															<img id="imagePreview" src="assets/img/bank_logo/<?php echo $bank_data['bank_img'] ?>" alt="imagePreview" width="40px" height="40px">
														</div>
														<div class="order-details">
																<div class="order-price">
																
																<?php 
																	echo '<p class="fas fa-credit-card">'.' '.$result['card_number'] . ' '. $result['card_type'].'</p> ';
										
																	echo '<h6 style="color:blue">'. $result['account_type'].' '. substr($result['card_holder_name'], 0, 15). '</h6>';
																?>
																
														</div>
													</div>
												 </td>

												<?php
												$brandid=$result['brand'];
												if(isset($brandid)) {
												$querybrand = "SELECT * FROM product_brand_name where brand_id = $brandid ";
												$resultbrand = mysqli_query($conn, $querybrand);
												$brand_data = mysqli_fetch_assoc($resultbrand);
												}
												?>

												<td class="product-info">
												<div class="order-image">
														<!-- <img id="imagePreview" src="assets/img/brand_logo/<?php echo $brand_data['brand_img'] ?>" alt="Brand Logo" width="40px" height="40px"> -->
													</div>
													<div class="product-details">
														<p class="model-name"><?php echo $result['model_name']; ?></p>
														<h5 class="varient-color">
															<?php echo $result['varient'] ?> <spain style="background-color: <?php echo $result['color']; ?>;"> <?php echo $result['color']; ?>  </spain>
														</h5>
													
													</div>
												</td>
												
												<td><?php echo date('d M Y', strtotime($result['order_created_at'])); ?><br><?php echo date('h:i A', strtotime($result['order_created_at'])); ?>
												</td>
												<td><?php echo date('d M Y', strtotime($result['order_updated_at'])); ?><br><?php echo date('h:i A', strtotime($result['order_updated_at'])); ?>
											    </td>
												<td>
													<img src="assets/img/store_logo/<?php echo $result['order_status_img'] ?>" alt="Logo" width="40" height="40"><br>
													<?php  echo $result['order_status_label'] ?>
												</td>
												
												<td class="text-right">
													<a href="edit-order.php?orderId=<?php echo $result['orderId']; ?>" class="btn btn-primary btn-sm mb-1">
														<i class="far fa-edit"></i>
													</a>
													<button class="btn btn-danger btn-sm mb-1 delete-order-button" data-toggle="modal" data-target="#deleteOrderModal" onclick="setOrderToDelete(<?php echo $result['orderId']; ?>)">
														<i class="far fa-trash-alt"></i> 
													</button>


												</td>
											</tr>
										<?php
										$count= $count+1;
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
		<div id="deleteOrderModal" class="modal" role="dialog">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content modal-md">
					<div class="modal-header">
						<h4 class="modal-title">Delete Order</h4>
					</div>
					<form>
						<div class="modal-body">
							<p>Are you sure you want to delete this order (Order ID: <span id="orderToDeleteText"></span>)?</p>
							<div class="m-t-20">
								<a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
								<button type="button" id="confirmDeleteButton" class="btn btn-danger" onclick="deleteOrder()">Delete</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>


	</div>
	<script>
	var orderToDelete; // Declare a global variable

	function setOrderToDelete(orderId) {
		orderToDelete = orderId; 
		$('#orderToDeleteText').text(orderToDelete);
	}
	function deleteOrder() {
		if (orderToDelete) {
			
			console.log("Deleting order ID: " + orderToDelete);

			$('#deleteOrderModal').modal('hide');
		}
	}

	</script>



	<!-- JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<script src="assets/js/jquery-3.6.0.min.js"></script>
	<!-- <script src="assets/js/bootstrap.bundle.min.js"></script> -->
	<!-- <script src="assets/js/jquery.dataTables.min.js"></script> -->
	<!-- <script src="assets/js/dataTables.bootstrap4.min.js"></script> -->
	<script src="assets/js/select2.min.js"></script>
	<script src="assets/js/moment.min.js"></script>
	<script src="assets/plugins/datetimepicker/js/tempusdominus-bootstrap-4.min.js"></script>
	<script src="assets/js/app.js"></script>
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
	
	<!-- <script src="plugins/jquery/jquery.min.js"></script> -->
	<!-- <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->

	
	<!-- <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script> -->
	<!-- <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script> -->
	
	<script src="plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="plugins/jszip/jszip.min.js"></script>
	<script src="plugins/pdfmake/pdfmake.min.js"></script>
	<script src="plugins/pdfmake/vfs_fonts.js"></script>
	<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>

	<!-- <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script> -->


	

	<script src="order/update_order_status.js"></script>
<?php
// ===========================================
$service_charge = 00 ;
$queryservice_charge = "SELECT * FROM service_charge";

$resultsservice_charge = mysqli_query($conn, $queryservice_charge);										
while ($result = mysqli_fetch_assoc($resultsservice_charge)) {

   $service_charge = $result['service_charge_amount']; 
}

// ===========================================
?>

	<div id="order_status" class="modal" role="dialog">
		<!-- submit pop data order/update_order_status.js -->
		<div class="modal-dialog modal-dialog-centered-top">
			<div class="modal-content modal-md">
				<div class="modal-header">
					<h4 class="modal-title">Update Order Status</h4>
				</div>
				<form>
					<div class="modal-body">
						<p>Are you sure you want to Update the Order Status for <span class="selectedOrderCount">0</span> orders with IDs: <span class="selectedOrderIds"></span> ?</p>

						<div class="form-group" id="service_charge_div">
							<label for="service_charge">Service Charge Amount:</label>
							<input id="service_charge" type="text" value="<?php echo $service_charge ?>" name="service_charge" class="form-control">
						</div>


						<div id="vendor_id_div">
							<label for="vendor_select">Select Vendor</label>
							<select id="vendor_select" name="vendor_id" class="form-control">
								<?php
								// SQL query to fetch vendor names
								$sql = "SELECT vendor_id, vendor_name FROM vendor";
								$result = mysqli_query($conn, $sql);

								// Check if query was successful
								if ($result && mysqli_num_rows($result) > 0) {
									// Loop through each row in the result set
									while ($row = mysqli_fetch_assoc($result)) {
										$vendor_id = $row['vendor_id'];
										$vendor_name = $row['vendor_name'];
										// Create an <option> element for each vendor
										echo "<option value='$vendor_id'>$vendor_name</option>";
									}
								} else {
									// If no vendors found
									echo "<option value='' disabled>No vendors found</option>";
								}
								?>
							</select>
						</div>


						<div class="form-group">
							<div class="form-check">
								<input type="checkbox" class="form-check-input" id="changeDate" name="changeDate" value="1">
								<label class="form-check-label" for="changeDate">Change Delevery Date</label>
							</div>
						</div>
						<div id="datepickerContainer" class="form-group" style="display: none;">
							<label for="selectedDate">Select a date:</label>
							<input type="date" id="selectedDate" value="yy-mm-dd" name="selectedDate" class="form-control datepicker">
						</div>
						<div class="form-group mt-3">
							<a href="all-order.php" class="btn btn-danger" data-dismiss="modal">Close</a>
							<button type="submit" class="btn btn-success"><span class="confirmationButtonValue"></span></button>
						</div>

						<script>
							$(document).ready(function () {
								$('#changeDate').change(function () {
									if ($(this).is(':checked')) {
										$('#datepickerContainer').show();
									} else {
										$('#datepickerContainer').hide();
									}
								});

								$('.datepicker').datepicker({
									dateFormat: 'yy-mm-dd' 
								});
							});
						</script>

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
				"buttons": ["pdf", "print", "excel"],
				"order": [[0, "desc"]],
				"pageLength": 10 
			}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
		});
	</script>

</body>

</html>
