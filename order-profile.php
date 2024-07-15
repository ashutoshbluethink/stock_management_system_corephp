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
	<title>Preschool - Bootstrap Admin Template</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">

	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">

	<link rel="stylesheet" href="assets/css/style.css">

	

</head>

<body>

	<div class="main-wrapper">

		<?php

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);

		include 'header.php';
		include 'sidebar.php';
		$orderId = $_GET['orderid'];

		 if(isset($orderId)){ 
		include "backend/db_connection.php";
		
		$query = "SELECT *
			FROM orders
			INNER JOIN accounts ON orders.account_id = accounts.account_id
			INNER JOIN payments ON orders.card_id = payments.card_id
			INNER JOIN products ON orders.product_id = products.product_id
			WHERE orders.orderId = $orderId";
		
		$results = mysqli_query($conn, $query);
		if ($results) {
			$result = mysqli_fetch_assoc($results);
		}	
	}
		?>

		<div class="page-wrapper">
		    <div class="content container-fluid">
				<div class="page-header">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-12">
							<h5 class="text-uppercase mb-0 mt-0 page-title">Order Details</h5>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-12">
							<ul class="breadcrumb float-right p-0 mb-0">
								<li class="breadcrumb-item"><a href="index.html"><i class="fas fa-home"></i> Home</a>
								</li>
								<li class="breadcrumb-item"><a href="#">Orders</a></li>
								<li class="breadcrumb-item"><span>Order Details</span></li>
							</ul>
						</div>
						<!-- Add more sections here if needed -->
					</div>
				</div>
				<?php if(isset($orderId)){ ?>
				<div class="card-box single-order-view">
					<!-- Account Section -->
					<h4>Account Information</h4>
					<div class="row">
						<div class="col-md-4">
							<div class="profile-img-wrap">
								<div class="profile-img">
									<a href="#"><img class="avatar" src="uploads/<?php echo $result['image']; ?>"
											alt=""></a>
								</div>
							</div>
						</div>
						<div class="col-md-8">
						<?php
						$store_id=$result['account_group'];
							$store_id=$result['account_group'];
								$query_store = "SELECT * FROM store where store_id = $store_id";
									$result_store  = mysqli_query($conn, $query_store );
									$store_data = mysqli_fetch_assoc($result_store );
								?>
							<ul class="personal-info">
								<li>
									<span class="title">Order Id:</span>
									<h5 class="badge badge-success"> <?php echo $result['order_no']; ?> </h5>
								</li>

								<li>
									<span class="title">Account Group:</span>
									<span class="text"><img id="imagePreview" src="assets/img/store_logo/<?php echo $store_data['store_img'] ?>" alt="imagePreview" width="40" height="30"><?php echo $store_data['store_name']; ?></span>
								</li>
								<li>
									<span class="title">Account Type:</span>
									<span class="text"><?php echo $result['account_type']; ?></span>
								</li>
								<li>
									<span class="title">Mobile:</span>
									<span class="text"><?php echo $result['mobile_number']; ?></span>
								</li>
								<li>
									<span class="title">Email:</span>
									<span class="text"><?php echo $result['email']; ?></span>
								</li>
								<li>
									<span class="title">Name:</span>
									<span class="text"><?php echo $result['account_holder_name']; ?></span>
								</li>
							
								<li>
									<span class="title">Comment:</span><br>
									<span class="text"><?php echo $result['order_create_comment']; ?></span>
								</li>
							</ul>
						</div>
					</div>

					<hr>
					<?php
						$card_number=$result['card_provider_bank'];
						if(isset($card_number)) {
							$querybank = "SELECT * FROM bank_name where bank_id = $card_number";
							$resultbank = mysqli_query($conn, $querybank);
							$bank_data = mysqli_fetch_assoc($resultbank);
						
						}
					?>
					<!-- Payment Section -->
					<h4>Payment Information</h4>
					<div class="row">
						<div class="col-md-4">
							<div class="profile-img-wrap">
								<div class="profile-img">
									<a href="#"><img class="avatar text-white"
											src="assets/img/bank_logo/<?php echo $bank_data['bank_img'] ?>" alt=""></a>
								</div>
							</div>
						</div>
						<div class="col-md-8">
							<ul class="personal-info">
							

								<li>
									<span class="title">Name:</span>
									<span class="text"><?php echo $result['card_holder_name']; ?></span>
								</li>
								<li>
									<span class="title">Card Type:</span>
									<span class="text"><?php echo $result['card_type']; ?></span>
								</li>
								<li>
									<span class="title">Card Number:</span>
									<span class="text">xxxx-xxxx-xxxx-<?php echo $result['card_number']; ?></span>
								</li>
								<li>
									<span class="title">Card Provider Bank:</span>
									<span class="text"> <img id="imagePreview" src="assets/img/bank_logo/<?php echo $bank_data['bank_img'] ?>" alt="imagePreview" width="40px" height="40px"> <?php echo $bank_data['bank_name']; ?></span>
								</li>
							
								<li>
									<span class="title">Comment Payment:</span>
									<span class="text"><?php echo $result['comment']; ?></span><br>
								</li>
						
						
							</ul>
						</div>
					</div>

					<hr>

					<!-- Product Section -->
					<h4>Product Information</h4>
					<div class="row">
						<div class="col-md-4">
							<div class="profile-img-wrap">
								<div class="profile-img">
									<a href="#"><img class="avatar"
											src="uploads/product/<?php echo $result['product_image']; ?>" alt=""></a>
								</div>
							</div>
						</div>
						<div class="col-md-8">
							<ul class="personal-info">

								<?php
									$brandid=$result['brand'];
									if(isset($brandid)) {
									$querybrand = "SELECT * FROM product_brand_name where brand_id = $brandid ";
									$resultbrand = mysqli_query($conn, $querybrand);
									$brand_data = mysqli_fetch_assoc($resultbrand);
									}
								?>
								
								<li>
									<span class="title">Model Name:</span>
									<span class="text"><?php echo $brand_data['brand_name'] . "-" . $result['model_name']; ?> 
										<img class="avatar" src="uploads/product/<?php echo $result['product_image']; ?>" alt="">
									</span>
								</li>
								<li>
									<span class="title">Purches Price:</span>
									<h3 class="badge badge-danger">
										&#x20B9; <?php echo number_format($result['order_price'], 2, '.', ','); ?>
									</h3>

								</li>
								<li>
									<span class="title">Regular Price:</span>
									<span class="text"><s>&#x20B9; <?php echo number_format($result['price'], 2, '.', ','); ?></s></span>
								</li>


								<li>
									<span class="title">Color/Varient:</span>
									<h5 class="varient-color">
										<?php echo $result['varient'] ?> <spain style="background-color: <?php echo $result['color']; ?>;"> <?php echo $result['color']; ?>  </spain>
									</h5>
								</li>
								<li>
									<span class="title">Created At:</span>
									<span class="text"><?php echo $result['created_at']; ?></span>
								</li>
							</ul>
						</div>
					</div>
				</div>
<?php } ?>
			</div>
			<?php
		    	include 'notification.php';
		    ?>
		</div>
	</div>

	<script src="assets/js/jquery-3.6.0.min.js"></script>

	<script src="assets/js/bootstrap.bundle.min.js"></script>

	<!-- <script src="assets/js/jquery.slimscroll.js"></script> -->

	<script src="assets/js/app.js"></script>
</body>


</html>