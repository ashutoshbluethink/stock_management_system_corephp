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

	<link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">

	<link rel="stylesheet" href="assets/css/select2.min.css">

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
							<h5 class="text-uppercase mb-0 mt-0 page-title">All  status</h5>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-12">
							<ul class="breadcrumb float-right p-0 mb-0">
								<li class="breadcrumb-item"><a href="index.html"><i class="fas fa-home"></i> Home</a>
								</li>
								<li class="breadcrumb-item"><a href="#">Accounts</a></li>
								<li class="breadcrumb-item"><span> All status</span></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4 col-12">
					</div>
					<div class="col-sm-8 col-12 text-right add-btn-col">
						<a href="add-account.php" class="btn btn-primary float-right btn-rounded"><i
								class="fas fa-plus"></i> All status</a>
						<div class="view-icons">
							<a href="all-accounts.php" class="grid-view btn btn-link"><i class="fas fa-th"></i></a>
							<a href="accounts-list.php" class="list-view btn btn-link active"><i
									class="fas fa-bars"></i></a>
						</div>
					</div>
				</div>
				<div class="content-page">

					<div class="row">
						<div class="col-lg-12 mb-3">
							<div class="table-responsive">
								<table class="table custom-table datatable">
									<thead class="thead-light">
										<tr>
                                        <th>Status_id</th> 
                                        <th>Action</th>                          
                                        <th class="text-right">Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
										include "backend/db_connection.php";
                                        $sql="SELECT * from order_status";
                                        $result = $conn->query($sql);
                                        if($result) {
                                          $order_status = $result->fetch_all(MYSQLI_ASSOC);
                                        }
                                        
                                        foreach($order_status as $key => $value){
                                        
                                        ?>
                                          <tr>
                                          <td><?php echo $value['status_id'] ?> </td>
                                          <td><?php echo $value['order_status_label'] ?> </td>							
											<td class="text-right">
												<a href="edit_order_status.php?status_id=<?php echo $value['status_id'] ?>" class="btn btn-primary btn-sm mb-1">
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
		<div id="delete_employee" class="modal" role="dialog">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content modal-md">
					<div class="modal-header">
						<h4 class="modal-title">Delete student</h4>
					</div>
					<form>
						<div class="modal-body">
							<p>Are you sure want to delete this?</p>
							<div class="m-t-20"> <a href="" class="btn btn-white" data-dismiss="modal">Close</a>
								<button type="submit" class="btn btn-danger">Delete</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
	<script src="assets/js/jquery-3.6.0.min.js"></script>

	<script src="assets/js/bootstrap.bundle.min.js"></script>

	<!-- <script src="assets/js/jquery.slimscroll.js"></script> -->
	<script src="assets/js/jquery.dataTables.min.js"></script>
	<script src="assets/js/dataTables.bootstrap4.min.js"></script>

	<script src="assets/js/select2.min.js"></script>
	<script src="assets/js/moment.min.js"></script>

	<script src="assets/plugins/datetimepicker/js/tempusdominus-bootstrap-4.min.js"></script>

	<script src="assets/js/app.js"></script>
</body>

</html>


