<?php
    include 'db-controller.php';
    session_start();

    if(!(isset($_SESSION["users_id"]))) {
        header("location: default.php");
    }
    $UID = $_SESSION["users_id"];
    error_reporting(E_ERROR);
    if(isset($_POST['btnEnter'])) {
        $txtIDNumber = $_POST['IDNumber'];
        $date = date('Y-m-d');

        $sqlEmployee = "SELECT * FROM employees_tbl WHERE emp_number = '$txtIDNumber'";
        $queryEmployee = mysqli_query($dbConString, $sqlEmployee);
        $fetchEmployee = mysqli_fetch_assoc($queryEmployee);
        $IdNumber = $fetchEmployee['emp_number'];

        if($IdNumber == ''){
            $message = "Invalid id number. Please try again.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }else{
            $sqlCheck = "SELECT emp_number FROM employees_tbl WHERE emp_number = '$IdNumber' AND emp_position_id = '1' OR emp_position_id = '2' OR emp_position_id = '3'";
            $queryCheck = mysqli_query($dbConString, $sqlCheck);

            if(mysqli_num_rows($queryCheck) > 0){
                header("location: employees.php");
            }else{
                $message = "Use the Managers ID Number. Please try again.";
                echo "<script type='text/javascript'>alert('$message');</script>";
                
            }
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
                            <h4 style="color: black;">CUSTOMERS</h4>
                            <span class="ml-1" style="color: black;">Inventory</span>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php" style="color: black;">Customers</a></li>
                            <li class="breadcrumb-item active" ><a href="javascript:void(0)" style="color: black;">View</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->


                <div class="row">
                    <div class="col-3">

                    </div>
                    <div class="col-6">
                        <div class="card" style="border: solid; border-color: black;">
                            <div class="card-body">
                            <h5 style="color: black;">Enter Manager's Id Number to access the employee list.</h5>
                                <form method="post" role="form" enctype="multipart/form-data">
                                    <div class="card-body" style="padding-bottom: 0px;">
                                        <div class="basic-form" >
                                            <div class="form-row">
                                                <div class="col-sm-2">

                                                </div>
                                                <div class="col-sm-8">
                                                    <label style="color: black;" >ID Number</label>
                                                    <input style="border-color: black;" type="password" class="form-control" name="IDNumber" required autofocus>
                                                    <button type="submit" name="btnEnter"class="btn btn-primary" style="width: 100%; margin-top: 5px;">ENTER</button>
                                                    <p style="color: red;">Note: Enter the id number of store manager to void.</p>
                                                </div>
                                                <div class="col-sm-2">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="col-3">

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