<?php
    include 'db-controller.php';
    session_start();

    if(!(isset($_SESSION["users_id"]))) {
        header("location: default.php");
    }
    $UID = $_SESSION["users_id"];
    $id = $_GET['id'];
    $sqlCustomer = "SELECT * FROM customers_tbl WHERE cus_id = '$id'";
    $queryCustomer = mysqli_query($dbConString, $sqlCustomer);
    $fetchCustomer = mysqli_fetch_assoc($queryCustomer);
    
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
                    <div class="col-7">
                        <div class="card" style="border: solid; border-color: black;">
                            <div class="card-body">
                                <form method="post" role="form" enctype="multipart/form-data">
                                    <div class="card-body" style="padding-bottom: 0px;">
                                        <div class="basic-form" >
                                            <div class="form-row">
                                                <div class="col-sm-3">
                                                    <label style="color: black">Customer Id:</label>
                                                    <h3 style="color: black;"><?php print "CI-00".''.$fetchCustomer['cus_id']; ?></h3>
                                                </div>
                                                <div class="col-sm-9">
                                                    <label style="color: black">Name:</label>
                                                    <h3 style="color: black;"><?php print $fetchCustomer['cus_name']; ?></h3>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-sm-7">
                                                    <label style="color: black">Email:</label>
                                                    <h3 style="color: black;">
                                                        <?php 
                                                            if($fetchCustomer['cus_email'] == ''){
                                                                print 'No email address';
                                                            }else{
                                                                print $fetchCustomer['cus_email'];
                                                            }
                                                        ?>
                                                    </h3>
                                                </div>
                                                <div class="col-sm-5">
                                                    <label style="color: black">Contact:</label>
                                                    <h3 style="color: black;">
                                                        <?php 
                                                            if($fetchCustomer['cus_phone'] == ''){
                                                                print 'No Contact Number';
                                                            }else{
                                                                print $fetchCustomer['cus_phone'];
                                                            }
                                                        ?>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-sm-12">
                                                    <label style="color: black">Address:</label>
                                                    <h3 style="color: black;">
                                                        <?php 
                                                            if($fetchCustomer['cus_address'] == ''){
                                                                print 'No address';
                                                            }else{
                                                                print $fetchCustomer['cus_address'];
                                                            }
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