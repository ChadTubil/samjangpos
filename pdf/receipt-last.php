<?php
    require('fpdf.php');

    class PDF extends FPDF{

        function Header(){
            $this->SetMargins(3, 5, 3);
            $this->SetFont('Times', 'B', 9);
            $this->Cell(25, 10, "SAM JANG POS", 0, 0, 'C');
            $this->LN(5);
            $this->SetFont('Times', 'B', 12);
            $this->Cell(38, 10, "CASH RECEIPT", 0, 0, 'C');
            $this->LN(15);
        }
        function Body(){
            include '../db-controller.php';
            session_start();
            date_default_timezone_set("Asia/Manila");
            $UID = $_SESSION["users_id"];

            $sqlOrderNumber = "SELECT MAX(order_number) AS LASTORDERNUM FROM order_tbl WHERE order_users_id = '$UID'";
            $queryOrderNumber = mysqli_query($dbConString, $sqlOrderNumber);
            $fetchOrderNumber = mysqli_fetch_assoc($queryOrderNumber);
            $ON = $fetchOrderNumber['LASTORDERNUM'];

            $sqlOrder = "SELECT * FROM order_tbl WHERE order_number = '$ON'";
            $queryOrder = mysqli_query($dbConString, $sqlOrder);
            $fetchOrder = mysqli_fetch_assoc($queryOrder);
            $OID = $fetchOrder['order_id'];
            $ODate = $fetchOrder['order_datecreated'];
            $newDate = date("l d-m-Y", strtotime($ODate));

            $OCus = $fetchOrder['order_cus_id'];
            $this->SetMargins(3, 5 ,3);
            $this->SetFont('Times', 'B', 12);
            $this->Cell(37, 10, "Receipt No.:".''.$ON, 0, 0, 'L');
            $this->LN(5);
            $this->SetFont('Times', '', 8);
            $this->Cell(37, 10, $newDate, 0, 0, 'L');
            $this->LN(5);
            if($OCus == 0){
                $this->Cell(37, 10, "Walk-In Client", 0, 0, 'L');
            }else{
                $sqlCustomer = "SELECT * FROM customers_tbl WHERE cus_id = '$OCus'";
                $queryCustomer = mysqli_query($dbConString, $sqlCustomer);
                $fetchCustomer = mysqli_fetch_assoc($queryCustomer);

                $this->Cell(37, 10, $fetchCustomer['cus_name'], 0, 0, 'L');
            }
            $this->LN(5);
            $this->Line(3, 50, 47, 50);
            $this->LN(5);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(9, 10, "ITEM", 0, 0, 'L');
            $this->Cell(9, 10, "QTY", 0, 0, 'L');
            $this->Cell(9, 10, "PRICE", 0, 0, 'L');
            $this->Cell(9, 10, "AMOUNT", 0, 0, 'L');
            $this->LN(10);
            $sqlCart = "SELECT * FROM cart_tbl WHERE cart_users_id = '$UID' AND cart_order_id = '$OID' AND cart_isdel = 1 AND cart_status = 'Paid'";
            $queryCart = mysqli_query($dbConString, $sqlCart);
            while($fetchCart = mysqli_fetch_assoc($queryCart)){
                $CPID = $fetchCart['cart_prod_id'];
                $sqlProduct = "SELECT * FROM products_tbl WHERE prod_id = '$CPID'";
                $queryProduct = mysqli_query($dbConString, $sqlProduct);
                $fetchProduct = mysqli_fetch_assoc($queryProduct);

                $this->SetFont('Arial', '', 8);
                $this->Cell(10, 10, $fetchProduct['prod_name'], 0, 0, 'L');
                $this->Cell(10, 10, $fetchCart['cart_qty'], 0, 0, 'L');
                $this->Cell(10, 10, $fetchProduct['prod_price'], 0, 0, 'L');
                $this->Cell(10, 10, $fetchCart['cart_amount'], 0, 0, 'L');
                $this->LN(5);
            }
            $this->SetFont('Arial', 'B', 9);

            $sqlCountItems = "SELECT SUM(cart_qty) AS TOTALCOUNTITEMS FROM cart_tbl WHERE cart_users_id = '$UID' AND cart_order_id = '$OID' AND cart_isdel = 1 AND cart_status = 'Paid'";
            $queryCountItems = mysqli_query($dbConString, $sqlCountItems);
            $fetchCountItems = mysqli_fetch_assoc($queryCountItems);
            $this->LN(5);
            $this->Cell(20, 10, "ITEMS COUNT: ", 0, 0, 'L');
            $this->Cell(20, 10, $fetchCountItems['TOTALCOUNTITEMS'], 0, 0, 'R');
            $this->LN(5);

            $sqlAmountItems = "SELECT SUM(cart_amount) AS TOTALAMOUNTITEMS FROM cart_tbl WHERE cart_users_id = '$UID' AND cart_order_id = '$OID' AND cart_isdel = 1 AND cart_status = 'Paid'";
            $queryAmountItems = mysqli_query($dbConString, $sqlAmountItems);
            $fetchAmountItems = mysqli_fetch_assoc($queryAmountItems);

            $TOTALAMOUNTWOTAX = $fetchAmountItems['TOTALAMOUNTITEMS'];
            $AMOUNTTAX = '0.03';
            $TOTALTAXAMOUNT = $TOTALAMOUNTWOTAX * $AMOUNTTAX;
            $TOTALAMOUNTWTAX = $TOTALAMOUNTWOTAX - $TOTALTAXAMOUNT;
            
            $this->Cell(20, 10, "SUB TOTAL: ", 0, 0, 'L');
            $this->Cell(20, 10, $TOTALAMOUNTWTAX, 0, 0, 'R');
            $this->LN(5);
            $this->Cell(20, 10, "TAX: ", 0, 0, 'L');
            $this->Cell(20, 10, $TOTALTAXAMOUNT, 0, 0, 'R');
            $this->LN(5);

            $sqlDiscount = "SELECT SUM(cart_discount) AS TOTALDISCOUNT FROM cart_tbl WHERE cart_users_id = '$UID' AND cart_order_id = '$OID' AND cart_isdel = 1 AND cart_status = 'Paid'";
            $queryDiscount = mysqli_query($dbConString, $sqlDiscount);
            $fetchDiscount = mysqli_fetch_assoc($queryDiscount);

            if($fetchDiscount['TOTALDISCOUNT'] == 0){
                $this->Cell(20, 10, "DISCOUNT: ", 0, 0, 'L');
                $this->Cell(20, 10, "0", 0, 0, 'R');
            }else{
                $this->Cell(20, 10, "DISCOUNT: ", 0, 0, 'L');
                $this->Cell(20, 10, $fetchDiscount['TOTALDISCOUNT'], 0, 0, 'R');
            }

            $TOTALDISCOUNT = $fetchDiscount['TOTALDISCOUNT'];                             
            $TOTALPAYABLE = $TOTALAMOUNTWOTAX - $TOTALDISCOUNT;

            $this->SetFont('Arial', 'B', 12);
            $this->LN(5);
            $this->Cell(20, 10, "TOTAL: ", 0, 0, 'L');
            $this->Cell(20, 10, $TOTALPAYABLE, 0, 0, 'R');
            $this->LN(10);
            $this->SetFont('Arial','B',9);
            $this->Cell(38, 10, "Thank You For Your Visit", 0, 0, 'C');
            $this->LN(3);
            $this->SetFont('Arial','',8);
            $this->Cell(38, 10, "Please keep for your record", 0, 0, 'C');
        }
        function Footer()
	    {  
            
            // Position at 1.5 cm from bottom
            // $this->SetY(-30);
            // Page number
            // Arial italic 8
            
	    }

    }
    // Instanciation of inherited class
    // $pdf = new PDF('P','mm', 'Letter');
    $pdf = new PDF('P','mm',array(58,250));
    
    // $pdf->AliasNbPages();
    
    $pdf->AddPage();
    $pdf->Body();
    $pdf->Output();
?>