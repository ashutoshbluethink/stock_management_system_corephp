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

    <link rel="stylesheet" href="assets/plugins/datetimepicker/css/tempusdominus-bootstrap-4.min.css">

    <link rel="stylesheet" href="assets/css/select2.min.css">

    <link rel="stylesheet" href="assets/css/style.css">

</head>
<style>
	.required {
  color: red;
}
</style>
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
                            <h5 class="text-uppercase mb-0 mt-0 page-title">Add Account</h5>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                            <ul class="breadcrumb float-right p-0 mb-0">
                                <li class="breadcrumb-item"><a href="dashboard.php"><I class="fas fa-home"></i> Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Accounts</a></li>
                                <li class="breadcrumb-item"><span> Add Account</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="page-content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                            <form class="custom-mt-form" action="backend/add-accounts.php" method="POST" enctype="multipart/form-data">

                                                <div class="row mt-3">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Store Name<span class="required"> *</span></label>
                                                            <select class="form-control select" name="account_group" id="account_group" required>
                                                            <option value="">--Select--</option>
                                                            <?php $query = "SELECT * FROM store where store_status=1";
                                                            $results = mysqli_query($conn, $query);
                                                            										
                                                            while ($result = mysqli_fetch_assoc($results)) {
                                                         
                                                                echo "<option value='" . $result['store_id'] . "'>" . $result['store_name'] . "</option>";
                                                            } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                        <label class="font-weight-bold"><strong>Account Type <span class="required"> *</span></strong></label>
                                                            <select class="form-control select" name="account_type" required >
                                                                <option value="self">Self</option>
                                                                <option value="custom">Custom</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Mobile Number <span class="required">*</span></label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">91</span>
                                                                </div>
                                                                <input type="text" class="form-control" name="mobile_number" id="mobile_number"  placeholder="Enter Mobile Number" aria-label="Mobile Number" required>
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fas fa-mobile-alt"></i>
                                                                    </span>
                                                                </div>
                                                                <p id="error-message"></p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div a class="form-group">
                                                            <label class="font-weight-bold">Email <span class="required">*</span></label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="email" placeholder="Enter Email" aria-label="Email" required>
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fas fa-envelope"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
											    </div>

                                                <div class="row mt-3">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Account Holder Name <span class="required">*</span></label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="account_holder_name" placeholder="Enter Account Holder Name" aria-label="Account Holder Name" required>
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fas fa-user"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Account Login Password</label>
                                                            <div class="input-group">
                                                                <input type="password" class="form-control" name="account_login_password" placeholder="Enter Account Login Password" aria-label="Account Login Password">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fas fa-lock"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
											    </div>

                                                <div class="row mt-3">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Upload Image</label>
                                                            <div class="input-group">
                                                                <input type="file" name="image" accept="image/*" class="form-control" aria-label="Upload Image">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fas fa-upload"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Comment</label>
                                                            <textarea class="form-control" name="comment"></textarea>
                                                        </div>
                                                    </div>
											    </div>
                                               
                                                
                                                <div class="form-group text-center custom-mt-form-group">
                                                    <button class="btn btn-primary mr-2" type="submit">Submit</button>
                                                    <button class="btn btn-secondary" type="reset">Cancel</button>
                                                </div>
                                            </form>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
					include 'notification.php';
				?>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#mobile_number').on('blur', function() {
        var mobileNumber = $(this).val();
        var selectedStore = $('#account_group').val(); 

        $.ajax({
            url: 'order/featchRecord/check_duplicate_mobile.php', 
            method: 'POST',
            data: {
                mobile_number: mobileNumber,
                store_id: selectedStore
            },
            success: function(response) {
                if (response === 'duplicate') {
                    var errorMessage = $('<p>', {
                        text: 'Duplicate mobile number in the selected store. Please choose a different mobile number.',
                        style: 'color: red; font-weight: bold;'
                    });
                    $('#error-message').empty().append(errorMessage);
                } else {
                    $('#error-message').empty();
                }
            }
        });
    });
    $('#mobile_number, #account_group').on('change', function() {
        $('#error-message').empty();
    });
});
</script>

    <script src="assets/js/jquery-3.6.0.min.js"></script>

    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <!-- <script src="assets/js/jquery.slimscroll.js"></script> -->

    <script src="assets/js/select2.min.js"></script>
    <script src="assets/js/moment.min.js"></script>

    <script src="assets/plugins/datetimepicker/js/tempusdominus-bootstrap-4.min.js"></script>

    <script src="assets/js/app.js"></script>
</body>



</html>