<?php
	include 'db-controller.php';

	$id = $_GET['id'];

	$sqlDelete = "UPDATE position_tbl SET pos_isdel=1 WHERE pos_id=$id";
	mysqli_query($dbConString, $sqlDelete);

	header("location: positions.php");
?>