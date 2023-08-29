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

    error_reporting(E_ERROR);

    if(isset($_POST['btnEnter'])) {
        $txtId = $_POST['IDNumber'];
        $date = date('Y-m-d');
        $time = date("h:i:sa");

        $sqlEmployee = "SELECT * FROM employees_tbl WHERE emp_number = '$txtId'";
        $queryEmployee = mysqli_query($dbConString, $sqlEmployee);
        $fetchEmployee = mysqli_fetch_assoc($queryEmployee);
        $Position = $fetchEmployee['emp_position_id'];
        $IdNumber = $fetchEmployee['emp_number'];

        if($IdNumber == ''){
            $message = "Invalid id number. Please try again.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }else{
            $sqlCheck = "SELECT * FROM attendance_tbl WHERE att_id_number = '$IdNumber' AND att_date = '$date'";
            $queryCheck = mysqli_query($dbConString, $sqlCheck);

            if(mysqli_num_rows($queryCheck) > 0){
                //Update Logout
                $sqlAttCheck = "SELECT * FROM attendance_tbl WHERE  att_id_number = '$txtId'";
                $queryAttCheck = mysqli_query($dbConString, $sqlAttCheck);
                $fetchAttCheck = mysqli_fetch_assoc($queryAttCheck);
                $LOGOUT = $fetchAttCheck['att_logout'];

                if($LOGOUT == '00:00:00'){
                    $sqlUpdate = "UPDATE attendance_tbl SET att_logout = '$time' WHERE att_id_number = '$txtId' AND att_date = '$date'";
                    mysqli_query($dbConString, $sqlUpdate);
        
                    header("location: attendancce.php");
                    
                }else{
                    $message = "You are already been logged out. Try again tomorrow.";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                    // echo "123123123123123";
                }
                
            }else{
                $sqlAdd = "INSERT INTO attendance_tbl() VALUES (NULL, '$UID', '$txtId', '$time', '', 
                '$date', '$Position', 0)";
                mysqli_query($dbConString, $sqlAdd);

                header("location: attendance.php");
            }
        }

        
    }

    $sqlAttendaceLast = "SELECT MAX(att_id) AS LASTID FROM attendance_tbl WHERE att_users_id = '$UID'";
    $queryAttendanceLast = mysqli_query($dbConString, $sqlAttendaceLast);
    $fetchAttendanceLast = mysqli_fetch_assoc($queryAttendanceLast);
    $LASTID = $fetchAttendanceLast['LASTID'];

    $sqlAttendance = "SELECT * FROM attendance_tbl WHERE att_id = '$LASTID'";
    $queryAttendance = mysqli_query($dbConString, $sqlAttendance);
    $fetchAttendance = mysqli_fetch_assoc($queryAttendance);
    $IDNUM = $fetchAttendance['att_id_number'];

    $sqlEmp = "SELECT * FROM employees_tbl WHERE emp_number = '$IDNUM'";
    $queryEmp = mysqli_query($dbConString, $sqlEmp);
    $fetchEmp = mysqli_fetch_assoc($queryEmp);

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
<body style="background-image: url('image/wood.jpg'); background-repeat: no-repeat; background-size: cover; background-attachment: fixed;">

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
    <!-- <div class="header1" style="padding-top: 0px; padding-bottom: 0px; padding-left: 20px;">
        <a href="#default" class="logo"><img src="image/Logo.png" alt="" style="width: 100%; height: 60px; "></a>
        <div class="header-right" style="padding-top: 20px;"> -->
            <!-- <a class="active" href="#home">Home</a>
            <a href="#contact">Contact</a> -->
            
            <!-- <a href="#" style="font-size: 16pt;"><strong><i class="ti-dashboard"></i></strong></a>
            <a href="#" style="font-size: 16pt;"><strong><i class="ti-key"></i></strong></a>
            <a href="#about">Close Register</a>
        </div>
    </div> -->
    <!--**********************************
        Header end
    ***********************************-->

    <!--**********************************
        Content body start
    ***********************************-->
    <div style="padding-top: 75px;">
        <div class="row">
            <div class="col-lg-3 col-sm-6">

            </div>
            <div class="col-lg-6 col-sm-6">
                <div class="card">
                    <div class="card-body" style="text-align: center;">
                        <div class="profile-photo">
                            <img src="image/<?php print $fetchEmp['emp_image']; ?>" class="img-fluid rounded-circle" 
                            alt="" style="width: 300px; height: 300px; border-color: #4c016b; border-style: solid;">
                        </div>
                        <br>
                        <form method="post" role="form" enctype="multipart/form-data">
                            <div style="padding-bottom: 5px;">
                                <label style="color: black;" >ID Number</label>
                                <input style="border-color: black; "type="password" class="form-control" name="IDNumber" required autofocus>
                                <button class="btn btn-primary" type="submit" style="width: 100%; margin-top: 5px;" name="btnEnter">ENTER</button>
                            </div>
                        </form>
                        <br>
                        <h3 style="color: black;">
                            <?php 
                                $ATIN = $fetchAttendance["att_id_number"];
                                $sqlEmployeee = "SELECT * FROM employees_tbl WHERE emp_number = '$ATIN'";
                                $queryEmployeee = mysqli_query($dbConString, $sqlEmployeee);
                                $fetchEmployeee = mysqli_fetch_assoc($queryEmployeee);
                                print $fetchEmployeee['emp_name'];
                            ?>
                        </h3>
                        <p style="color: black">
                            <?php 
                                $ATTP = $fetchAttendance['att_position']; 
                                $sqlPosition = "SELECT * FROM position_tbl WHERE pos_id = '$ATTP'";
                                $queryPosition = mysqli_query($dbConString, $sqlPosition);
                                $fetchPosition = mysqli_fetch_assoc($queryPosition);
                                print $fetchPosition['pos_name'];
                            ?>
                        </p>
                        <h5 style="color: black;">
                            <?php            
                                if($fetchAttendance['att_logout'] == '00:00:00'){
                                    print $fetchAttendance['att_date'].' - '.$fetchAttendance['att_login'];
                                }else{
                                    print $fetchAttendance['att_date'].' - '.$fetchAttendance['att_logout'];
                                }
                            ?>
                        </h5>
                        <p style="color: red;">  
                            <?php
                                if($fetchAttendance['att_logout'] == '00:00:00'){
                                    print "You have been login. Thank You!";
                                }else{
                                    print "You are already been logged out. Thank you!";
                                }
                            ?>
                        </p>
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