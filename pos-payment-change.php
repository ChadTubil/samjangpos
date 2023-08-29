<?php
    include 'db-controller.php';
    session_start();

    if(!(isset($_SESSION["users_id"]))) {
        header("location: default.php");
    }
    $UID = $_SESSION["users_id"];
    
    $Change = $_GET['change'];
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
            <div class="col-lg-4 col-sm-6">

            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="card" style="box-shadow: 5px 7px #888888;">
                    <div class="card-body" style="text-align: center;">
                        <h4 style="color: black;"><strong>CHANGE</strong></h4>
                        <br>
                        <h1 style="color: black;"><strong><u><?php print "₱".''.$Change; ?></u></strong></h1>
                    </div>
                    <div class="row" style="padding: 20px;">
                        <div class="col-6">
                            <button type="button" class="btn btn-success" style="width: 100%; height: 80px; font-size: 16pt;"
                            onclick="document.location.href='pos.php'">Close</button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-primary" style="width: 100%; height: 80px; font-size: 16pt;"
                            onclick="window.open('print.php')">Print Receipt</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">

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