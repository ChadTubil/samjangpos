<?php
	include 'db-controller.php';

	$id = $_GET['id'];

	$sqlDelete = "UPDATE units_tbl SET unit_isdel=1 WHERE unit_id=$id";
	mysqli_query($dbConString, $sqlDelete);

	header("location: units.php");
?>