<?php
	include 'db-controller.php';
    session_start();

    if(!(isset($_SESSION["users_id"]))) {
        header("location: default.php");
    }
    $UID = $_SESSION["users_id"];

	$id = $_GET['id'];
    $ON = $_GET['ordernumber'];
    $Flavor = $_GET['flavor'];

    $sqlProduct = "SELECT * FROM products_tbl WHERE prod_id = '$id'";
    $queryProduct = mysqli_query($dbConString, $sqlProduct);
    $fetchProduct = mysqli_fetch_assoc($queryProduct);
    $PP = $fetchProduct['prod_price'];
    $PD = $fetchProduct['prod_dine'];
    $PT = $fetchProduct['prod_take'];
    $date = date('Y-m-d');

    $sqlCheck = "SELECT cart_prod_id FROM cart_tbl WHERE cart_prod_id = '$id' AND cart_isdel = 0 AND cart_status = 'New Order' AND cart_flavor_id = '$Flavor'";
    $queryCheck = mysqli_query($dbConString, $sqlCheck);

	if(mysqli_num_rows($queryCheck) > 0){
        // echo 'Update';
        $sqlCartCheck = "SELECT * FROM cart_tbl WHERE cart_prod_id = '$id' AND cart_flavor_id = '$Flavor'";
        $queryCartCheck = mysqli_query($dbConString, $sqlCartCheck);
        $fetchCartCheck = mysqli_fetch_assoc($queryCartCheck);
        $CQTY = $fetchCartCheck['cart_qty'];
        $ADDQTY = '1';
        $SUMQTY = $CQTY + $ADDQTY;

        $PRODCARTAMOUNT = $fetchCartCheck['cart_amount'];
        $NEWPRODCARTAMOUNT = $PRODCARTAMOUNT + $PP;

        $DINECART = $fetchCartCheck['cart_dine'];
        $NEWPRODDINECOST = $DINECART + $PD;

        $TAKECART = $fetchCartCheck['cart_take'];
        $NEWPRODTAKECOST = $TAKECART + $PT;

        $sqlUpdate = "UPDATE cart_tbl SET cart_qty = '$SUMQTY', cart_amount = '$NEWPRODCARTAMOUNT', cart_dine = '$NEWPRODDINECOST',
        cart_take = '$NEWPRODTAKECOST' WHERE cart_prod_id = '$id' AND cart_flavor_id = '$Flavor'";
        mysqli_query($dbConString, $sqlUpdate);
        
        header("location: pos.php");
    }else{
        //echo Insert]
        
        $sqlAdd = "INSERT INTO cart_tbl() VALUES (NULL, '$UID', '$id', '$ON', 1, '$PP', 0, '$PD', '$PT', '', '$date', 'New Order', 0, '$Flavor')";
        mysqli_query($dbConString, $sqlAdd);

        header("location: pos.php");
    }
?>