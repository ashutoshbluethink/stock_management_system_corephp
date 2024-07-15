<?php
session_start();
echo $_SESSION['errorMessage'];
?>
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
							<h5 class="text-uppercase mb-0 mt-0 page-title">Teachers</h5>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-12">
							<ul class="breadcrumb float-right p-0 mb-0">
								<li class="breadcrumb-item"><a href="index.html"><i class="fas fa-home"></i> Home</a>
								</li>
								<li class="breadcrumb-item"><a href="#">Card</a></li>
								<li class="breadcrumb-item"><span> All Card</span></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4 col-12">
					</div>
					<div class="col-sm-8 col-12 text-right add-btn-col">
						<a href="add-card.php" class="btn btn-primary btn-rounded float-right"><i
								class="fas fa-plus"></i> Add Card</a>
						<div class="view-icons">
							<a href="card-list.php" class="grid-view btn btn-link active"><i
									class="fas fa-th"></i></a>
							<a href="all-card.php" class="list-view btn btn-link"><i class="fas fa-bars"></i></a>
						</div>
					</div>
				</div>


				<div class="row staff-grid-row">

					<?php
						include "backend/db_connection.php";

						$query = "SELECT * FROM payments";
						$results = mysqli_query($conn, $query);
						while ($result = mysqli_fetch_assoc($results)) {
						?>
						<div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
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
										<a class="dropdown-item" href="edit-teacher.html">
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

				
			    <?php
					include 'notification.php';
				?>

			</div>
		</div>
		<div id="delete_employee" class="modal" role="dialog">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content modal-md">
					<div class="modal-header">
						<h4 class="modal-title">Delete Employee</h4>
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

	<script src="assets/js/jquery-3.6.0.min.js"></script>

	<script src="assets/js/bootstrap.bundle.min.js"></script>

	<!-- <script src="assets/js/jquery.slimscroll.js"></script> -->

	<script src="assets/js/select2.min.js"></script>
	<script src="assets/js/moment.min.js"></script>

	<script src="assets/js/app.js"></script>
</body>



</html>