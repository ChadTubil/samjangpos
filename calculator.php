<?php
    include 'db-controller.php';
    session_start();

    if(!(isset($_SESSION["users_id"]))) {
        header("location: default.php");
    }
    $UID = $_SESSION["users_id"];
    $sqlUsers = "SELECT * FROM users_tbl WHERE users_id = '$UID'";
    $queryUsers = mysqli_query($dbConString, $sqlUsers);
    $fetchUsers = mysqli_fetch_assoc($queryUsers);

    error_reporting(E_ERROR);

    $date = date("l m-d-Y");
    $cartdate = date("Y-m-d");

    // Items Sold
    $sqlCountItems = "SELECT SUM(cart_qty) AS TOTALCOUNTITEMS FROM cart_tbl WHERE cart_users_id = '$UID' AND cart_datecreated = '$cartdate'
    AND cart_status ='Paid'";
    $queryCountItems = mysqli_query($dbConString, $sqlCountItems);
    $fetchCountItems = mysqli_fetch_assoc($queryCountItems);

    $ITEMSSOLD = $fetchCountItems['TOTALCOUNTITEMS'];

    // Total Amount
    $sqlTotalAmount = "SELECT SUM(order_totalamount) AS TOTALAMOUNT FROM order_tbl WHERE order_users_id = '$UID' AND order_datecreated = '$cartdate'
    AND order_status ='PAID'";
    $queryTotalAmount = mysqli_query($dbConString, $sqlTotalAmount);
    $fetchTotalAmount = mysqli_fetch_assoc($queryTotalAmount);
 
    $TOTALAMOUNT = $fetchTotalAmount['TOTALAMOUNT'];

    // Total Discounted
    $sqlTotalDiscount = "SELECT SUM(order_totaldiscount) AS TOTALDISCOUNT FROM order_tbl WHERE order_users_id = '$UID' AND order_datecreated = '$cartdate'
    AND order_status ='PAID'";
    $queryTotalDiscount = mysqli_query($dbConString, $sqlTotalDiscount);
    $fetchTotalDiscount = mysqli_fetch_assoc($queryTotalDiscount);
 
    $TOTALDISCOUNT = $fetchTotalDiscount['TOTALDISCOUNT'];

    $CASHSALES = $TOTALAMOUNT - $TOTALDISCOUNT;

    if(isset($_POST['btnSearch'])) {
        $txtDate = $_POST['Date'];
        
        header("location: calculator-result.php?date=".''.$txtDate);
    }

    //Cost Dine In
    $sqlTotalDineCost = "SELECT SUM(cart_dine) AS TOTALDINECOST FROM cart_tbl WHERE cart_users_id = '$UID' AND cart_datecreated = '$cartdate'
    AND cart_status ='Paid' AND cart_order_type = 'Dine In'";
    $queryTotalDineCost = mysqli_query($dbConString, $sqlTotalDineCost);
    $fetchTotalDineCost = mysqli_fetch_assoc($queryTotalDineCost);

    //Cost Take Out
    $sqlTotalTakeCost = "SELECT SUM(cart_take) AS TOTALTAKECOST FROM cart_tbl WHERE cart_users_id = '$UID' AND cart_datecreated = '$cartdate'
    AND cart_status ='Paid' AND cart_order_type = 'Take Out'";
    $queryTotalTakeCost = mysqli_query($dbConString, $sqlTotalTakeCost);
    $fetchTotalTakeCost = mysqli_fetch_assoc($queryTotalTakeCost);

    $TOTALCOST = $fetchTotalDineCost['TOTALDINECOST'] + $fetchTotalTakeCost['TOTALTAKECOST'];

    $PROFIT = $CASHSALES - $TOTALCOST;

?>

<!DOCTYPE html>
<html lang="en">

<?php include 'body/head.php'; ?>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->
    <?php include 'body/header.php'; ?>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->


        <!--**********************************
            Sidebar start
        ***********************************-->
        <?php 
            if($UID == 1){
                include 'body/sidebar.php'; 
            }else{
                include 'body/sidebar-2.php';
            }
        ?>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0" style="background-color: #f9f937; border: solid; border-color: black;">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4 style="color: black;">PRODUCT CALCULATOR</h4>
                            <span class="ml-1" style="color: black;">Dashboard</span>
                            
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php" style="color: black;">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)" style="color: black;">Product Calculator</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card" style="border: solid; border-color: black;">
                            <div class="card-body">
                                <form method="post" role="form" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="col-sm-3">
                                            
                                        </div>
                                        <div class="col-sm-3">
                                            <label style="color: black">Select Date:</label>
                                            <input style="border-color: black; " type="date" class="form-control" name="Date" required>
                                        </div>
                                        <div class="col-sm-3">
                                            <label style="color: black">Action:</label><br>
                                            <button class="btn btn-primary" style="width: 100%" type="subtmit" name="btnSearch">SEARCH</button>
                                        </div>
                                        <div class="col-sm-3">
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-7">
                        <div class="card" style="border: solid; border-color: black;">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Qty</th>
                                                <th>Sauce</th>
                                                <th>Chicken</th>
                                                <th>Rice</th>
                                                <th>Buns</th>
                                                <th>Cheese</th>
                                                <th>Kimchi</th>
                                                <th>Lettuce</th>
                                                <th>Seaweed</th>
                                                <th>Mayo</th>
                                                <th>Egg</th>
                                                <th>Pasta</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sqlCalculate = "SELECT * FROM cart_tbl WHERE cart_isdel = 1 AND cart_users_id = '$UID' AND cart_status ='Paid' AND cart_datecreated = '$cartdate'";
                                                $queryCalculate  = mysqli_query($dbConString, $sqlCalculate);
                                                while($fetchCalculate  = mysqli_fetch_assoc($queryCalculate)) {
                                                    $CPI = $fetchCalculate["cart_prod_id"];
                                                    $CQTY = $fetchCalculate["cart_qty"];
                                            ?>
                                            <tr>
                                                <td style="color: black;">
                                                    <?php 
                                                        $CPI = $fetchCalculate["cart_prod_id"];

                                                        $sqlProduct = "SELECT * FROM products_tbl WHERE prod_id = '$CPI'";
                                                        $queryProduct = mysqli_query($dbConString, $sqlProduct);
                                                        $fetchProduct = mysqli_fetch_assoc($queryProduct);
                                                        print $fetchProduct['prod_name'];
                                                    ?>
                                                </td>
                                                <td style="color: black;"><?php print $fetchCalculate["cart_qty"] ?></td>
                                                <td style="color: black;">
                                                    <?php 
                                                        $sqlProduct = "SELECT * FROM products_tbl WHERE prod_id = '$CPI'";
                                                        $queryProduct = mysqli_query($dbConString, $sqlProduct);
                                                        $fetchProduct = mysqli_fetch_assoc($queryProduct);
                                                        $PN = $fetchProduct['prod_name'];

                                                        if($PN == 'Selfy' || $PN == 'Diet'){ //20ml Sauces
                                                            $Sauce20 = '20';
                                                            $SauceTotal20 = $Sauce20 * $CQTY;
                                                            print $SauceTotal20.''."ml";
                                                        }else if($PN == 'Besty' || $PN == 'Craving'|| $PN == 'Solo'){ //50ml Sauces
                                                            $Sauce50 = '50';
                                                            $SauceTotal50 = $Sauce50 * $CQTY;
                                                            print $SauceTotal50.''."ml";
                                                        }else if($PN == 'Family' || $PN == 'Hungry'){ //100ml Sauces
                                                            $Sauce100 = '100';
                                                            $SauceTotal100 = $Sauce100 * $CQTY;
                                                            print $SauceTotal100.''."ml";
                                                        }else if($PN == 'Groupy' || $PN == 'Starving'){ //150ml Sauces
                                                            $Sauce150 = '150';
                                                            $SauceTotal150 = $Sauce150 * $CQTY;
                                                            print $SauceTotal150.''."ml";
                                                        }else if($PN == 'Party' || $PN == 'Mukbang'){ //250ml Sauces
                                                            $Sauce250 = '250';
                                                            $SauceTotal250 = $Sauce250 * $CQTY;
                                                            print $SauceTotal250.''."ml";
                                                        }else if($PN == 'Sharing'){ //300ml Sauces
                                                            $Sauce300 = '300';
                                                            $SauceTotal300 = $Sauce300 * $CQTY;
                                                            print $SauceTotal300.''."ml";
                                                        }else if($PN == 'S1' || $PN == 'S2' || $PN == 'S3' || $PN == 'S4' || $PN == 'K1' || $PN == 'K2' || $PN == 'K3' || $PN == 'K4'){ //15ml Sauces
                                                            $Sauce15 = '15';
                                                            $SauceTotal15 = $Sauce15 * $CQTY;
                                                            print $SauceTotal15.''."ml";
                                                        }
                                                    ?>
                                                </td>
                                                <td style="color: black;">
                                                    <?php 
                                                        $sqlProduct = "SELECT * FROM products_tbl WHERE prod_id = '$CPI'";
                                                        $queryProduct = mysqli_query($dbConString, $sqlProduct);
                                                        $fetchProduct = mysqli_fetch_assoc($queryProduct);
                                                        $PN = $fetchProduct['prod_name'];

                                                        if($PN == 'S1' || $PN == 'S2' || $PN == 'S3' || $PN == 'S4' || $PN == 'Solo' || $PN == 'Sharing'){ //40Grams Chicken
                                                            $ChickGrams40 = '40';
                                                            $ChickTotalGrams40 = $ChickGrams40 * $CQTY;
                                                            print $ChickTotalGrams40.''."g";
                                                        }else if($PN == 'Selfy' || $PN == 'Diet' || $PN == 'K3' || $PN == 'K4'){ //80Grams Chicken
                                                            $ChickGrams80 = '80';
                                                            $ChickTotalGrams80 = $ChickGrams80 * $CQTY;
                                                            print $ChickTotalGrams80.''."g";
                                                        }else if($PN == 'Besty' || $PN == 'Craving'){ //200Grams Chicken
                                                            $ChickGrams200 = '200';
                                                            $ChickTotalGrams200 = $ChickGrams200 * $CQTY;
                                                            print $ChickTotalGrams200.''."g";
                                                        }else if($PN == 'Family' || $PN == 'Hungry'){ //400Grams Chicken
                                                            $ChickGrams400 = '400';
                                                            $ChickTotalGrams400 = $ChickGrams400 * $CQTY;
                                                            print $ChickTotalGrams400.''."g";
                                                        }else if($PN == 'Groupy' || $PN == 'Starving'){ //600Grams Chicken
                                                            $ChickGrams600 = '600';
                                                            $ChickTotalGrams600 = $ChickGrams600 * $CQTY;
                                                            print $ChickTotalGrams600.''."g";
                                                        }else if($PN == 'Party' || $PN == 'Mukbang'){ //1000Grams Chicken
                                                            $ChickGrams1000 = '1000';
                                                            $ChickTotalGrams1000 = $ChickGrams1000 * $CQTY;
                                                            print $ChickTotalGrams1000.''."g";
                                                        }
                                                    ?>
                                                </td>
                                                <td style="color: black;">
                                                    <?php 
                                                        $sqlProduct = "SELECT * FROM products_tbl WHERE prod_id = '$CPI'";
                                                        $queryProduct = mysqli_query($dbConString, $sqlProduct);
                                                        $fetchProduct = mysqli_fetch_assoc($queryProduct);
                                                        $PN = $fetchProduct['prod_name'];

                                                        if($PN == 'Diet' || $PN == 'Craving'){ //0.5cup Rice
                                                            $Rice05 = '0.5';
                                                            $RiceTotalRice05 = $Rice05 * $CQTY;
                                                            print $RiceTotalRice05.''."cup";
                                                        }else if($PN == 'K1' || $PN == 'K2' || $PN == 'K3' || $PN == 'K4'){ //1cup Rice
                                                            $Rice1 = '1';
                                                            $RiceTotalRice1 = $Rice1 * $CQTY;
                                                            print $RiceTotalRice1.''."cup";
                                                        }
                                                    ?>
                                                </td>
                                                <td style="color: black;">
                                                    <?php 
                                                        $sqlProduct = "SELECT * FROM products_tbl WHERE prod_id = '$CPI'";
                                                        $queryProduct = mysqli_query($dbConString, $sqlProduct);
                                                        $fetchProduct = mysqli_fetch_assoc($queryProduct);
                                                        $PN = $fetchProduct['prod_name'];

                                                        if($PN == 'S1' || $PN == 'S2' || $PN == 'S3' || $PN == 'S4'){ //1 Buns
                                                            $Buns = '1';
                                                            $TotalBuns = $Buns * $CQTY;
                                                            print $TotalBuns.''."pc";
                                                        }
                                                    ?>
                                                </td>
                                                <td style="color: black;">
                                                    <?php 
                                                        $sqlProduct = "SELECT * FROM products_tbl WHERE prod_id = '$CPI'";
                                                        $queryProduct = mysqli_query($dbConString, $sqlProduct);
                                                        $fetchProduct = mysqli_fetch_assoc($queryProduct);
                                                        $PN = $fetchProduct['prod_name'];

                                                        if($PN == 'S3' || $PN == 'S4' || $PN == 'R2'){ //1 Cheese
                                                            $Cheese = '1';
                                                            $TotalCheese = $Cheese * $CQTY;
                                                            print $TotalCheese.''."pc";
                                                        }
                                                    ?>
                                                </td>
                                                <td style="color: black;">
                                                    <?php 
                                                        $sqlProduct = "SELECT * FROM products_tbl WHERE prod_id = '$CPI'";
                                                        $queryProduct = mysqli_query($dbConString, $sqlProduct);
                                                        $fetchProduct = mysqli_fetch_assoc($queryProduct);
                                                        $PN = $fetchProduct['prod_name'];

                                                        if($PN == 'S2' || $PN == 'S4'){ //0.02g kimchi
                                                            $Kimchi = '0.02';
                                                            $TotalKimchi = $Kimchi * $CQTY;
                                                            print $TotalKimchi.''."g";
                                                        }else if($PN == 'K1' || $PN == 'K2' || $PN == 'K3' || $PN == 'K4'){ //0.06g kimchi
                                                            $Kimchi = '0.06';
                                                            $TotalKimchi = $Kimchi * $CQTY;
                                                            print $TotalKimchi.''."g";
                                                        }
                                                    ?>
                                                </td>
                                                <td style="color: black;">
                                                    <?php 
                                                        $sqlProduct = "SELECT * FROM products_tbl WHERE prod_id = '$CPI'";
                                                        $queryProduct = mysqli_query($dbConString, $sqlProduct);
                                                        $fetchProduct = mysqli_fetch_assoc($queryProduct);
                                                        $PN = $fetchProduct['prod_name'];

                                                        if($PN == 'S1' || $PN == 'S2' || $PN == 'S3' || $PN == 'S4'){ //0.02g kimchi
                                                            $Lettuce = '0.5';
                                                            $TotalLettuce = $Lettuce * $CQTY;
                                                            print $TotalLettuce.''."pc";
                                                        }
                                                    ?>
                                                </td>
                                                <td style="color: black;">
                                                    <?php 
                                                        $sqlProduct = "SELECT * FROM products_tbl WHERE prod_id = '$CPI'";
                                                        $queryProduct = mysqli_query($dbConString, $sqlProduct);
                                                        $fetchProduct = mysqli_fetch_assoc($queryProduct);
                                                        $PN = $fetchProduct['prod_name'];

                                                        if($PN == 'K1' || $PN == 'K2' || $PN == 'K3' || $PN == 'K4'){ //0.02g kimchi
                                                            $Seaweeds = '1';
                                                            $TotalSeaweeds = $Seaweeds * $CQTY;
                                                            print $TotalSeaweeds.''."sh";
                                                        }
                                                    ?>
                                                </td>
                                                <td style="color: black;">
                                                    <?php 
                                                        $sqlProduct = "SELECT * FROM products_tbl WHERE prod_id = '$CPI'";
                                                        $queryProduct = mysqli_query($dbConString, $sqlProduct);
                                                        $fetchProduct = mysqli_fetch_assoc($queryProduct);
                                                        $PN = $fetchProduct['prod_name'];

                                                        if($PN == 'S1' || $PN == 'S2' || $PN == 'S3' || $PN == 'S4'){ //0.02g kimchi
                                                            $Mayo = '1';
                                                            $TotalMayo = $Mayo * $CQTY;
                                                            print $TotalMayo.''."tbsp";
                                                        }
                                                    ?>
                                                </td>
                                                <td style="color: black;">
                                                    <?php 
                                                        $sqlProduct = "SELECT * FROM products_tbl WHERE prod_id = '$CPI'";
                                                        $queryProduct = mysqli_query($dbConString, $sqlProduct);
                                                        $fetchProduct = mysqli_fetch_assoc($queryProduct);
                                                        $PN = $fetchProduct['prod_name'];

                                                        if($PN == 'K2' || $PN == 'K4' ){ //0.02g kimchi
                                                            $Egg = '1';
                                                            $TotalEgg = $Egg * $CQTY;
                                                            print $TotalEgg.''."pc";
                                                        }
                                                    ?>
                                                </td>
                                                <td style="color: black;">
                                                    <?php 
                                                        $sqlProduct = "SELECT * FROM products_tbl WHERE prod_id = '$CPI'";
                                                        $queryProduct = mysqli_query($dbConString, $sqlProduct);
                                                        $fetchProduct = mysqli_fetch_assoc($queryProduct);
                                                        $PN = $fetchProduct['prod_name'];

                                                        if($PN == 'Solo'){ //0.02g kimchi
                                                            $Pasta4 = '0.14';
                                                            $TotalPasta4 = $Pasta4 * $CQTY;
                                                            print $TotalPasta4.''."g";
                                                        }else if($PN == 'Sharing'){ //0.02g kimchi
                                                            $Pasta84 = '0.84';
                                                            $TotalPasta84 = $Pasta84 * $CQTY;
                                                            print $TotalPasta84.''."g";
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-5">
                        <div class="card" style="border: solid; border-color: black;">
                            <div class="card-body">
                                <div class="basic-form" >
                                    <div class="form-row">
                                        <div class="col-sm-3">

                                        </div>
                                        <div class="col-sm-6" style="text-align: center">
                                            <h1 style="color: black;">Consumed</h1>
                                        </div>
                                        <div class="col-sm-3">

                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-row">
                                        <div class="col-sm-2">
                                            <p style="color: black;">Sauces:</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p style="color: black;">
                                                <strong>
                                                    <?php
                                                        $sqlSauce15 = "SELECT COUNT(cart_qty) AS TOTALCOUNTSAUCE, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('S1', 'S2','S3', 'S4','K1', 'K2','K3', 'K4')";
                                                        $querySauce15 = mysqli_query($dbConString, $sqlSauce15);
                                                        $fetchSauce15 = mysqli_fetch_assoc($querySauce15);

                                                        $TotalSauce15 = $fetchSauce15['TOTALCOUNTSAUCE'];
                                                        $SUMSAUCE15 = $TotalSauce15 * '15';
                                                        // 20
                                                        $sqlSauce20 = "SELECT COUNT(cart_qty) AS TOTALCOUNTSAUCE, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('Selfy', 'Diet')";
                                                        $querySauce20 = mysqli_query($dbConString, $sqlSauce20);
                                                        $fetchSauce20 = mysqli_fetch_assoc($querySauce20);

                                                        $TotalSauce20 = $fetchSauce20['TOTALCOUNTSAUCE'];
                                                        $SUMSAUCE20 = $TotalSauce20 * '20';
                                                        // 50
                                                        $sqlSauce50 = "SELECT COUNT(cart_qty) AS TOTALCOUNTSAUCE, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('Besty', 'Craving', 'Solo')";
                                                        $querySauce50 = mysqli_query($dbConString, $sqlSauce50);
                                                        $fetchSauce50 = mysqli_fetch_assoc($querySauce50);

                                                        $TotalSauce50 = $fetchSauce50['TOTALCOUNTSAUCE'];
                                                        $SUMSAUCE50 = $TotalSauce50 * '50';
                                                        // 100
                                                        $sqlSauce100 = "SELECT COUNT(cart_qty) AS TOTALCOUNTSAUCE, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('Family', 'Hungry')";
                                                        $querySauce100 = mysqli_query($dbConString, $sqlSauce100);
                                                        $fetchSauce100 = mysqli_fetch_assoc($querySauce100);

                                                        $TotalSauce100 = $fetchSauce100['TOTALCOUNTSAUCE'];
                                                        $SUMSAUCE100 = $TotalSauce100 * '100';
                                                        // 150
                                                        $sqlSauce150 = "SELECT COUNT(cart_qty) AS TOTALCOUNTSAUCE, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('Groupy', 'Starving')";
                                                        $querySauce150 = mysqli_query($dbConString, $sqlSauce150);
                                                        $fetchSauce150 = mysqli_fetch_assoc($querySauce150);

                                                        $TotalSauce150 = $fetchSauce150['TOTALCOUNTSAUCE'];
                                                        $SUMSAUCE150 = $TotalSauce150 * '150';
                                                        // 250
                                                        $sqlSauce250 = "SELECT COUNT(cart_qty) AS TOTALCOUNTSAUCE, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('Party', 'Mukbang')";
                                                        $querySauce250 = mysqli_query($dbConString, $sqlSauce250);
                                                        $fetchSauce250 = mysqli_fetch_assoc($querySauce250);

                                                        $TotalSauce250 = $fetchSauce250['TOTALCOUNTSAUCE'];
                                                        $SUMSAUCE250 = $TotalSauce250 * '250';
                                                        // 300
                                                        $sqlSauce300 = "SELECT COUNT(cart_qty) AS TOTALCOUNTSAUCE, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('Sharing')";
                                                        $querySauce300 = mysqli_query($dbConString, $sqlSauce300);
                                                        $fetchSauce300 = mysqli_fetch_assoc($querySauce300);

                                                        $TotalSauce300 = $fetchSauce300['TOTALCOUNTSAUCE'];
                                                        $SUMSAUCE300 = $TotalSauce250 * '300';

                                                        $TOTALSUMSAUCE = $SUMSAUCE15 + $SauceTotal20 + $SauceTotal50 + $SauceTotal100 + $SauceTotal150 + $SauceTotal250 + $SauceTotal300;
                                                        print $TOTALSUMSAUCE.' '."l";
                                                    ?>
                                                </strong>
                                            </p> 
                                        </div>
                                        <div class="col-sm-2">
                                            <p style="color: black;">Chicken:</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p style="color: black;">
                                                <strong>
                                                    <?php
                                                        $sqlChick40 = "SELECT COUNT(cart_qty) AS TOTALCOUNTCHICK, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('S1', 'S2','S3', 'S4','Solo', 'Sharing')";
                                                        $queryChick40 = mysqli_query($dbConString, $sqlChick40);
                                                        $fetchChick40 = mysqli_fetch_assoc($queryChick40);

                                                        $TotalChick40 = $fetchChick40['TOTALCOUNTCHICK'];
                                                        $SUMChick40 = $TotalChick40 * '40';
                                                        // 80
                                                        $sqlChick80 = "SELECT COUNT(cart_qty) AS TOTALCOUNTCHICK, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('Selfy', 'Diet','K3', 'K4')";
                                                        $queryChick80 = mysqli_query($dbConString, $sqlChick80);
                                                        $fetchChick80 = mysqli_fetch_assoc($queryChick80);

                                                        $TotalChick80 = $fetchChick80['TOTALCOUNTCHICK'];
                                                        $SUMChick80 = $TotalChick80 * '80';
                                                        // 200
                                                        $sqlChick200 = "SELECT COUNT(cart_qty) AS TOTALCOUNTCHICK, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('Besty', 'Craving')";
                                                        $queryChick200 = mysqli_query($dbConString, $sqlChick200);
                                                        $fetchChick200 = mysqli_fetch_assoc($queryChick200);

                                                        $TotalChick200 = $fetchChick200['TOTALCOUNTCHICK'];
                                                        $SUMChick200 = $TotalChick200 * '200';
                                                        // 400
                                                        $sqlChick400 = "SELECT COUNT(cart_qty) AS TOTALCOUNTCHICK, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('Family', 'Hungry')";
                                                        $queryChick400 = mysqli_query($dbConString, $sqlChick400);
                                                        $fetchChick400 = mysqli_fetch_assoc($queryChick400);

                                                        $TotalChick400 = $fetchChick400['TOTALCOUNTCHICK'];
                                                        $SUMChick400 = $TotalChick400 * '400';
                                                        // 600
                                                        $sqlChick600 = "SELECT COUNT(cart_qty) AS TOTALCOUNTCHICK, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('Groupy', 'Starving')";
                                                        $queryChick600 = mysqli_query($dbConString, $sqlChick600);
                                                        $fetchChick600 = mysqli_fetch_assoc($queryChick600);

                                                        $TotalChick600 = $fetchChick600['TOTALCOUNTCHICK'];
                                                        $SUMChick600 = $TotalChick600 * '600';
                                                        // 1000
                                                        $sqlChick1000 = "SELECT COUNT(cart_qty) AS TOTALCOUNTCHICK, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('Party', 'Mukbang')";
                                                        $queryChick1000 = mysqli_query($dbConString, $sqlChick1000);
                                                        $fetchChick1000 = mysqli_fetch_assoc($queryChick1000);

                                                        $TotalChick1000 = $fetchChick1000['TOTALCOUNTCHICK'];
                                                        $SUMChick1000 = $TotalChick1000 * '1000';

                                                        $SUMChick = $SUMChick40 + $SUMChick80 + $SUMChick200 + $SUMChick400 + $SUMChick600 + $SUMChick1000;
                                                        print $SUMChick.' '."kg";
                                                    ?>
                                                </strong>
                                            </p> 
                                        </div>
                                        <div class="col-sm-2">
                                            <p style="color: black;">Rice:</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p style="color: black;">
                                                <strong>
                                                    <?php
                                                        $sqlRice5 = "SELECT COUNT(cart_qty) AS TOTALCOUNTCHICK, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('Diet', 'Craving')";
                                                        $queryRice5 = mysqli_query($dbConString, $sqlRice5);
                                                        $fetchRice5 = mysqli_fetch_assoc($queryRice5);

                                                        $TotalRice5 = $fetchRice5['TOTALCOUNTCHICK'];
                                                        $SUMRice5 = $TotalRice5 * '0.5';

                                                        $sqlRice1 = "SELECT COUNT(cart_qty) AS TOTALCOUNTCHICK, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('K1', 'K2', 'K3', 'K4')";
                                                        $queryRice1 = mysqli_query($dbConString, $sqlRice1);
                                                        $fetchRice1 = mysqli_fetch_assoc($queryRice1);

                                                        $TotalRice1 = $fetchRice1['TOTALCOUNTCHICK'];
                                                        $SUMRice1 = $TotalRice1 * '1';

                                                        $SUMRICE = $SUMRice5 + $SUMRice1;
                                                        print $SUMRICE.' '."cup";
                                                    ?>
                                                </strong>
                                            </p> 
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-sm-2">
                                            <p style="color: black;">Buns:</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p style="color: black;">
                                                <strong>
                                                    <?php
                                                        $sqlBuns = "SELECT COUNT(cart_qty) AS TOTALCOUNTBUNS, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('S1', 'S2', 'S3', 'S4')";
                                                        $queryBuns = mysqli_query($dbConString, $sqlBuns);
                                                        $fetchBuns = mysqli_fetch_assoc($queryBuns);

                                                        $TotalBuns = $fetchBuns['TOTALCOUNTBUNS'];
                                                        $SUMBuns = $TotalBuns * '1';
                                                        print $SUMBuns.' '."pc";
                                                    ?>
                                                </strong>
                                            </p> 
                                        </div>
                                        <div class="col-sm-2">
                                            <p style="color: black;">Cheese:</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p style="color: black;">
                                                <strong>
                                                    <?php
                                                        $sqlCheese = "SELECT COUNT(cart_qty) AS TOTALCOUNTCHEESE, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('R2', 'S3', 'S4')";
                                                        $queryCheese = mysqli_query($dbConString, $sqlCheese);
                                                        $fetchCheese = mysqli_fetch_assoc($queryCheese);

                                                        $TotalCheese = $fetchCheese['TOTALCOUNTCHEESE'];
                                                        $SUMCheese = $TotalCheese * '1';
                                                        print $SUMCheese.' '."pc";
                                                    ?>
                                                </strong>
                                            </p> 
                                        </div>
                                        <div class="col-sm-2">
                                            <p style="color: black;">Kimchi:</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p style="color: black;">
                                                <strong>
                                                    <?php
                                                        $sqlKimchi02 = "SELECT COUNT(cart_qty) AS TOTALCOUNTKIMCHI, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('S2', 'S4')";
                                                        $queryKimchi02 = mysqli_query($dbConString, $sqlKimchi02);
                                                        $fetchKimchi02 = mysqli_fetch_assoc($queryKimchi02);

                                                        $TotalKimchi02 = $fetchKimchi02['TOTALCOUNTKIMCHI'];
                                                        $SUMKimchi02 = $TotalKimchi02 * '0.02';

                                                        $sqlKimchi06 = "SELECT COUNT(cart_qty) AS TOTALCOUNTKIMCHI6, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('K1', 'K2', 'K3', 'K4')";
                                                        $queryKimchi06 = mysqli_query($dbConString, $sqlKimchi06);
                                                        $fetchKimchi06 = mysqli_fetch_assoc($queryKimchi06);

                                                        $TotalKimchi06 = $fetchKimchi06['TOTALCOUNTKIMCHI6'];
                                                        $SUMKimchi06 = $TotalKimchi06 * '0.06';

                                                        $SUMKIMCHI = $SUMKimchi06 + $SUMKimchi02;
                                                        print $SUMKIMCHI.' '."kg";
                                                    ?>
                                                </strong>
                                            </p> 
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-sm-2">
                                            <p style="color: black;">Mayo:</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p style="color: black;">
                                                <strong>
                                                    <?php
                                                        $sqlMayo = "SELECT COUNT(cart_qty) AS TOTALCOUNTMAYO, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('S1', 'S2', 'S3 ', 'S4')";
                                                        $queryMayo = mysqli_query($dbConString, $sqlMayo);
                                                        $fetchMayo = mysqli_fetch_assoc($queryMayo);

                                                        $TotalMayo = $fetchMayo['TOTALCOUNTMAYO'];
                                                        $SUMMayo = $TotalMayo * '1';
                                                        print $SUMMayo.' '."tbsp";
                                                    ?>
                                                </strong>
                                            </p> 
                                        </div>
                                        <div class="col-sm-2">
                                            <p style="color: black;">Lettuce:</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p style="color: black;">
                                                <strong>
                                                    <?php
                                                        $sqlLettuce = "SELECT COUNT(cart_qty) AS TOTALCOUNTLETTUCE, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('S1', 'S2', 'S3 ', 'S4')";
                                                        $queryLettuce = mysqli_query($dbConString, $sqlLettuce);
                                                        $fetchLettuce = mysqli_fetch_assoc($queryLettuce);

                                                        $TotalLettuce = $fetchLettuce['TOTALCOUNTLETTUCE'];
                                                        $SUMLettuce = $TotalLettuce * '0.5';
                                                        print $SUMLettuce.' '."leaf";
                                                    ?>
                                                </strong>
                                            </p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p style="color: black;">Egg:</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p style="color: black;">
                                                <strong>
                                                    <?php
                                                        $sqlEgg = "SELECT COUNT(cart_qty) AS TOTALCOUNTEGG, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('K2', 'K4')";
                                                        $queryEgg = mysqli_query($dbConString, $sqlEgg);
                                                        $fetchEgg = mysqli_fetch_assoc($queryEgg);

                                                        $TotalEgg = $fetchEgg['TOTALCOUNTEGG'];
                                                        $SUMEgg = $TotalEgg * '1';
                                                        print $SUMEgg.' '."pc";
                                                    ?>
                                                </strong>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-sm-2">
                                            <p style="color: black;">Pasta:</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p style="color: black;">
                                                <strong>
                                                    <?php
                                                        $sqlPasta14 = "SELECT COUNT(cart_qty) AS TOTALCOUNTPASTA14, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name = 'Solo'";
                                                        $queryPasta14 = mysqli_query($dbConString, $sqlPasta14);
                                                        $fetchPasta14 = mysqli_fetch_assoc($queryPasta14);

                                                        $TotalPasta14 = $fetchPasta14['TOTALCOUNTPASTA14'];
                                                        $SUMPasta14 = $TotalPasta14 * '0.14';

                                                        $sqlPasta84 = "SELECT COUNT(cart_qty) AS TOTALPASTA84, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name = 'Sharing'";
                                                        $queryPasta84 = mysqli_query($dbConString, $sqlPasta84);
                                                        $fetchPasta84 = mysqli_fetch_assoc($queryPasta84);

                                                        $TotalPasta84 = $fetchPasta84['TOTALPASTA84'];
                                                        $SUMPasta84 = $TotalPasta84 * '0.84';

                                                        $SUMPASTA= $SUMPasta14 + $SUMPasta84;
                                                        print $SUMPASTA.' '."kg";
                                                    ?>
                                                </strong>
                                            </p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p style="color: black;">Seaweed:</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p style="color: black;">
                                                <strong>
                                                    <?php
                                                        $sqlSeaweed = "SELECT COUNT(cart_qty) AS TOTALSEAWEED, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('K1', 'K2', 'K3', 'K4')";
                                                        $querySeaweed = mysqli_query($dbConString, $sqlSeaweed);
                                                        $fetchSeaweed = mysqli_fetch_assoc($querySeaweed);

                                                        $TotalSeaweed = $fetchSeaweed['TOTALSEAWEED'];
                                                        $SUMSeaweed = $TotalSeaweed * '1';
                                                        print $SUMSeaweed.' '."sheet";
                                                    ?>
                                                </strong>
                                            </p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p style="color: black;">Ramyeon:</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p style="color: black;">
                                                <strong>
                                                    <?php
                                                        $sqlRam = "SELECT COUNT(cart_qty) AS TOTALSEAWEED, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('R1', 'R2', 'R3', 'R4')";
                                                        $queryRam = mysqli_query($dbConString, $sqlRam);
                                                        $fetchRam = mysqli_fetch_assoc($queryRam);

                                                        $TotalRam = $fetchRam['TOTALSEAWEED'];
                                                        $SUMRam = $TotalRam * '1';
                                                        print $SUMRam.' '."pc";
                                                    ?>
                                                </strong>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-sm-2">
                                            <p style="color: black;">Milk:</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <p style="color: black;">
                                                <strong>
                                                    <?php
                                                        $sqlMilk = "SELECT COUNT(cart_qty) AS TOTALMILK, prod_name FROM cart_tbl LEFT JOIN products_tbl ON cart_prod_id = prod_id WHERE cart_users_id = '$UID' 
                                                        AND cart_isdel = '1' AND cart_status = 'Paid' AND cart_datecreated = '$cartdate' AND prod_name IN ('R3', 'R4')";
                                                        $queryMilk = mysqli_query($dbConString, $sqlMilk);
                                                        $fetchMilk = mysqli_fetch_assoc($queryMilk);

                                                        $TotalMilk = $fetchMilk['TOTALMILK'];
                                                        $SUMMilk = $TotalMilk * '200';

                                                        print $SUMMilk.' '."ml";
                                                    ?>
                                                </strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        <?php include 'body/footer.php'; ?>
        <!--**********************************
            Footer end
        ***********************************-->

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <?php include 'body/scripts.php'; ?>

</body>

</html>