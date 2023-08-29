<?php
	include 'db-controller.php';
    session_start();

    if(!(isset($_SESSION["users_id"]))) {
        header("location: default.php");
    }
    $UID = $_SESSION["users_id"];
    $Search = $_GET['search'];
    $ORNum = $_GET['ornum'];

	if($Search == ''){
        header("location: pos.php");
    }else{
        $sqlProduct = "SELECT * FROM products_tbl WHERE prod_name = '$Search'";
        $queryProduct = mysqli_query($dbConString, $sqlProduct);
        $fetchProduct = mysqli_fetch_assoc($queryProduct);
        $PP = $fetchProduct['prod_price'];
        $PI = $fetchProduct['prod_id'];
        $date = date('Y-m-d');

        $sqlCheck = "SELECT cart_prod_id FROM cart_tbl WHERE cart_prod_id = '$PI' AND cart_isdel = 0";
        $queryCheck = mysqli_query($dbConString, $sqlCheck);

        if(mysqli_num_rows($queryCheck) > 0){
            // echo 'Update';
            $sqlCartCheck = "SELECT * FROM cart_tbl WHERE cart_prod_id = '$PI'";
            $queryCartCheck = mysqli_query($dbConString, $sqlCartCheck);
            $fetchCartCheck = mysqli_fetch_assoc($queryCartCheck);
            $CQTY = $fetchCartCheck['cart_qty'];
            $ADDQTY = '1';
            $SUMQTY = $CQTY + $ADDQTY;

            $PRODCARTAMOUNT = $fetchCartCheck['cart_amount'];
            $NEWPRODCARTAMOUNT = $PRODCARTAMOUNT + $PP;

            $sqlUpdate = "UPDATE cart_tbl SET cart_qty = '$SUMQTY', cart_amount = '$NEWPRODCARTAMOUNT' WHERE cart_prod_id = '$PI'";
            mysqli_query($dbConString, $sqlUpdate);
            
            header("location: pos.php");
        }else{
            //echo Insert]
            
            $sqlAdd = "INSERT INTO cart_tbl() VALUES (NULL, '$UID', '$PI', '$ORNum', 1, '$PP', 0, '$date', 'New Order', 0)";
            mysqli_query($dbConString, $sqlAdd);

            header("location: pos.php");
        }
    }
?>