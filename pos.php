<?php
    include 'db-controller.php';
    session_start();

    if(!(isset($_SESSION["users_id"]))) {
        header("location: default.php");
    }
    // error_reporting(E_ERROR);
    $UID = $_SESSION["users_id"];
    $sqlUsers = "SELECT * FROM users_tbl WHERE users_id = '$UID'";
    $queryUsers = mysqli_query($dbConString, $sqlUsers);
    $fetchUsers = mysqli_fetch_assoc($queryUsers);

    $sqlCheckOrder = "SELECT COUNT(order_number) AS TOTALCOUNTNUMBER FROM order_tbl WHERE order_users_id = '$UID'";
    $queryCheckOrder = mysqli_query($dbConString, $sqlCheckOrder);
    $fetchCheckOrder = mysqli_fetch_assoc($queryCheckOrder);
    $ON = $fetchCheckOrder['TOTALCOUNTNUMBER'];
    $Plus = '1';

    $NewOrderNumber = $ON + $Plus;

    $date = date("l m-d-Y");
    
    // Search
    if(isset($_POST['btnSearch'])) {
        $txtSearch = $_POST['Search'];

        header("location: pos-search.php?search=$txtSearch&ornum=$NewOrderNumber");
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
        <a href="pos.php" class="logo"><img src="image/Logo.png" alt="" style="width: 100%; height: 60px; "></a>
        <div class="header-right" style="padding-top: 20px;">
            <!-- <a class="active" href="#home">Home</a>
            <a href="#contact">Contact</a> -->
            
            <a href="dashboard.php" style="font-size: 16pt;"><strong><i class="ti-dashboard"></i></strong></a>
            <a href="#ModalKeys" style="font-size: 16pt;" data-target="#ModalKeys" data-toggle="modal"><strong><i class="ti-key"></i></strong></a>
             <!-- Modal -->
             <div class="modal fade" id="ModalKeys">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form method="post" role="form" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title">Shortcut Keys</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p style="color: black;"><strong>FN + S</strong> - Search</p>
                                <p style="color: black;"><strong>FN + X</strong> - Cancel</p>
                                <p style="color: black;"><strong>FN + Q</strong> - Print Last Receipt</p>
                                <p style="color: black;"><strong>FN + P</strong> - Payment</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <a href="pos-logout.php">Close Register</a>
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
            <div class="col-lg-4 col-sm-6">
                <div class="card">
                    <!-- <div class="card-header">
                        <h4 class="card-title">Add Customer</h4>
                        <span>
                            <button class="btn btn-success" onclick="document.location.href='course-year-add.php'">Add Course</button>
                        </span>
                    </div> -->
                    <div class="card-body">
                        <div class="input-group" style="display: block;">
                            <span style="float:left;"><p style="color: black;"><strong><?php print "ORDER #".''.$NewOrderNumber; ?></strong></p></span><span style="float: right;"><p style="color: black;"><strong><?php print $date; ?></strong></p></span>  
                        </div>
                        <form method="post" role="form" enctype="multipart/form-data">
                            <div style="padding-bottom: 5px;"  class="input-group">
                                
                                    <input style="border-color: black; height: 40px; font-size: 14pt;" type="text" class="form-control" accesskey="s" placeholder="Search Product" name="Search" autofocus>
                                    <span class="input-group-addon">
                                        <button type="submit" name="btnSearch" class="btn" style="border-color: black; text-align: center; color: black; border-radius: 0px; 
                                        border-top-right-radius: 4px; height: 40px; border-bottom-right-radius: 4px;">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr style="background-color: yellow">
                                        <th scope="col" style="color: black;">#</th>
                                        <th scope="col" style="color: black;">Product</th>
                                        <th scope="col" style="color: black;">Price</th>
                                        <th scope="col" style="color: black;">Sub Total</th>
                                        <th scope="col" style="color: black;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sqlCart = "SELECT * FROM cart_tbl WHERE cart_isdel = 0 AND cart_users_id = '$UID'";
                                        $queryCart = mysqli_query($dbConString, $sqlCart);
                                        while($fetchCart = mysqli_fetch_assoc($queryCart)) {
                                            $CPI = $fetchCart['cart_prod_id'];
                                            $DISC = $fetchCart['cart_discount'];
                                            $CFI = $fetchCart['cart_flavor_id'];
                                            $sqlFetchProd = "SELECT * FROM products_tbl WHERE prod_id = '$CPI'";
                                            $queryFetchProd = mysqli_query($dbConString, $sqlFetchProd);
                                            $fethcFetchProd = mysqli_fetch_assoc($queryFetchProd);

                                            if($CFI == 0){
                                                $SHOWFLAVOR = '';
                                            }else{
                                                $Flavor = "SELECT * FROM flavors_tbl WHERE flavor_id = '$CFI'";
                                                $queryFlavor = mysqli_query($dbConString, $Flavor);
                                                $fetchFlavor = mysqli_fetch_assoc($queryFlavor);
                                                $SHOWFLAVOR = $fetchFlavor['flavor_name'];
                                            }
                                    ?>
                                    <tr>
                                        <td style="color: black;"><?php print $fetchCart['cart_qty']; ?></td>
                                        <td style="color: black;"><?php print $fethcFetchProd['prod_name'].'<span style="float: right; color: red; font-size: 10pt;">'.$SHOWFLAVOR.'</span>'; ?></td>
                                        <td style="color: black;"><?php print $fethcFetchProd['prod_price']; ?></td>
                                        <td style="color: black;"><?php print $fetchCart['cart_amount']; ?></td>
                                        <td style="color: black;">
                                            <button type="button" <?php if ($DISC != 0){ ?> disabled <?php   } ?> onclick="document.location.href='pos-discount.php?id=<?php print $fetchCart['cart_id']; ?>'" class="btn btn-primary" style="height: 20px; font-size: 10px; padding: 0px 5px;"><i class="fa fa-tag"></i></button>
                                            <button type="button" onclick="document.location.href='pos-void.php?id=<?php print $fetchCart['cart_id']; ?>'" class="btn btn-danger" style="height: 20px; font-size: 10px; padding: 0px 5px;"><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <table class="table">
                                <tbody style="width: 100%;">
                                    <tr style="background-color: lightblue;">
                                        <td style="color: black;">Total Items</td>
                                        <td style="color: black;">
                                            <?php
                                                $sqlCountItems = "SELECT SUM(cart_qty) AS TOTALCOUNTITEMS FROM cart_tbl WHERE cart_users_id = '$UID' AND cart_isdel = 0";
                                                $queryCountItems = mysqli_query($dbConString, $sqlCountItems);
                                                $fetchCountItems = mysqli_fetch_assoc($queryCountItems);

                                                print $fetchCountItems['TOTALCOUNTITEMS'];
                                            ?>
                                        </td>
                                        <td style="color: black;">Total Amount</td>
                                        <td style="color: black;">
                                            <?php
                                                $sqlAmountItems = "SELECT SUM(cart_amount) AS TOTALAMOUNTITEMS FROM cart_tbl WHERE cart_users_id = '$UID' AND cart_isdel = 0";
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
                                    <tr style="background-color: lightblue;">
                                        <td style="color: black;">Discount</td>
                                        <td style="color: black;">
                                            <?php
                                                $sqlDiscount = "SELECT SUM(cart_discount) AS TOTALDISCOUNT FROM cart_tbl WHERE cart_users_id = '$UID' AND cart_isdel = 0";
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
                                    <tr style="background-color: lightgreen;" >
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
                        </div>
                        <div style="padding-bottom: 5px;">
                            <div class="row">
                                <div class="col-4">
                                    <button type="button" onclick="document.location.href='pos-clear-cart.php'" class="btn btn-danger" style="width: 100%; height: 50px;" accesskey="x">CANCEL</button>
                                </div>
                                <div class="col-4">
                                    <button onclick="window.open('print.php')" class="btn btn-primary" style="width: 100%; height: 50px;" accesskey="q">PRINT LAST RECEIPT</button>
                                </div>
                                <div class="col-4">
                                    <button data-toggle="modal" data-target="#exampleModalPayment" class="btn btn-success" style="width: 100%; height: 50px;" accesskey="p">Payment</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalPayment">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form method="post" role="form" enctype="multipart/form-data">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Payment</h5>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p style="color: black;">Select mode of payment.</p>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <button class="btn" type="button" style="width: 100%; height: 100px; border-color: black;
                                                                color: black; box-shadow: 5px 7px #888888;" 
                                                                onclick="document.location.href='pos-payment-cash.php'">CASH</button>
                                                            </div>
                                                            <div class="col-3">
                                                                <button class="btn" style="width: 100%; height: 100px; border-color: black;
                                                                color: black; box-shadow: 5px 7px #888888;" disabled>CARD</button>
                                                            </div>
                                                            <div class="col-3">
                                                                <button class="btn" style="width: 100%; height: 100px; border-color: black;
                                                                color: black; box-shadow: 5px 7px #888888;" disabled>E-PAY</button>
                                                            </div>
                                                            <div class="col-3">
                                                                <button class="btn" style="width: 100%; height: 100px; border-color: black;
                                                                color: black; box-shadow: 5px 7px #888888;" disabled>GIFT CARD</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-sm-6">
                <div class="card" style="padding: 20px;">
                    <div class="row">
                        <?php
                            $sqlProducts = "SELECT * FROM products_tbl WHERE prod_isactive = 0 AND prod_isdel = 0 AND prod_users_id = '$UID' ORDER BY prod_name ASC";
                            $queryProducts = mysqli_query($dbConString, $sqlProducts);
                            while($fetchProducts = mysqli_fetch_assoc($queryProducts)) {
                        ?>
                        <div class="col-lg-2 col-sm-6">
                            <a href="pos-flavor-checking.php?id=<?php print $fetchProducts['prod_id']; ?>&ordernumber=<?php print $NewOrderNumber; ?>">
                                <div class="card" style=" box-shadow: 2px 2px 5px gray;">
                                    <div class="card-body" style="padding: 0px;">
                                        <img src="image/<?php print $fetchProducts["prod_image"]; ?>" alt="" style="width: 100%; height: 100px; ">
                                    </div>
                                    <div class="card-footer" style="text-align: center; padding-top: 5px; padding-bottom: 5px;">
                                        <p class="card-text d-inline" style="color: black; font-size: 8pt;"><strong><?php print $fetchProducts["prod_name"]; ?></strong></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
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