<?php
    include 'db-controller.php';
    session_start();

    if(!(isset($_SESSION["users_id"]))) {
        header("location: default.php");
    }
    $UID = $_SESSION["users_id"];
    $sqlUsers = "SELECT * FROM users_tbl WHERE users_id = '$UID'";
    $queryUsers = mysqli_query($dbConString, $sqlUsers);
    $fetchUsers = mysqli_fetch_assoc($queryUsers);


    $sdate = $_GET['sdate'];
    $edate = $_GET['edate'];

    // Items Sold
    $sqlCountItems = "SELECT SUM(cart_qty) AS TOTALCOUNTITEMS FROM cart_tbl WHERE cart_users_id = '$UID' AND cart_datecreated BETWEEN '$sdate' AND '$edate'
    AND cart_status ='Paid'";
    $queryCountItems = mysqli_query($dbConString, $sqlCountItems);
    $fetchCountItems = mysqli_fetch_assoc($queryCountItems);

    $ITEMSSOLD = $fetchCountItems['TOTALCOUNTITEMS'];

    // Total Amount
    $sqlTotalAmount = "SELECT SUM(order_totalamount) AS TOTALAMOUNT FROM order_tbl WHERE order_users_id = '$UID' AND order_datecreated BETWEEN '$sdate' AND '$edate'
    AND order_status ='PAID'";
    $queryTotalAmount = mysqli_query($dbConString, $sqlTotalAmount);
    $fetchTotalAmount = mysqli_fetch_assoc($queryTotalAmount);
 
    $TOTALAMOUNT = $fetchTotalAmount['TOTALAMOUNT'];

    // Total Discounted
    $sqlTotalDiscount = "SELECT SUM(order_totaldiscount) AS TOTALDISCOUNT FROM order_tbl WHERE order_users_id = '$UID' AND order_datecreated BETWEEN '$sdate' AND '$edate'
    AND order_status ='PAID'";
    $queryTotalDiscount = mysqli_query($dbConString, $sqlTotalDiscount);
    $fetchTotalDiscount = mysqli_fetch_assoc($queryTotalDiscount);
 
    $TOTALDISCOUNT = $fetchTotalDiscount['TOTALDISCOUNT'];

    $CASHSALES = $TOTALAMOUNT - $TOTALDISCOUNT;


    if(isset($_POST['btnSearch'])) {
        $txtSDate = $_POST['SDate'];
        $txtEDate = $_POST['EDate'];
        
        header("location: monthly-sales-result.php?sdate=".''.$txtSDate.''."&edate=".$txtEDate);
    }

    //Cost Dine In
    $sqlTotalDineCost = "SELECT SUM(cart_dine) AS TOTALDINECOST FROM cart_tbl WHERE cart_users_id = '$UID' AND cart_datecreated BETWEEN '$sdate' AND '$edate'
    AND cart_status ='Paid' AND cart_order_type = 'Dine In'";
    $queryTotalDineCost = mysqli_query($dbConString, $sqlTotalDineCost);
    $fetchTotalDineCost = mysqli_fetch_assoc($queryTotalDineCost);

    //Cost Take Out
    $sqlTotalTakeCost = "SELECT SUM(cart_take) AS TOTALTAKECOST FROM cart_tbl WHERE cart_users_id = '$UID' AND cart_datecreated BETWEEN '$sdate' AND '$edate'
    AND cart_status ='Paid' AND cart_order_type = 'Take Out'";
    $queryTotalTakeCost = mysqli_query($dbConString, $sqlTotalTakeCost);
    $fetchTotalTakeCost = mysqli_fetch_assoc($queryTotalTakeCost);

    $TOTALCOST = $fetchTotalDineCost['TOTALDINECOST'] + $fetchTotalTakeCost['TOTALTAKECOST'];

    $PROFIT = $CASHSALES - $TOTALCOST;

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
                            <h4 style="color: black;">MONTHLY SALES REPORTS</h4>
                            <span class="ml-1" style="color: black;">Reports</span>
                            
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php" style="color: black;">Reports</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)" style="color: black;">Sales</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card" style="border: solid; border-color: black;">
                            <div class="card-body">
                                <form method="post" role="form" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="col-sm-3">
                                            
                                        </div>
                                        <div class="col-sm-2">
                                            <label style="color: black">Start Date:</label>
                                            <input style="border-color: black; " type="date" class="form-control" name="SDate" required>
                                        </div>
                                        <div class="col-sm-2">
                                            <label style="color: black">End Date:</label>
                                            <input style="border-color: black; " type="date" class="form-control" name="EDate" required>
                                        </div>
                                        <div class="col-sm-2">
                                            <label style="color: black">Action:</label><br>
                                            <button class="btn btn-primary" style="width: 100%" type="subtmit" name="btnSearch">SEARCH</button>
                                        </div>
                                        <div class="col-sm-3">
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="card" style="border: solid; border-color: black;">
                            <div class="card-body">
                                <div class="basic-form" >
                                    <div class="form-row">
                                        <div class="col-sm-3">

                                        </div>
                                        <div class="col-sm-6" style="text-align: center">
                                            <h1 style="color: black;">Sales</h1>
                                        </div>
                                        <div class="col-sm-3">

                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-row">
                                        <div class="col-sm-12">
                                            <span style="float:left;"><p style="color: black;">Date:</p></span><span style="float: right;"><h3 style="color: black;"><strong><?php print $sdate.' to '.$edate; ?></strong></h3></span>  
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
                                    <div class="form-row">
                                        <div class="col-sm-6">
                                            <span style="float:left;"><p style="color: black;">Cost (Dine In):</p></span><span style="float: right;"><h3 style="color: black;"><strong><?php print "₱".''.$fetchTotalDineCost['TOTALDINECOST']; ?></strong></h3></span>  
                                        </div>
                                        <div class="col-sm-6">
                                            <span style="float:left;"><p style="color: black;">Cost (Take Out):</p></span><span style="float: right;"><h3 style="color: black;"><strong><?php print "₱".''.$fetchTotalTakeCost['TOTALTAKECOST']; ?></strong></h3></span>  
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-row">
                                        <div class="col-sm-12">
                                            <span style="float:left;"><p style="color: black;">Total Sales:</p></span><span style="float: right;"><h3 style="color: black;"><strong><?php print "₱".''.$CASHSALES; ?></strong></h3></span>  
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-sm-12">
                                            <span style="float:left;"><p style="color: black;">Total Cost:</p></span><span style="float: right;"><h3 style="color: black;"><strong><u><?php print "₱".''.$TOTALCOST; ?></u></strong></h3></span>  
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-sm-12">
                                            <span style="float:left;"><p style="color: black;">Profit:</p></span><span style="float: right;"><h3 style="color: red;"><strong><?php print "₱".''.$PROFIT; ?></strong></h3></span>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card" style="border: solid; border-color: black;">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Customer</th>
                                                <th>Amount</th>
                                                <th>Tax</th>
                                                <th>Discount</th>
                                                <th>Total</th>
                                                <th>Paid</th>
                                                <th>Change</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sqlOrder = "SELECT * FROM order_tbl WHERE order_isdel = 0 AND order_users_id = '$UID' AND order_status ='PAID' AND order_datecreated BETWEEN '$sdate' AND '$edate' ";
                                                $queryOrder = mysqli_query($dbConString, $sqlOrder);
                                                while($fetchOrder = mysqli_fetch_assoc($queryOrder)) {
                                                    // $STAT = $fetchProducts["prod_isactive"];
                                            ?>
                                            <tr>
                                                <td style="color: black;"><?php print $fetchOrder["order_datecreated"] ?></td>
                                                <td style="color: black;">
                                                    <?php 
                                                        if($fetchOrder['order_cus_id'] == '0'){
                                                            print 'Walk-In';
                                                        }else{
                                                            $OCI = $fetchOrder['order_cus_id'];
                                                            $sqlCustomer = "SELECT * FROM customers_tbl WHERE cus_id = '$OCI'";
                                                            $queryCustomer = mysqli_query($dbConString, $sqlCustomer);
                                                            $fetchCustomer = mysqli_fetch_assoc($queryCustomer);

                                                            print $fetchCustomer["cus_name"];
                                                        }
                                                    ?>
                                                </td>
                                                <td style="color: black;">
                                                    <?php 
                                                        $OT = $fetchOrder["order_totalamount"];
                                                        $TAX = $fetchOrder["order_tax"];

                                                        print "₱".''.$TOTALAMOUNT = $OT - $TAX;
                                                    ?>
                                                </td>
                                                <td style="color: black;"><?php print "₱".''.$fetchOrder["order_tax"] ?></td>
                                                <td style="color: black;"><?php print "₱".''.$fetchOrder["order_totaldiscount"] ?></td>
                                                <td style="color: black;"><?php print "₱".''.$fetchOrder["order_totalamount"] ?></td>
                                                <td style="color: black;"><?php print "₱".''.$fetchOrder["order_cash"] ?></td>
                                                <td style="color: black;"><?php print "₱".''.$fetchOrder["order_change"] ?></td>
                                                <td style="color: black;"><?php print $fetchOrder["order_status"] ?></td>
                                            </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Date</th>
                                                <th>Customer</th>
                                                <th>Amount</th>
                                                <th>Tax</th>
                                                <th>Discount</th>
                                                <th>Total</th>
                                                <th>Paid</th>
                                                <th>Change</th>
                                                <th>Status</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
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