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
    include "backend/db_connection.php";

$account_id  = $_GET['account_id'];
$sql="SELECT * from  accounts where account_id = $account_id";
$result = $conn->query($sql);

if($result) {
 $accounts = $result->fetch_all(MYSQLI_ASSOC);
}
foreach($accounts as $result);

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

    <link rel="stylesheet" href="assets/plugins/datetimepicker/css/tempusdominus-bootstrap-4.min.css">

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
                                            <form class="custom-mt-form" action="backend/edit_account.php" method="POST" enctype="multipart/form-data">

                                                <div class="row mt-3">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <input type="hidden" name="account_id" value="<?php echo $result['account_id']?>" >
                                                        <label>Store Name </label>
                                                        <select class="form-control select" name="account_group" required>
                                                            <?php
                                                            $sql_query = "SELECT * FROM store WHERE store_status = 1";
                                                            $results_sql = mysqli_query($conn, $sql_query);

                                                            while ($result_sql = mysqli_fetch_assoc($results_sql)) {
                                                              echo  $selected = ($result['account_group'] == $result_sql['store_id']) ? 'selected' : '';
                                                                echo "<option value='" . $result_sql['store_id'] . "' $selected>" . $result_sql['store_name'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                        </div> 
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Account Type</label>
                                                            <select class="form-control select" name="account_type">
                                                            <option value="self" <?php if ($result['account_type'] == 'self') echo 'selected="selected"'; ?>>Self</option>
                                                            <option value="custom" <?php if ($result['account_type'] == 'custom') echo 'selected="selected"'; ?>>Custom</option>
                                                        </select>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Mobile Number</label>
                                                            <input type="text" class="form-control" name="mobile_number" value="<?php echo $result['mobile_number']?>">
                                                        </div>
                                                    </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="text" class="form-control" name="email" value="<?php echo $result['email']?>">
                                                    </div>
                                                </div>
											</div>

                                                <div class="row mt-3">
												<div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Account Holder Name</label>
                                                    <input type="text" class="form-control" name="account_holder_name" value="<?php echo $result['account_holder_name']?>">
                                                </div>
                                                </div>
                                                <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Account Login Password</label>
                                                    <input type="text" class="form-control" name="account_login_password" value="<?php echo $result['account_login_password']?>">
                                                </div>

                                                </div>
											</div>

                                                <div class="row mt-3">
												<div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Upload Image</label>
                                                        <input type="file" name="image"  value=""accept="image/*" class="form-control" onchange="previewImage(this);">
                                                    </div>

                                                    <div class="form-group">
                                                    <label>Image Preview</label><br>
                                                    <img id="imagePreview" src="uploads/<?php echo $result['image'] ?>" alt="imagePreview" width="80" height="80">
                                                    
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Comment</label>
                                                    <textarea class="form-control" name="comment" ><?php echo $result['comment']?></textarea>
                                                </div>
                                                </div>
											</div>
                                               
                                                
                                                <div class="form-group text-center custom-mt-form-group">
                                                    <button class="btn btn-warning mr-2" type="submit">Update</button>
                                                    <button class="btn btn-danger" type="reset">Cancel</button>
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
    <script>
    function previewImage(input) {
        var preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '';
        }
    }
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