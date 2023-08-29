<?php
    include 'db-controller.php';
    session_start();
    date_default_timezone_set("Asia/Manila");
    $UID = $_SESSION["users_id"];
    $sqlOrderNumber = "SELECT MAX(order_number) AS LASTORDERNUM FROM order_tbl WHERE order_users_id = '$UID'";
    $queryOrderNumber = mysqli_query($dbConString, $sqlOrderNumber);
    $fetchOrderNumber = mysqli_fetch_assoc($queryOrderNumber);
    $ON = $fetchOrderNumber['LASTORDERNUM'];

    $sqlOrder = "SELECT * FROM order_tbl WHERE order_number = '$ON' AND order_users_id = '$UID'";
    $queryOrder = mysqli_query($dbConString, $sqlOrder);
    $fetchOrder = mysqli_fetch_assoc($queryOrder);
    $OID = $fetchOrder['order_id'];
    $ODate = $fetchOrder['order_datecreated'];
    $newDate = date("l d-m-Y", strtotime($ODate));

    $OCus = $fetchOrder['order_cus_id'];

    $sqlCountItems = "SELECT SUM(cart_qty) AS TOTALCOUNTITEMS FROM cart_tbl WHERE cart_users_id = '$UID' AND cart_order_id = '$OID' AND cart_isdel = 1 AND cart_status = 'Paid'";
    $queryCountItems = mysqli_query($dbConString, $sqlCountItems);
    $fetchCountItems = mysqli_fetch_assoc($queryCountItems);

    $sqlAmountItems = "SELECT SUM(cart_amount) AS TOTALAMOUNTITEMS FROM cart_tbl WHERE cart_users_id = '$UID' AND cart_order_id = '$OID' AND cart_isdel = 1 AND cart_status = 'Paid'";
    $queryAmountItems = mysqli_query($dbConString, $sqlAmountItems);
    $fetchAmountItems = mysqli_fetch_assoc($queryAmountItems);

    $TOTALAMOUNTWOTAX = $fetchAmountItems['TOTALAMOUNTITEMS'];
    $AMOUNTTAX = '0.03';
    $TOTALTAXAMOUNT = $TOTALAMOUNTWOTAX * $AMOUNTTAX;
    $TOTALAMOUNTWTAX = $TOTALAMOUNTWOTAX - $TOTALTAXAMOUNT;

    $sqlDiscount = "SELECT SUM(cart_discount) AS TOTALDISCOUNT FROM cart_tbl WHERE cart_users_id = '$UID' AND cart_order_id = '$OID' AND cart_isdel = 1 AND cart_status = 'Paid'";
    $queryDiscount = mysqli_query($dbConString, $sqlDiscount);
    $fetchDiscount = mysqli_fetch_assoc($queryDiscount);

    $TOTALDISCOUNT = $fetchDiscount['TOTALDISCOUNT'];                             
    $TOTALPAYABLE = $TOTALAMOUNTWOTAX - $TOTALDISCOUNT;

?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Sam Jang POS</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="image/Icon.png">
    <link href="extra/css/style.css" rel="stylesheet">

</head>

<body onload="window.print()">
    <div style="width: 260px; text-align: center;padding-left: 5px; padding-right: 5px; padding-top: 10px;" class="card">
        <h3 style="color: black; margin-bottom: 0px;">SAM JANG</h3>
        <h5 style="color: black;">ACKNOWLEDGMENT RECEIPT</h5>
        <br>
        <div style="text-align: left;">
            <h4 style="color: black; margin-bottom: 0px;">Receipt No.: <?php print $ON; ?></h4>
            <p style="color: black; margin-bottom: 0px;"><?php print $newDate; ?></p>
            <p style="color: black; margin-bottom: 0px;">
                <?php
                    if($OCus == 0){
                        print "Walk-In Client";
                    }else{
                        $sqlCustomer = "SELECT * FROM customers_tbl WHERE cus_id = '$OCus'";
                        $queryCustomer = mysqli_query($dbConString, $sqlCustomer);
                        $fetchCustomer = mysqli_fetch_assoc($queryCustomer);
        
                        print $fetchCustomer['cus_name'];
                    }
                ?>
            </p>
            <p style="color: black; margin-bottom: 0px;"><?php print $fetchOrder['order_type']; ?></p>
        </div>
        <br>
        <div >
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="color: black; font-size: 10pt;">ITEM</th>
                        <th style="color: black; font-size: 10pt;">QTY</th>
                        <th style="color: black; font-size: 10pt;">PRICE</th>
                        <th style="color: black; font-size: 10pt;">SUB</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sqlCart = "SELECT * FROM cart_tbl WHERE cart_users_id = '$UID' AND cart_order_id = '$OID' AND cart_isdel = 1 AND cart_status = 'Paid'";
                        $queryCart = mysqli_query($dbConString, $sqlCart);
                        while($fetchCart = mysqli_fetch_assoc($queryCart)){
                            $CPID = $fetchCart['cart_prod_id'];
                            $CFI = $fetchCart['cart_flavor_id'];
                            $sqlProduct = "SELECT * FROM products_tbl WHERE prod_id = '$CPID'";
                            $queryProduct = mysqli_query($dbConString, $sqlProduct);
                            $fetchProduct = mysqli_fetch_assoc($queryProduct);

                            if($CFI == 0){
                                $SHOWFLAVOR = '';
                            }else{
                                $Flavor = "SELECT * FROM flavors_tbl WHERE flavor_id = '$CFI'";
                                $queryFlavor = mysqli_query($dbConString, $Flavor);
                                $fetchFlavor = mysqli_fetch_assoc($queryFlavor);
                                $SHOWFLAVOR = $fetchFlavor['flavor_name'];
                            }
                    ?>
                    <tr>
                        <td style="color: black;"><strong><?php print $fetchProduct['prod_name'].'</strong><br><span style="font-size: 8pt;">'.$SHOWFLAVOR.'</span>'; ?></td>
                        <td style="color: black;"><?php print $fetchCart['cart_qty']; ?></td>
                        <td style="color: black;"><?php print $fetchProduct['prod_price']; ?></td>
                        <td style="color: black;"><?php print $fetchCart['cart_amount']; ?></td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <br>
        <br>
        <br>
        <div style="text-align: left;">
            <h5 style="color: black;">TOTAL ITEMS: <strong ><?php print $fetchCountItems['TOTALCOUNTITEMS']; ?></strong></h5>
            <h5 style="color: black;">SUB TOTAL: <strong ><?php print "₱".''.$TOTALAMOUNTWTAX; ?></strong></h5>
            <h5 style="color: black;">TAX: <strong ><?php print "₱".''.$TOTALTAXAMOUNT; ?></strong></h5>
            <h5 style="color: black;">DISCOUNT: <strong >
                <?php 
                    if($fetchDiscount['TOTALDISCOUNT'] == 0){
                        print "₱0";
                    }else{
                        print "₱".''.$fetchDiscount['TOTALDISCOUNT'];
                    } 
                ?>
            </strong></h5>
            <h3 style="color: black;">TOTAL: <strong ><?php print "₱".''.$TOTALPAYABLE; ?></strong></h3>
        </div>
        <br>
        <div style="text-align: center;">
            <h5 style="color: black;">Thank You For Your Visit</h5>
            <p style="color: black;">Please keep for your record</p>
        </div>
    </div>
</body>
</html>