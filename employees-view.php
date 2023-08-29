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
                            <li class="breadcrumb-item active" ><a href="javascript:void(0)" style="color: black;">View</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->


                <div class="row">
                    <div class="col-7">
                        <div class="card" style="border: solid; border-color: black;">
                            <div class="card-body">
                                <form method="post" role="form" enctype="multipart/form-data">
                                    <div class="card-body" style="padding-bottom: 0px;">
                                        <div class="basic-form" >
                                            <div class="form-row">
                                                <div class="col-sm-3">

                                                </div>
                                                <div class="col-sm-6" style="text-align: center">
                                                    <img src="image/<?php print $fetchEmployees["emp_image"]; ?>" alt="" style="width: 200px; height: 200px; border-color: black;">
                                                </div>
                                                <div class="col-sm-3">

                                                </div>
                                            </div>
                                            <br>
                                            <div class="form-row">
                                                <div class="col-sm-5">
                                                    <label style="color: black">ID Number:</label>
                                                    <h3 style="color: black;"><?php print $fetchEmployees['emp_number']; ?></h3>
                                                </div>
                                                <div class="col-sm-7">
                                                    <label style="color: black">Name:</label>
                                                    <h3 style="color: black;"><?php print $fetchEmployees['emp_name']; ?></h3>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-sm-5">
                                                    <label style="color: black">Position:</label>
                                                    <h3 style="color: black;">
                                                        <?php 
                                                            $EPI = $fetchEmployees['emp_position_id']; 
                                                            $sqlPosition = "SELECT * FROM position_tbl WHERE pos_id = '$EPI'";
                                                            $queryPosition = mysqli_query($dbConString, $sqlPosition);
                                                            $fetchPosition = mysqli_fetch_assoc($queryPosition);
                                                            print $fetchPosition['pos_name'];
                                                        ?>
                                                    </h3>
                                                </div>
                                                <div class="col-sm-7">
                                                    <label style="color: black">Address:</label>
                                                    <h3 style="color: black;">
                                                        <?php 
                                                            print $fetchEmployees['emp_address'];
                                                        ?>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-sm-6">
                                                    <label style="color: black">Email:</label>
                                                    <h3 style="color: black;">
                                                        <?php 
                                                            print $fetchEmployees['emp_email'];
                                                        ?>
                                                    </h3>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label style="color: black">Contact:</label>
                                                    <h3 style="color: black;">
                                                        <?php 
                                                            print $fetchEmployees['emp_contact'];
                                                        ?>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
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