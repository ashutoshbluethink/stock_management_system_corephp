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
	<link rel="stylesheet" href="dist/css/adminlte.min2167.css?v=3.2.0">
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
							<a href="all-order-grid.php" class="grid-view btn btn-link"><i class="fas fa-th"></i></a>
							<a href="all-order.php" class="list-view btn btn-link active"><i
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

					<div class="row staff-grid-row">

						<?php
							include "backend/db_connection.php";

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
							
							$sqlQuery .= " ORDER BY orders.orderId DESC";
							$results = mysqli_query($conn, $sqlQuery);
							
							$count =1;
						
							$totalRecords = mysqli_num_rows($results);

							// Define the number of records to be displayed per page
							$recordsPerPage = 12;
						
							// Calculate the total number of pages
							$totalPages = ceil($totalRecords / $recordsPerPage);
						
							// Get the current page number
							$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
							$offset = ($currentPage - 1) * $recordsPerPage;
							
						
							// Modify your SQL query to include the LIMIT clause
							$sqlQuery .= " LIMIT $offset, $recordsPerPage";
					
							// Execute the modified query
							$pagedResults = mysqli_query($conn, $sqlQuery);
							
						
						
						
							while ($result = mysqli_fetch_assoc($pagedResults)) {
						?>
						<div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3" >
							<div class="profile-widget">
								<div class="profile-img">
									<a href="profile.html" class="avatar"><?php echo $result['card_provider_bank']; ?></a>
								</div>
								<h2>
								<a href="student-profile.html"><img class="avatar" src="uploads/card/<?php echo $result['image']; ?>" alt=""></a>
								</h2>
								<div class="dropdown profile-action">
									<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
										<i class="fas fa-ellipsis-v"></i>
									</a>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item" href="edit-card.php?card_id=<?php echo $result['card_id']; ?>">
											<i class="fas fa-pencil-alt m-r-5"></i> Edit
										</a>
								
										<a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_employee">
											<i class="fas fa-trash-alt m-r-5"></i> Delete
										</a>
									</div>
								</div>
								<h4 class="user-name m-t-10 m-b-0 text-ellipsis">
									<a href="profile.html">xxxx-xxxx-xxxx-<?php echo $result['card_number']; ?></a>
								</h4>
								<div class="small text-muted"><?php echo $result['card_type'] . " || " . $result['comment'];?></div>
								<div class="medium text-muted"><?php echo $result['card_holder_name'];?></div>

								<a href="backend/status.php?card_id_grid=<?php echo $result['card_id']; ?>">
									<span class="<?php echo ($result['card_status'] == 1) ? 'badge badge-success' : 'badge badge-danger'; ?>">
									<?php echo ($result['card_status'] == 1) ? 'Active' : 'Inactive'; ?>
									</span>
								</a>

							</div>
						</div>
						<?php
						}
						?>
					</div>

					<div>
						<ul class="pagination">
							<?php
								// Create pagination links
								for ($i = 1; $i <= $totalPages; $i++) {
									$activeClass = ($i == $currentPage) ? 'active' : '';
							?>
									<li class="page-item <?php echo $activeClass; ?>">
										<a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
									</li>
							<?php
								}
							?>
						</ul>
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
		<div class="modal-dialog modal-dialog-centered-top">
			<div class="modal-content modal-md">
				<div class="modal-header">
					<h4 class="modal-title">Update Order Status</h4>
				</div>
				<form>
					<div class="modal-body">
						<p>Are you sure you want to Update the Order Status for <span class="selectedOrderCount">0</span> orders with IDs: <span class="selectedOrderIds"></span> ?</p>

						<div id="service_charge_div">
							<label for="service_charge">Service Charge Amount:</label>
							<input id="service_charge" type="text" value="<?php echo $service_charge ?>" name="service_charge">
						</div>

						<label for="changeDate">Change the order entry date:</label>
						<input type="checkbox" id="changeDate" name="changeDate" value="1">
						<div id="datepickerContainer" style="display: none;">
							<label for="selectedDate">Select a date:</label>
							<input type="date" id="selectedDate" value="yy-mm-dd" name="selectedDate" class="datepicker">
						</div>
						<div class="m-t-20">
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
