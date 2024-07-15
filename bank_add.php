<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>add-bank</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/datetimepicker/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="assets/css/select2.min.css">
    <link rel="stylesheet" href="assets/plugins/datetimepicker/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
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
                            <h5 class="text-uppercase mb-0 mt-0 page-title">bank</h5>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                            <ul class="breadcrumb float-right p-0 mb-0">
                                <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                                <li class="breadcrumb-item"><a href="add-card.php">bank</a></li>
                                <li class="breadcrumb-item"><span> Add bank</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-12 col-12 text-left add-btn-col">
                        <a href="bank_add.php" class="btn btn-primary float-right btn-rounded"><i class="fas fa-plus"></i> Add New Record </a>
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
								<!-- =============================================Edit Form==================================== -->
                                
                                <?php if(isset($_GET['bank_id'])) {
                                    $bank_id = $_GET['bank_id'];
                                    $query = "SELECT * FROM bank_name where bank_id = $bank_id";
                                    $result = mysqli_query($conn, $query);
                                    $bank_data = mysqli_fetch_assoc($result);
                                    ?>
                                    <div class="card-header">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="page-title">
                                                    Edit Record 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="backend/bank_add.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                                    <input type="hidden" class="form-control" name="bank_id" id="bank_id" value="<?php echo $bank_data['bank_id'] ?>">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label>bank Name</label>
                                                    <input type="text" class="form-control" name="bank_name" id="bank_name" value="<?php echo $bank_data['bank_name'] ?>">
                                                    <div id="bank_name_error" class="error" style="color: red; font-weight: bold;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>bank Status</label>
                                                <select class="form-control" name="bank_status" id="bank_status">
                                                    <option value="1" <?php echo ($bank_data['bank_status'] == '1') ? 'selected' : ''; ?>>Active</option>
                                                    <option value="0" <?php echo ($bank_data['bank_status'] == '0') ? 'selected' : ''; ?>>Inactive</option>
                                                </select>
                                                <div id="bank_status_error" class="error" style="color: red; font-weight: bold;"></div>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Image</label>
                                                        <input type="file" name="bank_image" accept="image/*" class="form-control" id="update_bank_image" onchange="previewImage(this);">
                                                        
                                                        <div id="bank_image_error" class="error" style="color: red; font-weight: bold;"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Image Preview</label><br>
                                                        <img id="imagePreview" src="assets/img/bank_logo/<?php echo $bank_data['bank_img'] ?>" alt="imagePreview" width="80" height="80">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group text-center custom-mt-form-group">
                                            <button class="btn btn-warning mr-2" type="submit" name="update">Update Record</button>
                                            <button class="btn btn-secondary" type="reset">Cancel</button>
                                        </div>
                                    </form>
                                    <!-- =====================================================Edit Form================================ -->
                                    <?php } 
                                    else{ ?>
                                        <div class="card-header">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="page-title">
                                                        Add Bank 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="backend/bank_add.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()" >
                                                <div class="form-group">
                                                    <label>bank Name</label>
                                                    <input type="text" class="form-control" name="bank_name" id="bank_name">
                                                    <div id="bank_name_error" class="error" style="color: red; font-weight: bold;"></div>
                                                </div>
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>bank Image</label>
                                                            <input type="file" name="bank_image" accept="image/*" class="form-control" id="bank_image" onchange="previewImage(this);">
                                                            <div id="bank_image_error" class="error" style="color: red; font-weight: bold;"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Image Preview</label><br>
                                                                <img id="imagePreview" src="assets/img/bank_logo/placeholder.jpg" alt="imagePreview" width="50" height="50">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group text-center custom-mt-form-group">
                                                    <button class="btn btn-primary mr-2" type="submit" name="submit" value="submit">Add Bank</button>
                                                    <button class="btn btn-secondary" type="reset">Reset</button>
                                                </div>
                                            </form>
                                    <?php } ?>
                                       
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
								</div>
							</div>
							<div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                 <?php if(isset($_GET['bank_id'])) {
                                                echo "<th>CheckBox</th>";
                                                }?>
                                         
                                                <th>bank Id</th>
                                                <th>bank Name</th>
                                                <th>bank Image</th>
                                                <th>status</th>
                                                <th>Action</th>
                                            
										</tr>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $bank_id = "";
                                            if(isset($_GET['bank_id'])) {
                                               $bank_id= $_GET['bank_id'] ;
                                            }
                                            $query = "SELECT * FROM bank_name";

                                            $results = mysqli_query($conn, $query);										
                                            while ($result = mysqli_fetch_assoc($results)) {
                                            
                                            ?>
                                                <tr>
                                                    <?php  if(isset($_GET['bank_id'])) { ?>
                                                    <td>
                                                    <input type="checkbox" class="orderCheckbox" <?php echo ($bank_id == $result['bank_id']) ? 'checked' : ''; ?> readonly>
                                                    </td>
                                                    <?php   }?>
                                        
                                                    <td><?php echo $result['bank_id']; ?></td>
    
                                                    <td><?php echo $result['bank_name']; ?></td>
    
                                                    <td><?php echo '<img src="assets/img/bank_logo/' . $result['bank_img'] . '" alt="Flipkart Logo" width="40" height="27">' ?></td>

                                                     <td style="font-weight: bold; color: <?php echo ($result['bank_status'] == 1) ? 'green' : 'red'; ?>;">
                                                        <?php echo ($result['bank_status'] == 1) ? 'Active' : 'Inactive'; ?>
                                                    </td>
    
                                                    <td class="text-right">
                                                        <a href="bank_add.php?bank_id=<?php echo $result['bank_id']; ?>" class="btn btn-primary btn-sm mb-1">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                        <button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
                                                            <i class="far fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                                
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                        </tbody>
                                    </table>
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
        function validateForm() {
            var bankName = document.getElementById("bank_name").value;
            var bankImage = document.getElementById("bank_image").value;
            document.getElementById("bank_name_error").innerHTML = "";
            document.getElementById("bank_image_error").innerHTML = "";

            var isValid = true;

            if (bankName.trim() === "") {
                document.getElementById("bank_name_error").innerHTML = "bank Name is required";
                isValid = false;
            }

            if (bankImage.trim() === "") {
                document.getElementById("bank_image_error").innerHTML = "Image is required";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
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
