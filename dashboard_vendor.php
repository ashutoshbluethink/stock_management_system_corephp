<div class="row">
    <?php
    $sql = "SELECT * FROM vendor";
    $result = mysqli_query($conn, $sql);

    // Get the name of the current month
    $currentMonthName = date('F');

    // Define an array of light background colors
    $backgroundColors = array("#d93341", "#50ae7b", "#ff944b", "#e5e5f7");

    $colorIndex = 0; // Initialize color index

    if (mysqli_num_rows($result) > 0) {
        // Loop through each vendor record
        while ($row = mysqli_fetch_assoc($result)) {
            $vendor_id = $row['vendor_id'];
            $vendorName = $row['vendor_name'];
            $vendorImage = $row['vendor_image'];

            // SQL query to fetch orders for the current month
            $sql_order_count = "SELECT COUNT(*) AS order_count, SUM(service_charge) AS total_service_charge 
                                FROM orders 
                                WHERE vendor_id = $vendor_id 
                                AND MONTH(created_at) = MONTH(CURRENT_DATE()) 
                                AND YEAR(created_at) = YEAR(CURRENT_DATE())";
            
            $result_order_count = mysqli_query($conn, $sql_order_count);

            // Check if any orders were found
            if (mysqli_num_rows($result_order_count) > 0) {
                $row_order_count = mysqli_fetch_assoc($result_order_count);
                $orderCount = $row_order_count['order_count'];
                $totalServiceCharge = $row_order_count['total_service_charge'];
            } else {
                // If no orders were found, set defaults
                $orderCount = 0;
                $totalServiceCharge = 0.00;
            }

            // Output vendor data with dynamic background color
            ?>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget dash-widget5" style="background-color: <?php echo $backgroundColors[$colorIndex]; ?>">
                    <div class="profile-img">
                        <span class="avatar">
                            <img src="assets/img/vendor/<?php echo $vendorImage; ?>" alt="<?php echo $vendorName; ?>" width="80">
                        </span>
                    </div>
                    <div class="dash-widget-info text-right" style="color: white;">
                        <strong><span style="font-size: larger;"><?php echo $vendorName." "."(".$currentMonthName.")" ; ?></span></strong>
                        <p style="color: white; font-weight: bold;">Total Service Charge: ₹<?php echo ($totalServiceCharge < 1) ? '0.00' : number_format($totalServiceCharge, 2); ?></p>
                        <p style="color: white;">Number of Orders: <?php echo $orderCount; ?></p>
                    </div>

                </div>
            </div>
            <?php
            // Increment color index and reset if it exceeds the array length
            $colorIndex++;
            if ($colorIndex >= count($backgroundColors)) {
                $colorIndex = 0;
            }
        }
    } else {
        echo "No vendors found.";
    }
    ?>

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
        <div class="dash-widget dash-widget5" style="background-color: #e5e5f7;">
            <span class="float-left"><img src="assets/img/dash/dash-3.png" alt="" width="80"></span>
            <div class="dash-widget-info text-right">
                <span>Monthly Service Charges</span>
                <h4>&#x20B9; <?php echo number_format($totalMonthlyServiceCharges, 2, '.', ','); ?></h4>
                <p>Total Orders in Current Month: <?php echo $totalMonthlyOrders; ?></p>
            </div>
        </div>
    </div>
</div>
