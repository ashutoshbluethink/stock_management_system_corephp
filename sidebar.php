<?php
// Get the current page URL
$currentUrl = $_SERVER['PHP_SELF'];
$filename = basename($currentUrl);
// Function to check if a menu item is active
function isActive($url)
{
    global $filename;
    return ($filename == $url) ? 'active' : '';
}
?>
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <div class="header-left">
                <a href="dashboard.php" class="logo">
                    <img src="assets/img/logo1.png" width="40" height="40" alt="">
                    <span class="text-uppercase">MKSP</span>
					
                </a>
            </div>

					<ul class="sidebar-ul">
						<li class="menu-title">Menu</li>
						<li class="<?php echo isActive('dashboard.php'); ?>">
							<a href="dashboard.php">
								<img src="assets/img/sidebar/icon-1.png" alt="icon">
								<span>Dashboard</span>
							</a>
						</li>

						<li class="submenu">
							<a href="#">
								<img src="assets/img/sidebar/icon-2.png" alt="icon">
								<span> Orders</span>
								<span class="menu-arrow"></span>
							</a>
							<ul class="list-unstyled" style="display: none;">
								<li><a href="add-order.php" class="<?php echo isActive('add-order.php'); ?>"><span>Add Order</span></a></li>
								<li><a href="all-order.php" class="<?php echo isActive('all-order.php'); ?>"><span>All Orders</span></a></li>
								<!-- <li><a href="processed-order.php" class="<?php echo isActive('processed-order.php'); ?>"><span>Processed Order</span></a></li> -->
								<li><a href="deliverd-order.php" class="<?php echo isActive('deliverd-order.php'); ?>"><span>Deliverd Order</span></a></li>
								<!-- <li><a href="cancle-order.php" class="<?php echo isActive('cancle-order.php'); ?>"><span>Cancle Order</span></a></li> -->
							
							</ul>
						</li>

						<li class="submenu">
							<a href="#">
								<img src="assets/img/sidebar/icon-2.png" alt="icon">
								<span> Payments</span>
								<span class="menu-arrow"></span>
							</a>
							<ul class="list-unstyled" style="display: none;">
								<li><a href="all-card.php" class="<?php echo isActive('all-card.php'); ?>"><span>All Card</span></a></li>
								<li><a href="add-card.php" class="<?php echo isActive('add-card.php'); ?>"><span>Add Card</span></a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="#">
								<img src="assets/img/sidebar/icon-3.png" alt="icon">
								<span> Accounts</span>
								<span class="menu-arrow"></span>
							</a>
							<ul class="list-unstyled" style="display: none;">
								<li><a href="add-accounts.php" class="<?php echo isActive('add-accounts.php'); ?>"><span>Add Account</span></a></li>
								<li><a href="all-accounts.php" class="<?php echo isActive('all-accounts.php'); ?>"><span>All Accounts</span></a></li>
							</ul>
						</li>


						<li class="submenu">
							<a href="#"><img src="assets/img/sidebar/icon-4.png" alt="icon"> <span> Products</span> <span
									class="menu-arrow"></span></a>
							<ul class="list-unstyled" style="display: none;">
							<li><a href="all-product.php" class="<?php echo isActive('all-product.php'); ?>"><span>All Products</span></a></li>
								<li><a href="add-product.php" class="<?php echo isActive('add-product.php'); ?>"><span>Add product</span></a></li>
							</ul>
						</li>

					
						<li class="submenu">
							<a href="#">
								<img src="assets/img/sidebar/icon-8.png" alt="icon">
								<span>Configuration </span>
								<span class="menu-arrow"></span>
							</a>
							<ul class="list-unstyled" style="display: none;">
								<li><a href="store_add.php" class="<?php echo isActive('store_add.php'); ?>"><span> Store List</span></a></li>

								<li><a href="bank_add.php" class="<?php echo isActive('bank_add.php'); ?>"><span>Bank List</span></a></li>
							
								<li><a href="add-order-status.php" class="<?php echo isActive('add-order-status.php'); ?>"><span>Order Status</span></a></li>
								<li><a href="brand_add.php" class="<?php echo isActive('brand_add.php'); ?>"><span>Brand Name</span></a></li>
								<li><a href="payment_mode.php" class="<?php echo isActive('payment_mode.php'); ?>"><span>Payment Mode</span></a></li>
								<li><a href="service_charge.php" class="<?php echo isActive('service_charge.php'); ?>"><span>Service Charges</span></a></li>
								<li><a href="vendor_add.php" class="<?php echo isActive('vendor_add.php'); ?>"><span>Vendor Name</span></a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>