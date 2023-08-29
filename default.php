<?php
    include 'db-controller.php';
    session_start();

    if(isset($_POST["btnLogin"])){
        $txtUsername = $_POST['Username'];
        $txtPassword = $_POST['Password'];

        $sqlLogin = "SELECT * FROM users_tbl WHERE users_username = '$txtUsername' AND users_password = '$txtPassword' AND users_isdel = 0";
        $queryLogin = mysqli_query($dbConString, $sqlLogin);
        $numRowsLogin = mysqli_num_rows($queryLogin);

        if($numRowsLogin != 0){
            $fetchLogin = mysqli_fetch_assoc($queryLogin);
            $_SESSION["users_id"] = $fetchLogin["users_id"];

            header("location:dashboard.php");
        }else{
            $message = "Wrong Credential. Please try again.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Sam Jang POS</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="image/Icon.png">
    <link href="extra/css/style.css" rel="stylesheet">

</head>
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
<body class="h-100" background="image/wood.jpg" style="background-size: 100%; background-repeat: no-repeat; background-size: cover;">
    <div class="authincation h-100">
        <div class="container-fluid h-100" >
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-4">
                    <div class="authincation-content" style="border: solid; border-color: black;">
                        <div class="row no-gutters"> 
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div style="text-align: center;">
                                        <img src="image/Logo.png" style="width: 100%;">
                                    </div>
                                    <h4 class="text-center mb-4">Sign in your account</h4>
                                    <form role="form" method="post">
                                        <div class="form-group">
                                            <label style="color: black"><strong>Username</strong></label>
                                            <input style="border-color: black" type="text" name="Username" class="form-control" placeholder="username" required>
                                        </div>
                                        <div class="form-group">
                                            <label style="color: black"><strong>Password</strong></label>
                                            <input style="border-color: black" type="password" name="Password" class="form-control" placeholder="********" required>
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                                <div class="form-check ml-2">
                                                    <input class="form-check-input" type="checkbox" id="basic_checkbox_1">
                                                    <label style="color: black" class="form-check-label" for="basic_checkbox_1">Remember me</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <a style="color: black" href="page-forgot-password.html">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="btnLogin" class="btn btn-primary btn-block" style="background-color: #f9f937; color: black; border-color: black;">Sign in</button>
                                        </div>
                                    </form>
                                    <!-- <div class="new-account mt-3">
                                        <p>Don't have an account? <a class="text-primary" href="./page-register.html">Sign up</a></p>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="../vendor/global/global.min.js"></script>
    <script src="../js/quixnav-init.js"></script>
    <script src="../js/custom.min.js"></script>
</body>
</html>