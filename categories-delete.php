<?php
	include 'db-controller.php';

	$id = $_GET['id'];

	$sqlDelete = "UPDATE categories_tbl SET cat_isdel=1 WHERE cat_id=$id";
	mysqli_query($dbConString, $sqlDelete);

	header("location: categories.php");
?>