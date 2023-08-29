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
                            <h4 style="color: black;">SALES REPORTS</h4>
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
                            <div class="card-header">
                                <h4 class="card-title">Sales Reports</h4>
                                <!-- <span>
                                    <button class="btn btn-success" onclick="document.location.href='products-add.php'">Add New</button>
                                </span> -->
                            </div>
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
                                                $sqlOrder = "SELECT * FROM order_tbl WHERE order_isdel = 0 AND order_users_id = '$UID'";
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