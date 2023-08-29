<?php
	include 'db-controller.php';
    session_start();

    if(!(isset($_SESSION["users_id"]))) {
        header("location: default.php");
    }
    $UID = $_SESSION["users_id"];

	$sqlDelete = "UPDATE cart_tbl SET cart_isdel=1, cart_status = 'Canceled Order' WHERE cart_users_id='$UID' AND cart_status = 'New Order' AND cart_isdel = 0";
	mysqli_query($dbConString, $sqlDelete);

	header("location: pos.php");
?>