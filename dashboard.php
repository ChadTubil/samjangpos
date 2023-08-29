<?php
    include 'db-controller.php';
    session_start();

    if(!(isset($_SESSION["users_id"]))) {
        header("location: default.php");
    }
    $id = $_SESSION["users_id"];

    $sqlUsers = "SELECT * FROM users_tbl WHERE users_id = '$id'";
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
            if($id == 1){
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
                            <h4 style="color: black;">Hi, welcome back! 
                                <?php 
                                    print $fetchUsers['users_name']; 
                                ?>
                            </h4>
                            <p class="mb-0" style="color: black;">Dashboard</p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)" style="color: black;">Sam Jang</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)" style="color: black;">Dashboard</a></li>
                        </ol>
                    </div>
                </div>

                <div class="row" >
                    <div class="col-xl-12">
                        <div class="card" style="border: solid; border-color: black;">
                            <div class="card-header d-block">
                                <h3 class="card-title">Quick Links</h3>
                            </div>
                            <div class="card-body" style="padding-bottom: 0px;">
                                <div class="btn-group" style="text-align: center; ">
                                    <a href="pos-checking.php">
                                        <img src="image/cashregister.png" style="width: 50%;">
                                        <p style="color: black;">POS</p>
                                    </a>
                                    <a href="products.php">
                                        <img src="image/barcode.png" style="width: 50%;">
                                        <p style="color: black;">PRODUCTS</p>
                                    </a>
                                    <a href="today-sales.php">
                                        <img src="image/cart.png" style="width: 50%;">
                                        <p style="color: black;">SALES</p>
                                    </a>
                                    <a href="customers.php">
                                        <img src="image/users.png" style="width: 50%;">
                                        <p style="color: black;">CUSTOMERS</p>
                                    </a>
                                    <a href="sales.php">
                                        <img src="image/reports.png" style="width: 50%;">
                                        <p style="color: black;">REPORTS</p>
                                    </a>
                                    <a>
                                        <img src="image/giftcards.png" style="width: 50%;">
                                        <p style="color: black;">GIFT CARDS</p>
                                    </a>
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


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
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

</body>

</html>