<?php
    include 'db-controller.php';
    session_start();

    if(!(isset($_SESSION["users_id"]))) {
        header("location: default.php");
    }
    $UID = $_SESSION["users_id"];

    $date = date("l m-d-Y");
    $cartdate = date("Y-m-d");

    // Items Sold
    $sqlCountItems = "SELECT SUM(cart_qty) AS TOTALCOUNTITEMS FROM cart_tbl WHERE cart_users_id = '$UID' AND cart_datecreated = '$cartdate'
    AND cart_status ='Paid'";
    $queryCountItems = mysqli_query($dbConString, $sqlCountItems);
    $fetchCountItems = mysqli_fetch_assoc($queryCountItems);

    $ITEMSSOLD = $fetchCountItems['TOTALCOUNTITEMS'];

    // Total Amount
    $sqlTotalAmount = "SELECT SUM(order_totalamount) AS TOTALAMOUNT FROM order_tbl WHERE order_users_id = '$UID' AND order_datecreated = '$cartdate'
    AND order_status ='PAID'";
    $queryTotalAmount = mysqli_query($dbConString, $sqlTotalAmount);
    $fetchTotalAmount = mysqli_fetch_assoc($queryTotalAmount);
 
    $TOTALAMOUNT = $fetchTotalAmount['TOTALAMOUNT'];

    // Total Discounted
    $sqlTotalDiscount = "SELECT SUM(order_totaldiscount) AS TOTALDISCOUNT FROM order_tbl WHERE order_users_id = '$UID' AND order_datecreated = '$cartdate'
    AND order_status ='PAID'";
    $queryTotalDiscount = mysqli_query($dbConString, $sqlTotalDiscount);
    $fetchTotalDiscount = mysqli_fetch_assoc($queryTotalDiscount);
 
    $TOTALDISCOUNT = $fetchTotalDiscount['TOTALDISCOUNT'];

    $CASHSALES = $TOTALAMOUNT - $TOTALDISCOUNT;
    
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
                            <h4 style="color: black;">TODAY'S SALES</h4>
                            <span class="ml-1" style="color: black;">Dashboard</span>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php" style="color: black;">Sales</a></li>
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
                                <form method="post" role="form" enctype="multipart/form-data">
                                    <div class="card-body" style="padding-bottom: 0px;">
                                        <div class="basic-form" >
                                            <div class="form-row">
                                                <div class="col-sm-3">

                                                </div>
                                                <div class="col-sm-6" style="text-align: center">
                                                    <h1 style="color: black;">Today's Sales</h1>
                                                </div>
                                                <div class="col-sm-3">

                                                </div>
                                            </div>
                                            <br>
                                            <div class="form-row">
                                                <div class="col-sm-12">
                                                    <span style="float:left;"><p style="color: black;">Date:</p></span><span style="float: right;"><h3 style="color: black;"><strong><?php print $date; ?></strong></h3></span>  
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-sm-12">
                                                    <span style="float:left;"><p style="color: black;">Items Sold:</p></span><span style="float: right;"><h3 style="color: black;"><strong><?php print $ITEMSSOLD; ?></strong></h3></span>  
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-sm-12">
                                                    <span style="float:left;"><p style="color: black;">Cash Sales:</p></span><span style="float: right;"><h3 style="color: black;"><strong><?php print "₱".''.$CASHSALES; ?></strong></h3></span>  
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-sm-12">
                                                    <span style="float:left;"><p style="color: black;">Card Sales:</p></span><span style="float: right;"><h3 style="color: black;"><strong>₱0</strong></h3></span>  
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-sm-12">
                                                    <span style="float:left;"><p style="color: black;">E-Pay Sales:</p></span><span style="float: right;"><h3 style="color: black;"><strong>₱0</strong></h3></span>  
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-sm-12">
                                                    <span style="float:left;"><p style="color: black;">Gift Card Sales:</p></span><span style="float: right;"><h3 style="color: black;"><strong>₱0</strong></h3></span>  
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-row">
                                                <div class="col-sm-12">
                                                    <span style="float:left;"><p style="color: black;">Total Sales:</p></span><span style="float: right;"><h3 style="color: black;"><strong><?php print "₱".''.$CASHSALES; ?></strong></h3></span>  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-3">

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