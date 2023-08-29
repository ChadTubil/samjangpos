<?php
	include 'db-controller.php';

	$id = $_GET['id'];

	$sqlDelete = "UPDATE employees_tbl SET emp_isdel=1 WHERE emp_id=$id";
	mysqli_query($dbConString, $sqlDelete);

	header("location: employees.php");
?>