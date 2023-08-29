<?php
    include 'db-controller.php';
    session_start();

    if(!(isset($_SESSION["users_id"]))) {
        header("location: default.php");
    }
    $UID = $_SESSION["users_id"];

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
                            <h4 style="color: black;">ATTENDANCE</h4>
                            <span class="ml-1" style="color: black;">Reports</span>
                            
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php" style="color: black;">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)" style="color: black;">Attendance</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card" style="border: solid; border-color: black;">
                            <div class="card-header">
                                <h4 class="card-title">Attendance</h4>
                                <!-- <span>
                                    <button class="btn btn-success" onclick="document.location.href='customers-add.php'">Add New</button>
                                </span> -->
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display" style="min-width: 845px">
                                        <thead>
                                        <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Login</th>
                                                <th>Logout</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sqlAttendance = "SELECT * FROM attendance_tbl WHERE att_users_id = '$UID'";
                                                $queryAttendance = mysqli_query($dbConString, $sqlAttendance);
                                                while($fetchAttendance = mysqli_fetch_assoc($queryAttendance)) {
                                            ?>
                                            <tr>
                                                <td style="color: black;"><?php print $fetchAttendance["att_id_number"] ?></td>
                                                <td style="color: black;">
                                                    <?php 
                                                        $ATIN = $fetchAttendance["att_id_number"];
                                                        $sqlEmployees = "SELECT * FROM employees_tbl WHERE emp_number = '$ATIN'";
                                                        $queryEmployees = mysqli_query($dbConString, $sqlEmployees);
                                                        $fetchEmployees = mysqli_fetch_assoc($queryEmployees);
                                                        print $fetchEmployees['emp_name'];
                                                    ?></td>
                                                <td style="color: black;"><?php print $fetchAttendance["att_date"] ?></td>
                                                <td style="color: green;"><?php print $fetchAttendance["att_login"] ?></td>
                                                <td style="color: red;"><?php print $fetchAttendance["att_logout"] ?></td>
                                            </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Login</th>
                                                <th>Logout</th>
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