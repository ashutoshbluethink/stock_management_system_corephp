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
	<title>mksp</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">

	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">

	<link rel="stylesheet" href="assets/css/fullcalendar.min.css">

	<link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">

	<link rel="stylesheet" href="assets/plugins/morris/morris.css">

	<link rel="stylesheet" href="assets/css/style.css">
	<style>
		/* Add a CSS animation to the counting class */
		.counting {
			animation: count-up 2s ease-in-out;
		}

		/* Define the animation keyframes */
		@keyframes count-up {
			0% {
				opacity: 0;
				transform: translateY(20px);
			}
			100% {
				opacity: 1;
				transform: translateY(0);
			}
		}

	</style>

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
					<div class="row" >
						<div class="col-md-6">
							<h3 class="page-title mb-0" style="text-align: center;">Dashboard</h3>
						</div>
						<div class="col-md-6">
							<ul class="breadcrumb mb-0 p-0 float-right">
								<li class="breadcrumb-item"><a href="index.php"><i class="fas fa-home"></i> Home</a>
								</li>
								<li class="breadcrumb-item"><span>Dashboard</span></li>
							</ul>
						</div>
					</div>
				</div>
				<?php
				$sqlOrder = "SELECT COUNT(*) AS order_count FROM orders";
				$resultOrder = mysqli_query($conn, $sqlOrder);
				?>

				<!-- -------------------------------------------------------- -->
				<div class="row">
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<a href="all-order.php" title="All Orders">
							<div class="dash-widget dash-widget5" style="background-color: #f0f0f0;">
								<span class="float-left"><img src="assets/img/dash/dash-1.png" alt="" width="80"></span>
								<div class="dash-widget-info text-right">
									<span>Total Orders</span>
									<?php
									$ordersCount = $resultOrder ? mysqli_fetch_assoc($resultOrder)['order_count'] : "N/A";
									?>
									<h3 class="counting"><?php echo $ordersCount ?></h3>
								</div>
							</div>
						</a>
					</div>
						<?php
							$sqlAccounts = "SELECT COUNT(*) AS account_count FROM accounts";
							$resultAccounts = mysqli_query($conn, $sqlAccounts);
						?>
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="dash-widget dash-widget5" style="background-color: #e6f7ff;">
							<div class="dash-widget-info text-left d-inline-block">
								<span>Total Members</span>
								<?php
									$accountCount = $resultAccounts ? mysqli_fetch_assoc($resultAccounts)['account_count'] : "N/A";
									?>
 								<h3 class="counting"><?php echo $accountCount ?></h3>
							</div>
							<span class="float-right"><img src="assets/img/dash/dash-2.png" width="80" alt=""></span>
						</div>
					</div>

					<?php
					$sqlPayments = "SELECT COUNT(*) AS payment_count FROM payments"; // Assuming your table is named "payments"
					$resultPayments = mysqli_query($conn, $sqlPayments);
					?>
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="dash-widget dash-widget5" style="background-color: #e6ffe6;">
							<span class="float-left"><img src="assets/img/dash/dash-3.png" alt="" width="80"></span>
							<div class="dash-widget-info text-right">
								<span>Total Cards</span>
								<?php
								$paymentCount = $resultPayments ? mysqli_fetch_assoc($resultPayments)['payment_count'] : "N/A";
								?>
 								<h3 class="counting"><?php echo $paymentCount ?></h3>
							</div>
						</div>
					</div>

					<?php
					$sqlProducts = "SELECT COUNT(*) AS product_count FROM products"; // Assuming your table is named "products"
					$resultProducts = mysqli_query($conn, $sqlProducts);
					?>
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="dash-widget dash-widget5" style="background-color: #ffffcc;">
							<div class="dash-widget-info d-inline-block text-left">
								<span>Total Products</span>
								<?php
								$productCount = $resultProducts ? mysqli_fetch_assoc($resultProducts)['product_count'] : "N/A";
								?>
 								<h3 class="counting"><?php echo $productCount ?></h3>						
							</div>
							<span class="float-right"><img src="assets/img/dash/dash-4.png" alt="" width="80"></span>
						</div>
					</div>
				</div>	
				<!-- --------------------------------------------------------------------------- -->
				<!-- HTML -->
			

			


				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-header">
								<div class="row align-items-center">
									<div class="col-sm-6">
										<div class="page-title">
											Pending Order List
										</div>
									</div>
									<div class="col-sm-6 text-sm-right">
										<div class=" mt-sm-0 mt-2">
											<button class="btn btn-outline-primary mr-2"><img src="assets/img/excel.png"
													alt=""><span class="ml-2">Excel</span></button>
											<button class="btn btn-outline-danger mr-2"><img src="assets/img/pdf.png"
													alt="" height="18"><span class="ml-2">PDF</span></button>
											<button class="btn btn-light" type="button" data-toggle="dropdown"
												aria-haspopup="true" aria-expanded="false"><i
													class="fas fa-ellipsis-h"></i></button>
											<div class="dropdown-menu dropdown-menu-right">
												<a class="dropdown-item" href="#">Action</a>
												<div role="separator" class="dropdown-divider"></div>
												<a class="dropdown-item" href="#">Another action</a>
												<div role="separator" class="dropdown-divider"></div>
												<a class="dropdown-item" href="#">Something else here</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<?php
										$sqlCountProcessing = "SELECT COUNT(*) as total FROM orders WHERE order_status = 1";
										$countResultProcessing = mysqli_query($conn, $sqlCountProcessing);
										$totalCountProcessing = mysqli_fetch_assoc($countResultProcessing)['total'];
									?>
									<div class="mb-3">
										<h4>Total Processing order: <?php echo $totalCountProcessing; ?></h4>
									</div>
									<table class="table custom-table">
										<thead class="thead-light">
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
											
												<th>Product </th>
												<th>Order ID</th>
												<th>Account Details</th>
												<th>Product</th>
												<th>Payment Details</th>
												<th>Share</th>
												<th>Created At</th>
												<th>Updated At</th>
											    <th>Status</th>
												<th class="text-right">Action</th>
											</tr>
										</thead>
										<tbody>
										<?php
										$sqlQuery = "SELECT 
											orders.*, 
											orders.created_at AS order_created_at, 
											orders.updated_at AS order_updated_at,
											accounts.*, 
											payments.*, 
											products.*, 
											order_status.*,
											accounts.image AS account_image
											FROM orders 
											LEFT JOIN accounts ON orders.account_id = accounts.account_id 
											LEFT JOIN payments ON orders.card_id = payments.card_id 
											LEFT JOIN products ON orders.product_id = products.product_id 
											LEFT JOIN order_status ON orders.order_status = order_status.status_id 
											WHERE orders.order_status = 1 
											ORDER BY orders.orderId DESC";

											$results = mysqli_query($conn, $sqlQuery);

											$count =1;

											while ($result = mysqli_fetch_assoc($results)) {
												
												$store_id=$result['account_group'];
												$query_store = "SELECT * FROM store where store_id = $store_id";
												$result_store  = mysqli_query($conn, $query_store );
												$store_data = mysqli_fetch_assoc($result_store );
													
											?>
											<tr>
										
											    <td><input type="checkbox" class="orderCheckbox"></td>
												<td>
													<div class="order-info">
														<div class="order-image">
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
														</div>
													</div>
												</td>


												<td>
													<small><a href="order-profile.php?orderid=<?php echo $result['orderId']; ?>" title="<?php echo $store_data['store_name'] ?>" data-toggle="tooltip" style="color: #333; text-decoration: none;">
																<?php echo "#".$result['order_no'];?>
													</a> </small>
													<p>
														<i class="fas fa-map-marker-alt"></i> <?php echo $result['order_location'];?>
													</p>
												</td>
												<td>
													<img class="avatar" src="uploads/<?php echo isset($result['account_image']) ? $result['account_image'] : 'user.jpg'; ?>" alt="">
													<?php echo 
													$result['mobile_number'] . "<br>" .
													$result['account_holder_name']; 
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

												<td class="product-info">
													<div class="product-details">
														<h5 class="model-name"><?php echo $result['model_name']; ?></h5>
														<h5 class="varient-color">
															<?php echo $result['varient'] ?> <spain style="background-color: <?php echo $result['color']; ?>;"> <?php echo $result['color']; ?>  </spain>
														</h5>
													
													</div>
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
													<?php 
														echo '<p class="fas fa-credit-card">'.' '.$result['card_number'] . ' '. $result['card_type'].'</p> ';
							
														echo '<h6 style="color:red">'. $bank_data['bank_name'].' '. substr($result['card_holder_name'], 0, 15). '</h6>';
													?>
												</td>

												<td>
													<button class="btn btn-sm btn-info share-btn" data-orderid="<?php echo $result['orderId']; ?>" data-modelname="<?php echo $result['model_name']; ?>" data-orderprice="<?php echo $result['order_price']; ?>" data-variant="<?php echo $result['varient']; ?>" data-mobilenumber="<?php echo $result['mobile_number']; ?>" data-accountholder="<?php echo $result['account_holder_name']; ?>" data-storename="<?php echo $store_data['store_name']; ?>">
														<i class="fas fa-share"></i> 
													</button>
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
											<?php } ?>
										</tbody>
									</table>
									<!-- ==================== Order Update ======================= -->
									<div id="order_status" class="modal" role="dialog">
										<?php
											$service_charge = 00 ;
											$queryservice_charge = "SELECT * FROM service_charge";

											$resultsservice_charge = mysqli_query($conn, $queryservice_charge);										
											while ($result = mysqli_fetch_assoc($resultsservice_charge)) {

											$service_charge = $result['service_charge_amount']; 
											}
										?>
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
									<!-- ================================================== -->
								</div>
							</div>
						</div>
					</div>
					<!-- ============Order share for process order ============ -->
					<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="shareModalLabel">Share Order Details</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<!-- Order details will be populated here -->
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-primary" id="shareDeliveryAgentBtn"><i class="fab fa-whatsapp"></i> Delivery </button>
								<button type="button" class="btn btn-primary" id="copyDeliveryAgentBtn"> <i class="fas fa-copy"></i> Delivery</button>
								<button type="button" class="btn btn-secondary" id="shareShopkeeperBtn"><i class="fab fa-whatsapp"></i> Shop</button>
								<button type="button" class="btn btn-secondary" id="copyShopkeeperBtn"> <i class="fas fa-copy"></i> Shop</button>
							</div>
						</div>
					</div>
				</div>
					<!-- ================================ -->
				</div>

				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-header">
								<div class="row align-items-center">
									<div class="col-sm-6">
										<div class="page-title">
											Today Deliverd Order List
										</div>
									</div>
									<div class="col-sm-6 text-sm-right">
										<div class=" mt-sm-0 mt-2">
											<button class="btn btn-outline-primary mr-2"><img src="assets/img/excel.png"
													alt=""><span class="ml-2">Excel</span></button>
											<button class="btn btn-outline-danger mr-2"><img src="assets/img/pdf.png"
													alt="" height="18"><span class="ml-2">PDF</span></button>
											<button class="btn btn-light" type="button" data-toggle="dropdown"
												aria-haspopup="true" aria-expanded="false"><i
													class="fas fa-ellipsis-h"></i></button>
											<div class="dropdown-menu dropdown-menu-right">
												<a class="dropdown-item" href="#">Action</a>
												<div role="separator" class="dropdown-divider"></div>
												<a class="dropdown-item" href="#">Another action</a>
												<div role="separator" class="dropdown-divider"></div>
												<a class="dropdown-item" href="#">Something else here</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
								$sqlCount = "SELECT COUNT(*) as total FROM orders WHERE order_status = 2";
								$countResult = mysqli_query($conn, $sqlCount);
								$totalCount = mysqli_fetch_assoc($countResult)['total'];
							?>
							<div class="card-body">
								<div class="table-responsive">
									<div class="mb-3">
										<p>Total Deliverd: <?php echo $totalCount; ?></p>
									</div>
									<table class="table custom-table">
										<thead class="thead-light">
											<tr>
												<th>Order ID</th>
												<th>Product </th>
												<th>Order ID</th>
												<th>Account Details</th>
												<th>Product</th>
												<th>Payment Details</th>
												<th>Store</th>
												<th>Charge</th>
												<th>Vendor</th>
											    <th>Status</th>
												<!-- <th class="text-right">Action</th> -->
											</tr>
										</thead>
										<tbody>
										<?php
										$today = date("Y-m-d"); 
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
										LEFT JOIN order_status ON orders.order_status = order_status.status_id 
										WHERE orders.order_status = 2 AND DATE(orders.updated_at) = '$today'";
										
										$sqlQuery .= " ORDER BY orders.updated_at DESC";

										$results = mysqli_query($conn, $sqlQuery);
											$count =1;

											while ($result = mysqli_fetch_assoc($results)) {
												
												$store_id=$result['account_group'];
												$query_store = "SELECT * FROM store where store_id = $store_id";
												$result_store  = mysqli_query($conn, $query_store );
												$store_data = mysqli_fetch_assoc($result_store );
													
											?>
											<tr>
												<td>
													<?php echo $result['orderId']; ?>
												</td>
												<td>
													<div class="order-info">
														<div class="order-image">
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
																<?php echo$result['comment']; ?>
															</div>
														</div>
													</div>
												</td>


												<td>
													<a href="order-profile.php?orderid=<?php echo $result['orderId']; ?>" title="<?php echo $store_data['store_name'] ?>" data-toggle="tooltip" style="color: #333; text-decoration: none;">
																<?php echo "#".$result['order_no'];?>
													</a>
													<p>
														<i class="fas fa-map-marker-alt"></i> <?php echo $result['order_location'];?>
													</p>
												</td>
												<td>
													<?php echo 
													$result['mobile_number'] . "<br>" .
													$result['account_holder_name']; 
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

												<td class="product-info">
													<div class="product-details">
														<h5 class="model-name"><?php echo $result['model_name']; ?></h5>
														<h5 class="varient-color">
															<?php echo $result['varient'] ?> <spain style="background-color: <?php echo $result['color']; ?>;"> <?php echo $result['color']; ?>  </spain>
														</h5>
													
													</div>
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
													<?php 
														echo '<p class="fas fa-credit-card">'.' '.$result['card_number'] . ' '. $result['card_type'].'</p> ';
							
														echo '<h6 style="color:red">'. substr($bank_data['bank_name'], 0, 5).' '. substr($result['card_holder_name'], 0, 11). '</h6>';
													?>
												</td>

												<td><?php echo $store_data['store_name'] ?></td>

												<td> <?php  echo $result['service_charge'] ?> </td>
												<td> 
													<?php
														if(isset($result['vendor_id'])){
															$sql = "SELECT vendor_name FROM vendor WHERE vendor_id = " . $result['vendor_id'];
															$resultSet = mysqli_query($conn, $sql);
															if ($resultSet) {
																$row = mysqli_fetch_assoc($resultSet);
																echo  $row['vendor_name'] ;
															}
														} else {
															echo "NA";
														}
													?>
												</td>

												<td>
													<img src="assets/img/store_logo/<?php echo $result['order_status_img'] ?>" alt="Logo" width="40" height="40"><br>
													<?php  echo $result['order_status_label'] ?>
												</td>

											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>

						</div>
					</div>
				</div>


	<!-- ----------------------------------------------------------------------------------------
	|		Lifetime Service Charges																				|
	---------------------------------------------------------------------------------------- -->

			<div class="row">
					<div class="col-lg-6 col-md-12 col-12 d-flex">
							<div class="card flex-fill">
								<div class="card-header">
									<div class="row align-items-center">
										<div class="col-auto">
											<div class="page-title">
												Graph
											</div>
										</div>
										<div class="col text-right">
											<div class=" mt-sm-0 mt-2">
												<button class="btn btn-light" type="button" data-toggle="dropdown"
													aria-haspopup="true" aria-expanded="false"><i
														class="fas fa-ellipsis-h"></i></button>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" href="#">Action</a>
													<div role="separator" class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Another action</a>
													<div role="separator" class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Something else here</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="card-body">
									<div id="chart4"></div>
								</div>
							</div>
						</div>


						<div class="col-lg-6 d-flex">
							<div class="card flex-fill">
								<div class="card-header">
									<div class="row align-items-center">
										<div class="col-auto">
											<div class="page-title">
												Order Performance
											</div>
										</div>
										<div class="col text-right">
											<div class=" mt-sm-0 mt-2">
												<button class="btn btn-light" type="button" data-toggle="dropdown"
													aria-haspopup="true" aria-expanded="false"><i
														class="fas fa-ellipsis-h"></i></button>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" href="#">Action</a>
													<div role="separator" class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Another action</a>
													<div role="separator" class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Something else here</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="card-body">
									<div id="chart2"></div>
								</div>
							</div>
						</div>
					</div>
			</div>
				<!-- -------------------------------------------------------- -->
				<!-- Displaying Lifetime Service Charges and Order Count -->
			<?php
				$totalLifetimeServiceCharges = 0;
				$totalLifetimeOrders = 0;

				$sqlLifetimeServiceCharge = "SELECT * FROM orders WHERE order_status = 2";
				$resultLifetimeServiceCharge = mysqli_query($conn, $sqlLifetimeServiceCharge);

				while ($row = mysqli_fetch_assoc($resultLifetimeServiceCharge)) {
					$serviceCharge = $row['service_charge'];
					$formattedNumber = number_format($serviceCharge);

					$totalLifetimeServiceCharges += $serviceCharge; // Add the raw service charge value, not the formatted one

					$totalLifetimeOrders++;
				}
			?>

				<div class="row">

					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="dash-widget dash-widget5" style="background-color: #f010f0;">
							<span class="float-left"><img src="assets/img/dash/dash-4.png" alt="" width="80"></span>
							<div class="dash-widget-info text-right">
								<span>Lifetime Service Charges</span>
								<h3>&#x20B9; <?php echo number_format($totalLifetimeServiceCharges, 2, '.', ','); ?></h3>
								<p>Total Orders Lifetime: <?php echo $totalLifetimeOrders; ?></p>
							</div>
						</div>
					</div>
					

					<!-- Displaying Previous Month Service Charges and Order Count -->
					<?php
						$totalPreviousMonthServiceCharges = 0;
						$totalPreviousMonthOrders = 0;

						// Get the first day of the previous month
						$firstDayOfPreviousMonth = date('Y-m-d', strtotime('first day of last month'));

						// Get the last day of the previous month
						$lastDayOfPreviousMonth = date('Y-m-d', strtotime('last day of last month'));

						$previousMonthName = date('F', strtotime('last month'));
						$previousMonthDateRange = date('j', strtotime($firstDayOfPreviousMonth)) . ' to ' . date('j', strtotime($lastDayOfPreviousMonth));

						$sqlPreviousMonthServiceCharge = "SELECT * FROM orders WHERE order_status = 2 AND created_at BETWEEN '$firstDayOfPreviousMonth' AND '$lastDayOfPreviousMonth'";
						
						$resultPreviousMonthServiceCharge = mysqli_query($conn, $sqlPreviousMonthServiceCharge);
						
						while ($result = mysqli_fetch_assoc($resultPreviousMonthServiceCharge)) {
							
							$serviceCharge = $result['service_charge'];
							$formattedNumber = number_format($serviceCharge);

							$totalPreviousMonthServiceCharges += $serviceCharge; 

							$totalPreviousMonthOrders++;
						}
					?>
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="dash-widget dash-widget5" style="background-color: #e6f7ff;">
							<span class="float-left"><img src="assets/img/dash/dash-2.png" alt="" width="80"></span>
							<div class="dash-widget-info text-right">
								<span>Previous Month: <?php echo $previousMonthName ." " .$previousMonthDateRange;; ?></span>
								<h3>&#x20B9; <?php echo number_format($totalPreviousMonthServiceCharges, 2, '.', ','); ?></h3>
								<p>Total Orders in Previous Month: <?php echo $totalPreviousMonthOrders; ?></p>
							</div>
						</div>
					</div>

					<!-- Displaying Monthly Service Charges and Order Count -->
					<?php
						$totalMonthlyServiceCharges = 0;
						$totalMonthlyOrders = 0;
						
						$currentMonth = date('m');
						$currentYear = date('Y');
						
						$sqlMonthlyServiceCharge = "SELECT * FROM orders WHERE order_status = 2 AND MONTH(created_at) = $currentMonth AND YEAR(created_at) = $currentYear";
						
						$resultMonthlyServiceCharge = mysqli_query($conn, $sqlMonthlyServiceCharge);
						
						while ($result = mysqli_fetch_assoc($resultMonthlyServiceCharge)) {
							
							$serviceCharge = $result['service_charge'];
							$formattedNumber = number_format($serviceCharge);
	
							$totalMonthlyServiceCharges += $serviceCharge; 
	
							$totalMonthlyOrders++;
						}
					?>
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="dash-widget dash-widget5" style="background-color: #e6ffe6;">
							<span class="float-left"><img src="assets/img/dash/dash-3.png" alt="" width="80"></span>
							<div class="dash-widget-info text-right">
								<span>Monthly Service Charges</span>
								<h3>&#x20B9; <?php echo number_format($totalMonthlyServiceCharges, 2, '.', ','); ?></h3>
								<p>Total Orders in Current Month: <?php echo $totalMonthlyOrders; ?></p>
							</div>
						</div>
					</div>

					<?php
					$sqlProducts = "SELECT COUNT(*) AS product_count FROM products"; // Assuming your table is named "products"
					$resultProducts = mysqli_query($conn, $sqlProducts);
					?>
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="dash-widget dash-widget5" style="background-color: #ffffcc;">
							<div class="dash-widget-info d-inline-block text-left">
								<span>Total Products</span>
								<?php
								$productCount = $resultProducts ? mysqli_fetch_assoc($resultProducts)['product_count'] : "N/A";
								?>
 								<h3 class="counting"><?php echo $productCount ?></h3>						
							</div>
							<span class="float-right"><img src="assets/img/dash/dash-1.png" alt="" width="80"></span>
						</div>
					</div>
				</div>
				<!-- ----------------------------------------------------------------------------------------
				|				Vendor view Dashboard													|
				---------------------------------------------------------------------------------------- -->
				<?php include 'dashboard_vendor.php';?>
				<div class="row">
					<div class="col-lg-6 col-md-12 col-12 d-flex">
						<div class="card flex-fill">
							<div class="card-header">
								<div class="row align-items-center">
									<div class="col-auto">
										<div class="page-title">
											Events
										</div>
									</div>
									<div class="col text-right">
										<div class=" mt-sm-0 mt-2">
											<button class="btn btn-light" type="button" data-toggle="dropdown"
												aria-haspopup="true" aria-expanded="false"><i
													class="fas fa-ellipsis-h"></i></button>
											<div class="dropdown-menu dropdown-menu-right">
												<a class="dropdown-item" href="#">Action</a>
												<div role="separator" class="dropdown-divider"></div>
												<a class="dropdown-item" href="#">Another action</a>
												<div role="separator" class="dropdown-divider"></div>
												<a class="dropdown-item" href="#">Something else here</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body dashboard-calendar">
								<div id="calendar" class=" overflow-hidden"></div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 col-12 d-flex">
						<div class="card flex-fill">
							<div class="card-header">
								<div class="row align-items-center">
									<div class="col-auto">
										<div class="page-title">
											Total Member
										</div>
									</div>
									<div class="col text-right">
										<div class=" mt-sm-0 mt-2">
											<button class="btn btn-light" type="button" data-toggle="dropdown"
												aria-haspopup="true" aria-expanded="false"><i
													class="fas fa-ellipsis-h"></i></button>
											<div class="dropdown-menu dropdown-menu-right">
												<a class="dropdown-item" href="#">Action</a>
												<div role="separator" class="dropdown-divider"></div>
												<a class="dropdown-item" href="#">Another action</a>
												<div role="separator" class="dropdown-divider"></div>
												<a class="dropdown-item" href="#">Something else here</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body d-flex align-items-center justify-content-center overflow-hidden">
								<div id="chart3"></div>
							</div>
						</div>
					</div>
				</div>



				<?php
					include 'notification.php';
				?>
			</div>



		</div>
	</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const counterElements = document.querySelectorAll(".counting");
    
    counterElements.forEach(function (element) {
        const targetValue = parseInt(element.textContent, 10);
        countUp(element, targetValue);
    });
});

function countUp(element, targetValue) {
    let currentValue = 1;
    const duration = 2000; // 2 seconds
    const frameRate = 60;
    const step = targetValue / (duration / 1000) / frameRate;

    function updateValue() {
        currentValue += step;
        if (currentValue <= targetValue) {
            element.textContent = Math.floor(currentValue);
            requestAnimationFrame(updateValue);
        } else {
            element.textContent = targetValue;
        }
    }
    updateValue();
}

</script>
	<script src="assets/js/jquery-3.6.0.min.js"></script>

	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<!-- 
	<script src="assets/js/jquery.slimscroll.js"></script> -->

	<script src="assets/js/select2.min.js"></script>
	<script src="assets/js/moment.min.js"></script>

	<script src="assets/js/fullcalendar.min.js"></script>
	<script src="assets/js/jquery.fullcalendar.js"></script>

	<script src="assets/plugins/morris/morris.min.js"></script>
	<script src="assets/plugins/raphael/raphael-min.js"></script>
	<script src="assets/js/apexcharts.js"></script>
	<script src="assets/js/chart-data.js"></script>

	<script src="assets/js/app.js"></script>

	<script src="order/update_order_status.js"></script>
		<!-- JavaScript -->
	<script src="order/share.js"></script>

</body>


</html>