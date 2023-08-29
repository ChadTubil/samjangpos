<?php
	include 'db-controller.php';

	$id = $_GET['id'];

	$sqlDelete = "UPDATE customers_tbl SET cus_isdel=1 WHERE cus_id=$id";
	mysqli_query($dbConString, $sqlDelete);

	header("location: customers.php");
?>