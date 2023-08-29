<?php
	include 'db-controller.php';

	$id = $_GET['id'];

	$sqlDelete = "UPDATE discount_tbl SET disc_isdel=1 WHERE disc_id=$id";
	mysqli_query($dbConString, $sqlDelete);

	header("location: discounts.php");
?>