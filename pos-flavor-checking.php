<?php
	include 'db-controller.php';

	$id = $_GET['id'];
    $on = $_GET['ordernumber'];

	$sqlCheck = "SELECT prod_flavor FROM products_tbl WHERE prod_id = '$id'";
    $queryCheck = mysqli_query($dbConString, $sqlCheck);
    $fetchCheck = mysqli_fetch_assoc($queryCheck);
    $PF = $fetchCheck['prod_flavor'];

    if($PF != 0){
        header("location: pos-flavor.php?id=".''.$id.''."&ordernumber=".''.$on);
    }else{
        header("location: pos-add-cart.php?id=".''.$id.''."&ordernumber=".''.$on);
    }
?>