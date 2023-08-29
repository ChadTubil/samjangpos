<?php
    include 'db-controller.php';
    session_start();

    if(!(isset($_SESSION["users_id"]))) {
        header("location: default.php");
    }

    $UID = $_SESSION["users_id"];
    $id = $_GET["id"];
    $sqlEmployees = "SELECT * FROM employees_tbl WHERE emp_id = '$id'";
    $queryEmployees = mysqli_query($dbConString, $sqlEmployees);
    $fetchEmployees = mysqli_fetch_assoc($queryEmployees);

    if(isset($_POST['btnSave'])) {
        $txtImage = $_FILES["fileUpload"]["name"];
        $txtCode = $_POST['Code'];
        $txtName = $_POST['Name'];
        $txtPosition = $_POST['Position'];
        $txtEmail = $_POST['Email'];
        $txtContact = $_POST['Contact'];
        $txtAddress = $_POST['Address'];
        $date = date('Y-m-d');

        $sqlUpdate = "UPDATE employees_tbl SET emp_image = '$txtImage', emp_number = '$txtCode', emp_name = '$txtName',
        emp_position_id = $txtPosition, emp_email = '$txtEmail', emp_contact = '$txtContact', emp_address = '$txtAddress' WHERE emp_id = '$id'";
        mysqli_query($dbConString, $sqlUpdate);

        move_uploaded_file($_FILES["fileUpload"]["tmp_name"], "image/".$_FILES["fileUpload"]["name"]);

        header("location: employees.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'body/head.php'; ?>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->
    <?php include 'body/header.php'; ?>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->


        <!--**********************************
            Sidebar start
        ***********************************-->
        <?php 
            if($UID == 1){
                include 'body/sidebar.php'; 
            }else{
                include 'body/sidebar-2.php';
            }
        ?>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0" style="background-color: #f9f937; border: solid; border-color: black;">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4 style="color: black;">EMPLOYEES</h4>
                            <span class="ml-1" style="color: black;">Inventory</span>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="employees.php" style="color: black;">Employees</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)" style="color: black;">Add</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->


                <div class="row">
                    <div class="col-12">
                        <div class="card" style="border: solid; border-color: black;">
                            <div class="card-header">
                                <h4 class="card-title">Add Employee</h4>
                                <!-- <span>
                                    <button class="btn btn-success" onclick="document.location.href='course-year-add.php'">Add Course</button>
                                </span> -->
                            </div>
                            <div class="card-body">
                                <form method="post" role="form" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="basic-form">
                                            <div class="form-row">
                                                <div class="col-sm-4">
                                                    <label style="color: black;">ID Number</label>
                                                    <input style="border-color: black; "type="text" class="form-control" value="<?php print $fetchEmployees["emp_number"]; ?>" name="Code">
                                                </div>
                                                <div class="col-sm-8">
                                                    <label style="color: black">Name</label>
                                                    <input style="border-color: black; " type="text" class="form-control" value="<?php print $fetchEmployees["emp_name"]; ?>" name="Name" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-sm-4">
                                                    <label style="color: black;">Position</label>
                                                    <select class="form-control" name="Position" style="border-color: black;" required>
                                                        <option value="<?php print $fetchEmployees["emp_position_id"]; ?>" selected>
                                                            <?php 
                                                                $EPI = $fetchEmployees["emp_position_id"]; 
                                                                $sqlPosition = "SELECT * FROM position_tbl WHERE pos_id = '$EPI'";
                                                                $queryPosition = mysqli_query($dbConString, $sqlPosition);
                                                                $fetchPosition = mysqli_fetch_assoc($queryPosition);
                                                                print $fetchPosition['pos_name'];
                                                            ?>
                                                        </option>
                                                        <?php
                                                            $sqlPosition = mysqli_query($dbConString, "SELECT pos_id, pos_name FROM position_tbl WHERE pos_isdel = 0");  // Use select query here 

                                                            while($data = mysqli_fetch_array($sqlPosition))
                                                            {
                                                                echo "<option value='". $data['pos_id'] ."'>" .$data['pos_name'] ."</option>";  // displaying data in option menu //first id second display
                                                            }	
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label style="color: black">Email</label>
                                                    <input style="border-color: black; " type="email" class="form-control" value="<?php print $fetchEmployees["emp_email"]; ?>" name="Email" required>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label style="color: black">Contact Number</label>
                                                    <input style="border-color: black; " type="text" class="form-control" value="<?php print $fetchEmployees["emp_contact"]; ?>" name="Contact" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-sm-7">
                                                    <label style="color: black;">Address</label>
                                                    <input style="border-color: black; " type="text" class="form-control" name="Address" value="<?php print $fetchEmployees["emp_address"]; ?>" >
                                                </div>
                                                <div class="col-sm-5">
                                                    <label style="color: black;">Image</label>
                                                        <div class="control-group file-upload" id="file-upload">
                                                            <div class="image-box text-center" style="border-style: groove; border-color: black;">
                                                                <p style="padding-top: 2%; color: black;"><i class="fa fa-upload"></i> UPLOAD</p>
                                                                <img src="image/<?php print $fetchEmployees["emp_image"]; ?>" alt="" style="width: 200px; height: 200px;">
                                                            </div>
                                                            <div class="controls" style="display: none;">
                                                                    <input type="file" name="fileUpload" value="<?php print $fetchEmployees["emp_image"]; ?>">
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer" style="text-align: right;">
                                        <button class="btn btn-primary" type="submit" name="btnSave">SAVE</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        <?php include 'body/footer.php'; ?>
        <!--**********************************
            Footer end
        ***********************************-->

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <?php include 'body/scripts.php'; ?>
    <script>
        $(".image-box").click(function(event) {
            var previewImg = $(this).children("img");

            $(this)
                .siblings()
                .children("input")
                .trigger("click");

            $(this)
                .siblings()
                .children("input")
                .change(function() {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var urll = e.target.result;
                        $(previewImg).attr("src", urll);
                        previewImg.parent().css("background", "transparent");
                        previewImg.show();
                        previewImg.siblings("p").hide();
                    };
                    reader.readAsDataURL(this.files[0]);
                });
        });
    </script>

</body>

</html>