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

    $date = date('Y-m-d');
    $sqlCheck = "SELECT * FROM cashier_holder_tbl WHERE ch_logout = '00:00:00' AND ch_date = '$date' AND ch_users_id = '$UID'";
    $queryCheck = mysqli_query($dbConString, $sqlCheck);

    if(mysqli_num_rows($queryCheck) > 0){
        header("location: pos.php");
    }else{
        header("location: pos-login.php");
    }
?>