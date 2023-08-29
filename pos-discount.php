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

    $id = $_GET['id'];
    $sqlCart = "SELECT * FROM cart_tbl WHERE cart_id = '$id'";
    $queryCart = mysqli_query($dbConString, $sqlCart);
    $fetchCart = mysqli_fetch_assoc($queryCart);

    $CPI = $fetchCart['cart_prod_id'];

    $sqlProd = "SELECT * FROM products_tbl WHERE prod_id = '$CPI'";
    $queryProd = mysqli_query($dbConString, $sqlProd);
    $fetchProd = mysqli_fetch_assoc($queryProd);

    $ProdPrice = $fetchProd['prod_price'];

    if(isset($_POST['btnSubmit'])) {
        $txtIdNum = $_POST['IDNumber'];
        $txtName = $_POST['Name'];
        $txtDiscount = $_POST['Discount'];
        $date = date('Y-m-d');
        
        $sqlAdd = "INSERT INTO discount_history_tbl() VALUES (NULL, '$txtDiscount', '$txtName', '$id', '$txtIdNum',
        '$date', 0)";
        mysqli_query($dbConString, $sqlAdd);

        $sqlSearchDiscount = "SELECT * FROM discount_tbl WHERE disc_id = '$txtDiscount'";
        $querySearchDiscount = mysqli_query($dbConString, $sqlSearchDiscount);
        $fetchSearchDiscount = mysqli_fetch_assoc($querySearchDiscount);

        $DISCVALUE = $fetchSearchDiscount['disc_value'];
        $DISCOUNT = $ProdPrice * $DISCVALUE;

        $sqlUpdate = "UPDATE cart_tbl SET cart_discount = '$DISCOUNT' WHERE cart_id = '$id'";
        mysqli_query($dbConString, $sqlUpdate);

        header("location: pos.php");

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
            <div class="col-lg-3 col-sm-6">

            </div>
            <div class="col-lg-6 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h4>Adding Discount to <strong><?php 
                                $CPID = $fetchCart['cart_prod_id'];
                                $sqlProducts = "SELECT * FROM products_tbl WHERE prod_id = '$CPID'";
                                $queryProducts = mysqli_query($dbConString, $sqlProducts);
                                $fetchProducts = mysqli_fetch_assoc($queryProducts);

                                print $fetchProducts['prod_name'];
                            ?></strong>
                        </h4>
                        <br>
                        <form method="post" role="form" enctype="multipart/form-data">
                            <div style="padding-bottom: 5px;">
                                <label style="color: black;">Discount Type</label>
                                <select class="form-control" name="Discount" style="border-color: black;" required>
                                    <?php
                                        $sqlDiscount = mysqli_query($dbConString, "SELECT disc_id, disc_name FROM discount_tbl WHERE disc_isdel = 0 AND disc_users_id = '$UID'");  // Use select query here 
                                        while($data = mysqli_fetch_array($sqlDiscount))
                                        {
                                            echo "<option value='". $data['disc_id'] ."'>" .$data['disc_name'] ."</option>";  // displaying data in option menu //first id second display
                                        }	
                                    ?>
                                </select>
                                <label style="color: black;">Name</label>
                                <input style="border-color: black; "type="text" class="form-control" name="Name" required>
                                <label style="color: black;">ID Number</label>
                                <input style="border-color: black; "type="text" class="form-control" name="IDNumber">
                                <p style="color: red; font-size: 10pt;">* Optional</p>
                                
                            </div>
                            <br>
                            <div style="padding-bottom: 5px;">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="button" onclick="document.location.href='pos.php'" class="btn btn-danger" style="width: 100%; height: 50px;">CANCEL</button>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" name="btnSubmit" class="btn btn-success" style="width: 100%; height: 50px;">SUBMIT</button>
                                    </div>
                                </div>
                            </div>
                        </form>
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