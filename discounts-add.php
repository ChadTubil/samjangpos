<?php
    include 'db-controller.php';
    session_start();

    if(!(isset($_SESSION["users_id"]))) {
        header("location: default.php");
    }
    $UID = $_SESSION["users_id"];
    if(isset($_POST['btnSave'])) {
        $txtName = $_POST['Name'];
        $txtDiscount = $_POST['Discount'];
        $txtDescription = $_POST['Description'];
        $date = date('Y-m-d');

        $sqlCheck = "SELECT disc_name FROM discount_tbl WHERE disc_name = '$txtName' AND disc_users_id = '$UID'";
        $queryCheck = mysqli_query($dbConString, $sqlCheck);

        if(mysqli_num_rows($queryCheck) > 0){
            $message = "Discount is already exists. Please try enter another discount.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }else{
            $sqlAdd = "INSERT INTO discount_tbl() VALUES (NULL, '$UID', '$txtName', '$txtDescription', '$txtDiscount', '$date', 0)";
            mysqli_query($dbConString, $sqlAdd);

            header("location: discounts.php");
        }
    }

    if(isset($_POST['btnSA'])) {
        $txtName = $_POST['Name'];
        $txtDiscount = $_POST['Discount'];
        $txtDescription = $_POST['Description'];
        $date = date('Y-m-d');

        $sqlCheck = "SELECT disc_name FROM discount_tbl WHERE disc_name = '$txtName' AND disc_users_id = '$UID'";
        $queryCheck = mysqli_query($dbConString, $sqlCheck);

        if(mysqli_num_rows($queryCheck) > 0){
            $message = "Discount is already exists. Please try enter another discount.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }else{
            $sqlAdd = "INSERT INTO discount_tbl() VALUES (NULL, '$UID', '$txtName', '$txtDescription', '$txtDiscount', '$date', 0)";
            mysqli_query($dbConString, $sqlAdd);

            header("location: discounts-add.php");
        }
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
                            <h4 style="color: black;">DISCOUNTS</h4>
                            <span class="ml-1" style="color: black;">Inventory</span>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php" style="color: black;">Discounts</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)" style="color: black;">Add</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->


                <div class="row">
                    <div class="col-12">
                        <div class="card" style="border: solid; border-color: black;">
                            <div class="card-header">
                                <h4 class="card-title">Add Discount</h4>
                                <!-- <span>
                                    <button class="btn btn-success" onclick="document.location.href='course-year-add.php'">Add Course</button>
                                </span> -->
                            </div>
                            <div class="card-body">
                                <form method="post" role="form" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="basic-form">
                                            <div class="form-row">
                                                <div class="col-sm-6">
                                                    <label style="color: black;">Name</label>
                                                    <input style="border-color: black; "type="text" class="form-control" placeholder="Discount Name" name="Name" required>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label style="color: black">Discount</label>
                                                    <select class="form-control" name="Discount" style="border-color: black;" required>
                                                        <option value=".10">10%</option>
                                                        <option value=".15">15%</option>
                                                        <option value=".20">20%</option>
                                                        <option value=".30">30%</option>
                                                        <option value=".50">50%</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-sm-12">
                                                    <label style="color: black;">Description</label>
                                                    <textarea style="border-color: black; "type="text" class="form-control" name="Description"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer" style="text-align: right;">
                                        <button class="btn btn-primary"  type="submit" name="btnSA">SAVE & ADD</button>
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

</body>

</html>