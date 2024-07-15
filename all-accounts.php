<!DOCTYPE html>
<html lang="en">


<head>
	<meta charset="utf-8">
	<title>All Account</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

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
							<h5 class="text-uppercase mb-0 mt-0 page-title">Accounts List</h5>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-12">
							<ul class="breadcrumb float-right p-0 mb-0">
								<li class="breadcrumb-item"><a href="index.html"><i class="fas fa-home"></i> Home</a>
								</li>
								<li class="breadcrumb-item"><a href="#">Accounts</a></li>
								<li class="breadcrumb-item"><span> Accounts List</span></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4 col-12">
					</div>
					<div class="col-sm-8 col-12 text-right add-btn-col">
						<a href="add-accounts.php" class="btn btn-primary float-right btn-rounded"><i
								class="fas fa-plus"></i> Add Account</a>
						<div class="view-icons">
							<a href="all-accounts.php" class="list-view btn btn-link active"><i class="fas fa-th"></i></a>
							<a href="accounts-list.php" class="grid-view btn btn-link"><i
									class="fas fa-bars"></i></a>
						</div>
					</div>
				</div>
				<div class="content-page">
				
					<div class="row">
						<div class="col-lg-12 mb-3">
							<div class="table-responsive">
							<table id="example1" class="table table-bordered table-striped">
									<thead class="thead-light">
										<tr>
											
										    <th>Account ID</th>
											<th>Store</th>
										
											<th>Mobile</th>
											<th>Email</th>
											<th>Name</th>
											<th>Status</th>
											<th class="text-right">Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
										include "backend/db_connection.php";
										$query = "SELECT *FROM accounts JOIN store ON accounts.account_group = store.store_id order by account_id DESC";
										$results = mysqli_query($conn, $query);
										while ($result = mysqli_fetch_assoc($results)) {
									?>
										<tr>
											<td>
												<h2>
													<a href="account-profile.php">
														<img class="avatar" src="uploads/<?php echo isset($result['image']) ? $result['image'] : 'user.jpg'; ?>" alt="">
													</a>
												</h2>
											</td>
										
											<td>
												<?php echo '<img src="assets/img/store_logo/' . $result['store_img'] . '" alt="Flipkart Logo" width="40" height="27">' . '  ' . $result['store_name'] ?>
											</td>
											
										
											<td><?php echo $result['mobile_number'] . ' ' . $result['account_type']; ?>
											<td><?php echo $result['email']; ?></td>
											<td><?php echo $result['account_holder_name']; ?></td>

											<td>
												<a href="backend/account_status.php?account_id=<?php echo $result['account_id']; ?>">
													<span class="<?php echo ($result['account_status'] == 1) ? 'badge badge-success' : 'badge badge-danger'; ?>">
													<?php echo ($result['account_status'] == 1) ? 'Active' : 'Inactive'; ?>
													</span>
												</a>
											</td>
																								
											<td class="text-right">
												<a href="edit_account.php?account_id=<?php echo $result['account_id']; ?>" class="btn btn-primary btn-sm mb-1">
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
	
	<script src="plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="plugins/pdfmake/pdfmake.min.js"></script>
	<script src="plugins/pdfmake/vfs_fonts.js"></script>
	<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>

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
				"order": [[0, "desc"]] 
			}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
		});

	</script>

	
</body>

</html>


