<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Add Order Status</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/datetimepicker/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="assets/css/select2.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
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
                            <h5 class="text-uppercase mb-0 mt-0 page-title">Order Status</h5>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                            <ul class="breadcrumb float-right p-0 mb-0">
                                <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                                <li class="breadcrumb-item"><a href="add-card.php">Order Status</a></li>
                                <li class="breadcrumb-item"><span>Add Order Status</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-12 col-12 text-left add-btn-col">
                        <a href="add-order-status.php" class="btn btn-primary float-right btn-rounded"><i class="fas fa-plus"></i> Add New Record </a>
                    </div>
                </div>
 				<!-- #################################################################################################### -->
                <!-- //massage manager  -->
                <!-- ####################################################################################################### -->

                <script src="assets/js/jquery-3.6.0.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
                <?php
                    if (isset($_SESSION['errorMessage']) && !empty($_SESSION['errorMessage'])) {
                        echo '<script>
                        $(document).ready(function() {
                            toastr.error("' . $_SESSION['errorMessage'] . '", "", { 
                                timeOut: 5000, 
                                progressbar: true,
                                positionClass: "toast-top-center"
                            });
                        });
                        </script>';
                        $_SESSION['errorMessage'] = ""; // Clear the session variable
                    }
                                    if (isset($_SESSION['successMessage']) && !empty($_SESSION['successMessage'])) {
                        echo '<script>
                        $(document).ready(function() {
                            toastr.success("' . $_SESSION['successMessage'] . '", "", { 
                                timeOut: 5000, 
                                progressbar: true,
                                positionClass: "toast-top-center"
                            });
                        });
                        </script>';
                        $_SESSION['successMessage'] = ""; // Clear the session variable
                    }
                    ?>
                    <!-- #################################################################################################### -->
                <!-- //massage manager  -->
                <!-- ####################################################################################################### -->
                <div class="row">
                    <div class="col-lg-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body">
                                <?php if(isset($_GET['status_id'])) {
                                    $status_id = $_GET['status_id'];
                                    $query = "SELECT * FROM order_status WHERE status_id = $status_id";
                                    $result = mysqli_query($conn, $query);
                                    $order_status_data = mysqli_fetch_assoc($result);
                                    ?>
                                    <div class="card-header">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="page-title">
                                                    Edit Order Status
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="backend/add_status.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                                    <input type="hidden" class="form-control" name="status_id" id="status_id" value="<?php echo $order_status_data['status_id'] ?>">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Order Status Name</label>
                                                <input type="text" class="form-control" name="order_status_label" id="order_status_label" value="<?php echo $order_status_data['order_status_label'] ?>">
                                                <div id="order_status_name_error" class="error" style="color: red; font-weight: bold;"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Order Status</label>
                                                <select class="form-control" name="order_status" id="order_status">
                                                    <option value="1" <?php echo ($order_status_data['order_status'] == '1') ? 'selected' : ''; ?>>Active</option>
                                                    <option value="0" <?php echo ($order_status_data['order_status'] == '0') ? 'selected' : ''; ?>>Inactive</option>
                                                </select>
                                                <div id="order_status_error" class="error" style="color: red; font-weight: bold;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Image</label>
                                                    <input type="file" name="order_status_img" accept="image/*" class="form-control" id="order_status_img" onchange="previewImage(this);">
                                                    <div id="order_status_image_error" class="error" style="color: red; font-weight: bold;"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Image Preview</label><br>
                                                    <img id="imagePreview" src="assets/img/store_logo/<?php echo $order_status_data['order_status_img'] ?>" alt="Image Preview" width="80" height="80">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text-center custom-mt-form-group">
                                        <button class="btn btn-warning mr-2" type="submit" name="update">Update Record</button>
                                        <button class="btn btn-secondary" type="reset">Cancel</button>
                                    </div>
                                    </form>
                                <?php } else { ?>
                                    <div class="card-header">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="page-title">
                                                    Add Order Status
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="backend/add_status.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                                        <div class="form-group">
                                            <label>Order Status Name</label>
                                            <input type="text" class="form-control" name="order_status_label" id="order_status_name">
                                            <div id="order_status_name_error" class="error" style="color: red; font-weight: bold;"></div>
                                        </div>

                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Order Status Logo</label>
                                                        <input type="file" name="order_status_img" accept="image/*" class="form-control" id="order_status_image" onchange="previewImage(this);">
                                                        <div id="order_status_image_error" class="error" style="color: red; font-weight: bold;"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Image Preview</label><br>
                                                        <img id="imagePreview" src="assets/img/store_logo/placeholder.jpg" alt="Image Preview" width="80" height="80">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group text-center custom-mt-form-group">
                                            <button class="btn btn-primary mr-2" type="submit" name="submit">Add Order Status</button>
                                            <button class="btn btn-secondary" type="reset">Reset</button>
                                        </div>
                                    </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
						<!-- ------------------------------------table ------------------------------------ -->
                    <div class="col-lg-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="page-title">
                                            Order Status Performance
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <?php if(isset($_GET['status_id'])) { ?>
                                                    <th>CheckBox</th>
                                                <?php } ?>
                                                <th>Order Status Id</th>
                                                <th>Order Status Name</th>
                                                <th>Order Status Image</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $order_status_id = "";
                                            if(isset($_GET['status_id'])) {
                                                $status_id = $_GET['status_id'];
                                            }
                                            $query = "SELECT * FROM order_status";
                                            $results = mysqli_query($conn, $query);
                                            while ($result = mysqli_fetch_assoc($results)) {
                                            ?>
                                                <tr>
                                                    <?php if(isset($_GET['status_id'])) { ?>
                                                        <td>
                                                            <input type="checkbox" class="order_statusCheckbox" <?php echo ($status_id == $result['status_id']) ? 'checked' : ''; ?> readonly>
                                                        </td>
                                                    <?php } ?>
                                                    <td><?php echo $result['status_id']; ?></td>
                                                    <td><?php echo $result['order_status_label']; ?></td>

                                                    <td><?php echo '<img src="assets/img/store_logo/' . $result['order_status_img'] . '" alt="Status Logo" width="40" height="27">' ?>
													</td>

                                                    <td style="font-weight: bold; color: <?php echo ($result['order_status'] == 1) ? 'green' : 'red'; ?>;">
                                                        <?php echo ($result['order_status'] == 1) ? 'Active' : 'Inactive'; ?>
                                                    </td>

                                                    <td class="text-right">
                                                        <a href="add-order-status.php?status_id=<?php echo $result['status_id']; ?>" class="btn btn-primary btn-sm mb-1">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                        <!-- <button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
                                                            <i class="far fa-trash-alt"></i>
                                                        </button> -->
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
						<!-- ------------------------------------table ------------------------------------ -->

                </div>
            </div>

            <?php
            include 'notification.php';
            ?>
        </div>
    </div>

    <script>
        function validateForm() {
            var order_statusName = document.getElementById("order_status_name").value;
            var order_statusImage = document.getElementById("order_status_image").value;
            document.getElementById("order_status_name_error").innerHTML = "";
            document.getElementById("order_status_image_error").innerHTML = "";

            var isValid = true;

            if (order_statusName.trim() === "") {
                document.getElementById("order_status_name_error").innerHTML = "Order Status Name is required";
                isValid = false;
            }

            if (order_statusImage.trim() === "") {
                document.getElementById("order_status_image_error").innerHTML = "Image is required";
                isValid = false;
            }

            return isValid;
        }
    </script>

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

<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["pdf"]
            // "order": [[0, "desc"]] 
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/select2.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/plugins/datetimepicker/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="assets/js/app.js"></script>
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
</body>

</html>
