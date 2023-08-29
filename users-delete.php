<?php
	include 'db-controller.php';

	$id = $_GET['id'];

	$sqlDelete = "UPDATE users_tbl SET users_isdel=1 WHERE users_id=$id";
	mysqli_query($dbConString, $sqlDelete);

	header("location: users.php");
?>