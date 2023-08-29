<?php
	include 'db-controller.php';

	$id = $_GET['id'];

	$sqlDelete = "UPDATE products_tbl SET prod_isactive=0 WHERE prod_id=$id";
	mysqli_query($dbConString, $sqlDelete);

	header("location: products.php");
?>