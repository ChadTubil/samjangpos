<?php
    include 'db-controller.php';
    session_start();

    if(!(isset($_SESSION["users_id"]))) {
        header("location: default.php");
    }
    $UID = $_SESSION["users_id"];
    error_reporting(E_ERROR);
    $sqlCartTotalItems = "SELECT SUM(cart_qty) AS TOTALITEMS FROM cart_tbl WHERE cart_users_id = '$UID' AND cart_status = 'New Order' AND cart_isdel = 0";
    $queryCartTotalItems = mysqli_query($dbConString, $sqlCartTotalItems);
    $fetchCartTotalItems = mysqli_fetch_assoc($queryCartTotalItems);
    $CARTTOTALITEMS = $fetchCartTotalItems['TOTALITEMS'];

    $sqlCartTotalPayable = "SELECT SUM(cart_amount) AS TOTALAMOUNT FROM cart_tbl WHERE cart_users_id = '$UID' AND cart_status = 'New Order' AND cart_isdel = 0";
    $queryCartTotalPayable = mysqli_query($dbConString, $sqlCartTotalPayable);
    $fetchCartTotalPayable = mysqli_fetch_assoc($queryCartTotalPayable);
    $CARTTOTALPAYABLE = $fetchCartTotalPayable['TOTALAMOUNT'];
    $AMOUNTTAX = '0.03';
    $TOTALSOLVETAX = $CARTTOTALPAYABLE * $AMOUNTTAX;

    $sqlDiscount = "SELECT SUM(cart_discount) AS TOTALDISCOUNT FROM cart_tbl WHERE cart_users_id = '$UID'  AND cart_status = 'New Order' AND cart_isdel = 0";
    $queryDiscount = mysqli_query($dbConString, $sqlDiscount);
    $fetchDiscount = mysqli_fetch_assoc($queryDiscount);
    $CARTDISCOUNT = $fetchDiscount['TOTALDISCOUNT'];

    $TOTALPAYABLE = $CARTTOTALPAYABLE - $CARTDISCOUNT;

    $sqlCheckOrder = "SELECT COUNT(order_number) AS TOTALCOUNTNUMBER FROM order_tbl WHERE order_users_id = '$UID'";
    $queryCheckOrder = mysqli_query($dbConString, $sqlCheckOrder);
    $fetchCheckOrder = mysqli_fetch_assoc($queryCheckOrder);
    $ON = $fetchCheckOrder['TOTALCOUNTNUMBER'];
    $Plus = '1';

    $NewOrderNumber = $ON + $Plus;

    // Insert Customer
    if(isset($_POST['btnSave'])) {
        $txtName = $_POST['Name'];
        $txtContact = $_POST['Contact'];
        $txtEmail = $_POST['Email'];
        $txtAddress = $_POST['Address'];
        $date = date('Y-m-d');

        $sqlCheck = "SELECT cus_name FROM customers_tbl WHERE cus_name = '$txtName' AND cus_users_id = '$UID'";
        $queryCheck = mysqli_query($dbConString, $sqlCheck);

        if(mysqli_num_rows($queryCheck) > 0){
            $message = "Customer is already exists. Please try again.";
            echo "<script type='text/javascript'>alert('$message');</script>";
            header("location: pos.php");
              
        }else{
           $sqlAdd = "INSERT INTO customers_tbl() VALUES (NULL, '$UID', '$txtName', '$txtContact', '$txtEmail',
            '$txtAddress', '$date', 0)";
            mysqli_query($dbConString, $sqlAdd);

            header("location: pos-payment-cash.php");
        }
    }
    // Payment
    if(isset($_POST['btnSubmit'])) {
        $txtCash = $_POST['Cash'];
        $txtCustomer = $_POST['Customer'];
        $txtType = $_POST['Type'];
        $date = date('Y-m-d');

        $CHANGE = $txtCash -$TOTALPAYABLE;

        $sqlAdd = "INSERT INTO order_tbl() VALUES (NULL, '$NewOrderNumber', '$UID', '$txtCustomer', '$date',
        '$CARTTOTALPAYABLE', '$CARTDISCOUNT', '$TOTALSOLVETAX', '$txtCash', '$CHANGE', '$txtType', 'PAID', 0)";
        mysqli_query($dbConString, $sqlAdd);

        $sqlUpdateCart = "UPDATE cart_tbl SET cart_status = 'Paid', cart_isdel = 1, cart_order_type = '$txtType' WHERE cart_users_id = '$UID' AND cart_status = 'New Order' AND cart_isdel = 0";
        mysqli_query($dbConString, $sqlUpdateCart);

        header("location: pos-payment-change.php?change=$CHANGE");
    }
    

?>

<!DOCTYPE html>
<html lang="en">

    <?php include 'body/head.php'; ?>
    <style>
        * {box-sizing: border-box;}

        body { 
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .header1 {
            overflow: hidden;
            background-color: white;
            padding: 20px 10px;
        }

        .header1 a {
            float: left;
            color: black;
            text-align: center;
            padding: 12px;
            text-decoration: none;
            font-size: 18px; 
            line-height: 25px;
            border-radius: 4px;
        }

        .header1 a.logo {
            font-size: 25px;
            font-weight: bold;
        }

        .header1 a:hover {
            background-color: #ddd;
            color: black;
        }

        .header1 a.active {
            background-color: dodgerblue;
            color: white;
        }

        .header-right {
            float: right;
        }

        @media screen and (max-width: 500px) {
            .header1 a {
                float: none;
                display: block;
                text-align: left;
            }
        
            .header-right {
                float: none;
            }
        }
    </style>
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
    <!--**********************************
        Header
    ***********************************-->
    <div class="header1" style="padding-top: 0px; padding-bottom: 0px; padding-left: 20px;">
        <a href="#default" class="logo"><img src="image/Logo.png" alt="" style="width: 100%; height: 60px; "></a>
        <div class="header-right" style="padding-top: 20px;">
            <!-- <a class="active" href="#home">Home</a>
            <a href="#contact">Contact</a> -->
            
            <a href="#" style="font-size: 16pt;"><strong><i class="ti-dashboard"></i></strong></a>
            <a href="#" style="font-size: 16pt;"><strong><i class="ti-key"></i></strong></a>
            <a href="#about">Close Register</a>
        </div>
    </div>
    <!--**********************************
        Header end
    ***********************************-->

    <!--**********************************
        Content body start
    ***********************************-->
    <div style="padding: 10px;">
        <div class="row">
            <div class="col-lg-3 col-sm-6">

            </div>
            <div class="col-lg-6 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h4><?php print "ORDER #".''.$NewOrderNumber; ?></strong></h4>
                        <br>
                        <form method="post" role="form" enctype="multipart/form-data">
                            <div style="padding-bottom: 5px;" class="input-group">
                                <select class="form-control" name="Customer" style="border-color: black;">
                                    <option value="0" selected>Walk-in Client</option>
                                    <?php
                                        $sqlCustomer = mysqli_query($dbConString, "SELECT cus_id, cus_name FROM customers_tbl WHERE cus_isdel = 0 AND cus_users_id = $UID");  // Use select query here 
                                        while($data = mysqli_fetch_array($sqlCustomer)){
                                            echo "<option value='". $data['cus_id'] ."'>" .$data['cus_name'] ."</option>";  // displaying data in option menu //first id second display
                                        }	
                                    ?>
                                </select>
                                <span class="input-group-addon">
                                    <button type="button" class="btn" style="border-color: black; text-align: center; color: black; border-radius: 0px; 
                                    border-top-right-radius: 4px; border-bottom-right-radius: 4px;" data-toggle="modal" data-target="#exampleModalCenter"
                                    accesskey="c">
                                        <i class="ti-plus"></i>
                                    </button>
                                    
                                </span>
                            </div>
                            <div style="padding-bottom: 5px;" class="input-group">
                                <select class="form-control" name="Type" style="border-color: black;">
                                    <option value="Dine In" selected>Dine In</option>
                                    <option value="Take Out">Take Out</option>
                                </select>
                            </div>
                            <br>
                            <br>
                            <table class="table">
                                <tbody style="width: 100%;">
                                    <tr>
                                        <td style="color: black;">Total Items</td>
                                        <td style="color: black;">
                                            <?php
                                                $sqlCountItems = "SELECT SUM(cart_qty) AS TOTALCOUNTITEMS FROM cart_tbl WHERE cart_users_id = '$UID' AND cart_status = 'New Order' AND cart_isdel = 0";
                                                $queryCountItems = mysqli_query($dbConString, $sqlCountItems);
                                                $fetchCountItems = mysqli_fetch_assoc($queryCountItems);

                                                print $fetchCountItems['TOTALCOUNTITEMS'];
                                            ?>
                                        </td>
                                        <td style="color: black;">Total Amount</td>
                                        <td style="color: black;">
                                            <?php
                                                $sqlAmountItems = "SELECT SUM(cart_amount) AS TOTALAMOUNTITEMS FROM cart_tbl WHERE cart_users_id = '$UID' AND cart_status = 'New Order' AND cart_isdel = 0";
                                                $queryAmountItems = mysqli_query($dbConString, $sqlAmountItems);
                                                $fetchAmountItems = mysqli_fetch_assoc($queryAmountItems);

                                                $TOTALAMOUNTWOTAX = $fetchAmountItems['TOTALAMOUNTITEMS'];
                                                $AMOUNTTAX = '0.03';
                                                $TOTALTAXAMOUNT = $TOTALAMOUNTWOTAX * $AMOUNTTAX;
                                                $TOTALAMOUNTWTAX = $TOTALAMOUNTWOTAX - $TOTALTAXAMOUNT;
                                                print "₱".''.$TOTALAMOUNTWTAX;
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: black;">Discount</td>
                                        <td style="color: black;">
                                            <?php
                                                $sqlDiscount = "SELECT SUM(cart_discount) AS TOTALDISCOUNT FROM cart_tbl WHERE cart_users_id = '$UID' AND cart_status = 'New Order' AND cart_isdel = 0";
                                                $queryDiscount = mysqli_query($dbConString, $sqlDiscount);
                                                $fetchDiscount = mysqli_fetch_assoc($queryDiscount);

                                                
                                                if($fetchDiscount['TOTALDISCOUNT'] == 0){
                                                    print "₱0";
                                                }else{
                                                    print "₱".''.$fetchDiscount['TOTALDISCOUNT'];
                                                }
                                            ?>
                                        </td>
                                        <td style="color: black;">Tax Included</td>
                                        <td style="color: black;">
                                            <?php
                                                $TOTALAMOUNTTAX = $fetchAmountItems['TOTALAMOUNTITEMS'];
                                                $TAX = '0.03';
                                                print "₱".''.$TOTALTAX = $TOTALAMOUNTTAX * $TAX;
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: black;">Total Payable</td>
                                        <td style="color: black;"></td>
                                        <td style="color: black;"></td>
                                        <td style="color: black;">
                                            <?php
                                                $TOTALAMOUNT = $fetchAmountItems['TOTALAMOUNTITEMS'];
                                                $TOTALDISCOUNT = $fetchDiscount['TOTALDISCOUNT'];
                                                
                                                print "₱".''.$TOTALPAYABLE = $TOTALAMOUNT - $TOTALDISCOUNT;
                                            ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <label style="color: black;">Amount:</label>
                                    <input style="border-color: black; "type="text" class="form-control" placeholder="Cash" name="Cash" required autofocus>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div style="padding-bottom: 5px;">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" name="btnSubmit" class="btn btn-success" style="width: 100%; height: 50px;">SUBMIT</button>
                                    </div>
                                    <div class="col-6">
                                        <button onclick="document.location.href='pos.php'" class="btn btn-danger" style="width: 100%; height: 50px;">CANCEL</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form method="post" role="form" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Customer</h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <label style="color: black;">Name:</label>
                                    <input style="border-color: black; "type="text" class="form-control" placeholder="Name" name="Name" required>
                                    <label style="color: black">Contact Number:</label>
                                    <input style="border-color: black; " type="text" class="form-control" placeholder="Contact Number" name="Contact" required>
                                    <label style="color: black;">Email:</label>
                                    <input style="border-color: black;" type="email" class="form-control" placeholder="Email Address" name="Email" required>
                                    <label style="color: black;">Address:</label>
                                    <input style="border-color: black; "type="text" class="form-control" placeholder="Address" name="Address" required>    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button class="btn btn-success" type="submit" name="btnSave">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">

            </div>
        </div>
    </div>
    <!--**********************************
        Content body end
    ***********************************-->

    <!-- Required vendors -->
    <script src="extra/vendor/global/global.min.js"></script>
    <script src="extra/js/quixnav-init.js"></script>
    <script src="extra/js/custom.min.js"></script>

    <script src="extra/vendor/chartist/js/chartist.min.js"></script>

    <script src="extra/vendor/moment/moment.min.js"></script>
    <script src="extra/vendor/pg-calendar/js/pignose.calendar.min.js"></script>
    


    <script src="extra/js/dashboard/dashboard-2.js"></script>
    <!-- Circle progress -->

    <!-- Datatable -->
    <script src="extra/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="extra/js/plugins-init/datatables.init.js"></script>

    <!-- Facebook Login --> 

    <!-- Load the JS SDK asynchronously -->
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>

    <script src="extra/vendor/select2/js/select2.full.min.js"></script>
    <script src="extra/js/plugins-init/select2-init.js"></script>


    <!-- Daterangepicker -->
    <!-- momment js is must -->
    <script src="extra/vendor/moment/moment.min.js"></script>
    <script src="extra/vendor/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- clockpicker -->
    <script src="extra/vendor/clockpicker/js/bootstrap-clockpicker.min.js"></script>
    <!-- asColorPicker -->
    <script src="extra/vendor/jquery-asColor/jquery-asColor.min.js"></script>
    <script src="extra/vendor/jquery-asGradient/jquery-asGradient.min.js"></script>
    <script src="extra/vendor/jquery-asColorPicker/js/jquery-asColorPicker.min.js"></script>
    <!-- Material color picker -->
    <script src="extra/vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <!-- pickdate -->
    <script src="extra/vendor/pickadate/picker.js"></script>
    <script src="extra/vendor/pickadate/picker.time.js"></script>
    <script src="extra/vendor/pickadate/picker.date.js"></script>



    <!-- Daterangepicker -->
    <script src="extra/js/plugins-init/bs-daterange-picker-init.js"></script>
    <!-- Clockpicker init -->
    <script src="extra/js/plugins-init/clock-picker-init.js"></script>
    <!-- asColorPicker init -->
    <script src="extra/js/plugins-init/jquery-asColorPicker.init.js"></script>
    <!-- Material color picker init -->
    <script src="extra/js/plugins-init/material-date-picker-init.js"></script>
    <!-- Pickdate -->
    <script src="extra/js/plugins-init/pickadate-init.js"></script>

</body>

</html>