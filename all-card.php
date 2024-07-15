<?php
session_start();
echo $_SESSION['errorMessage'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Payment list</title>
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

				<!-- ####################################################################################################### -->
                <script src="assets/js/jquery-3.6.0.min.js"></script>
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
				<div class="row">
					<div class="col-sm-4 col-12">
					</div>
					<div class="col-sm-8 col-12 text-right add-btn-col">
						<a href="add-card.php" class="btn btn-primary float-right btn-rounded"><i
								class="fas fa-plus"></i> Add Card</a>
						<div class="view-icons">
							<a href="card-list.php" class="grid-view btn btn-link"><i class="fas fa-th"></i></a>
							<a href="all-card.php" class="list-view btn btn-link active"><i
									class="fas fa-bars"></i></a>
						</div>
					</div>
				</div>
				<div class="content-page">
					<form action="" method="POST">
						<div class="row filter-row">
							<div class="col-sm-6 col-md-3">
								<div class="form-group form-focus select-focus">
									<select name="payment-mode-filter" class="select form-control">
										<option value="">--All--</option>
										<option value="Credit" <?php if ($_POST['payment-mode-filter'] === 'Credit') echo 'selected'; ?>>Credit</option>
										<option value="Debit" <?php if ($_POST['payment-mode-filter'] === 'Debit') echo 'selected'; ?>>Debit</option>
										<option value="Account" <?php if ($_POST['payment-mode-filter'] === 'Account') echo 'selected'; ?>>Account</option>
										<option value="cod" <?php if ($_POST['payment-mode-filter'] === 'cod') echo 'selected'; ?>>COD</option>
									</select>
									<label class="focus-label">Payment Mode</label>
								</div>
							</div>

							<div class="col-sm-6 col-md-3">
								<div class="form-group form-focus select-focus">
									<select name="bank-name-filter" class="select form-control">
										<option value="">--All--</option>
										<?php
										$querysql = "SELECT * FROM bank_name where bank_status=1";
										$resultssql = mysqli_query($conn, $querysql);
										while ($resultsql = mysqli_fetch_assoc($resultssql)) {
											echo "<option value='" . $resultsql['bank_id'] . "' " . ($_POST['bank-name-filter'] === $resultsql['bank_id'] ? 'selected' : '') . ">" . $resultsql['bank_name'] . "</option>";
										}
										?>
									</select>
									<label class="focus-label">Bank Name</label>
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
								<button type="submit" class="btn btn-search rounded btn-block mb-3">Search</button>
							</div>
						</div>
					</form>

					<div class="row">
						<div class="col-md-12 mb-3">
							<div class="table-responsive">
							<table id="example1" class="table table-bordered table-striped">
									<thead class="thead-light">
										<tr>
											<th style="min-width:50px;">Id</th>
											<th style="min-width:50px;">Name</th>
											<th style="min-width:70px;">Card Type</th>
											<th style="min-width:50px;">Card Number</th>
											<th style="min-width:50px;">Card Provider Bank</th>											
											<th style="min-width:80px;">Status</th>
											<th style="min-width:80px;">created_at</th>
											<th class="text-right" style="width:15%;">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$query = "SELECT * FROM payments JOIN bank_name ON payments.card_provider_bank = bank_name.bank_id";

											if (isset($_POST['payment-mode-filter']) && !empty($_POST['payment-mode-filter'])) {
												$paymentModeFilter = $_POST['payment-mode-filter'];
												$query .= " WHERE payments.card_type = '$paymentModeFilter'";
											}

											if (isset($_POST['bank-name-filter']) && !empty($_POST['bank-name-filter'])) {
												 
												$bankNameFilter = $_POST['bank-name-filter'];
												if (strpos($query, 'WHERE') === false) {
													$query .= " WHERE payments.card_provider_bank = '$bankNameFilter'";
												} else {
													$query .= " AND payments.card_provider_bank = '$bankNameFilter'";
												}
											}
											if (isset($_POST['status-filter']) && !empty($_POST['status-filter'])) {
												$statusFilter = $_POST['status-filter'];
									
												if (strpos($query, 'WHERE') === false) {
													 $query .= " WHERE payments.card_status = '$statusFilter'";
												} else {
													$query .= " AND payments.card_status = '$statusFilter'";
												}
											}

											 $query .= " ORDER BY card_id DESC";

											$results = mysqli_query($conn, $query);
											while ($result = mysqli_fetch_assoc($results)) {
											
										?>

										<tr>
											<td>
												<h2>
													<a href="profile.html" class="avatar text-white"><?php echo $result['card_id'];?></a>
												</h2>
											</td>
											<td>
												
													<?php echo $result['card_holder_name'];?>
												
											</td>
											<td><?php echo $result['card_type'];?></td>
											<td><?php echo $result['card_number'];?></td>
											<td> <?php echo '<img src="assets/img/bank_logo/' . $result['bank_img'] . '" alt="Flipkart Logo" width="40" height="27">' ?> <?php echo $result['bank_name'];?></td>
											<td>
												<a href="backend/status.php?card_id_list=<?php echo $result['card_id']; ?>">
													<span class="<?php echo ($result['card_status'] == 1) ? 'badge badge-success' : 'badge badge-danger'; ?>">
													<?php echo ($result['card_status'] == 1) ? 'Active' : 'Inactive'; ?>
													</span>
												</a>
											</td>

											<td><?php echo $result['created_at'];?></td>
									
										
											<td class="text-right">
												<a href="edit-card.php?card_id=<?php echo $result['card_id']; ?>" class="btn btn-primary btn-sm mb-1">
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