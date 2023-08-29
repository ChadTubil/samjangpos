<?php
	include 'db-controller.php';

	$id = $_GET['id'];

	$sqlDelete = "UPDATE cart_tbl SET cart_isdel=1, cart_status = 'Canceled Order' WHERE cart_id=$id";
	mysqli_query($dbConString, $sqlDelete);

	header("location: pos.php");
?>