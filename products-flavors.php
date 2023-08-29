<?php
    include 'db-controller.php';
    session_start();

    if(!(isset($_SESSION["users_id"]))) {
        header("location: default.php");
    }
    $UID = $_SESSION["users_id"];
    $id = $_GET["id"];
    $sqlProducts = "SELECT * FROM products_tbl WHERE prod_id = '$id'";
    $queryProducts = mysqli_query($dbConString, $sqlProducts);
    $fetchProducts = mysqli_fetch_assoc($queryProducts);

    if(isset($_POST['btnSave'])) {
        $txtName = $_POST['Flavor'];
        $date = date('Y-m-d');

        $sqlCheck = "SELECT flavor_name FROM flavors_tbl WHERE flavor_name = '$txtName' AND flavor_users_id = '$UID' AND flavor_prod_id ='$id'";
        $queryCheck = mysqli_query($dbConString, $sqlCheck);

        if(mysqli_num_rows($queryCheck) > 0){
            $message = "Flavor is already exists. Please try enter another.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }else{
            $sqlAdd = "INSERT INTO flavors_tbl() VALUES (NULL, '$UID', '$id', '$txtName', '$date', 0)";
            mysqli_query($dbConString, $sqlAdd);

            $sqlUpdate = "UPDATE products_tbl SET prod_flavor = 1 WHERE prod_id = '$id'";
            mysqli_query($dbConString, $sqlUpdate);

            header("location: products-flavors.php?id=".''.$id);
        }
    }
    
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
                            <h4 style="color: black;">PRODUCTS</h4>
                            <span class="ml-1" style="color: black;">Inventory</span>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php" style="color: black;">Products</a></li>
                            <li class="breadcrumb-item active" ><a href="javascript:void(0)" style="color: black;">Flavors</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->


                <div class="row">
                    <div class="col-6">
                        <div class="card" style="border: solid; border-color: black;">
                            <div class="card-body">
                                <form method="post" role="form" enctype="multipart/form-data">
                                    <div class="card-body" style="padding-bottom: 0px;">
                                        <div class="basic-form" >
                                            <div class="form-row">
                                                <div class="col-sm-3">

                                                </div>
                                                <div class="col-sm-6" style="text-align: center">
                                                    <img src="image/<?php print $fetchProducts["prod_image"]; ?>" alt="" style="width: 200px; height: 200px; border-color: black;">
                                                </div>
                                                <div class="col-sm-3">

                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-sm-5">
                                                    <label style="color: black">Product Code:</label>
                                                    <h3 style="color: black;"><?php print $fetchProducts['prod_code']; ?></h3>
                                                </div>
                                                <div class="col-sm-7">
                                                    <label style="color: black">Name:</label>
                                                    <h3 style="color: black;"><?php print $fetchProducts['prod_name']; ?></h3>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-sm-5">
                                                    <label style="color: black">Category:</label>
                                                    <h3 style="color: black;">
                                                        <?php 
                                                            $PCI = $fetchProducts['prod_cat_id']; 
                                                            $sqlCategory = "SELECT * FROM categories_tbl WHERE cat_id = '$PCI'";
                                                            $queryCategory = mysqli_query($dbConString, $sqlCategory);
                                                            $fetchCategory = mysqli_fetch_assoc($queryCategory);

                                                            print $fetchCategory['cat_name'];
                                                        ?>
                                                    </h3>
                                                </div>
                                                <div class="col-sm-7">
                                                    <label style="color: black">Description:</label>
                                                    <h3 style="color: black;">
                                                        <?php 
                                                            print $fetchProducts['prod_description'];
                                                        ?>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-sm-3">
                                                    <label style="color: black">Cost (Dine In):</label>
                                                    <h3 style="color: black;">
                                                        <?php 
                                                            print $fetchProducts['prod_dine'];
                                                        ?>
                                                    </h3>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label style="color: black">Cost (Take Out):</label>
                                                    <h3 style="color: black;">
                                                        <?php 
                                                            print $fetchProducts['prod_take'];
                                                        ?>
                                                    </h3>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label style="color: black">Price:</label>
                                                    <h3 style="color: black;">
                                                        <?php 
                                                            print $fetchProducts['prod_price'];
                                                        ?>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="card" style="border: solid; border-color: black;">
                            <div class="card-header">
                                <h4 class="card-title" style="color:black">Add Flavors</h4>
                            </div>
                            <div class="card-body">
                                    <div class="card-body" style="padding-bottom: 0px;">
                                        <form method="post" role="form" enctype="multipart/form-data">
                                            <div class="basic-form" >
                                                <div class="form-row">
                                                    <div class="col-sm-9">
                                                        <input style="border-color: black; " type="text" class="form-control" name="Flavor" required>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <button class="btn btn-primary" type="submit" name="btnSave" style="width: 100%;">Add</button>
                                                    </div>
                                                </div>
                                                <br>
                                                <table class="table table-responsive-sm">
                                                    <thead>
                                                        <tr>
                                                            <th style="color: white; background-color: green;">Flavors</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $sqlFlavors = "SELECT * FROM flavors_tbl WHERE flavor_isdel = 0 AND flavor_users_id = '$UID' AND flavor_prod_id = '$id'";
                                                            $queryFlavors = mysqli_query($dbConString, $sqlFlavors);
                                                            while($fetchFlavors = mysqli_fetch_assoc($queryFlavors)) {
                                                        ?>
                                                        <tr>
                                                            <th style="color: black"><?php print $fetchFlavors['flavor_name']; ?></th>
                                                        </tr>
                                                    </tbody>
                                                    <?php
                                                        }
                                                    ?>
                                                </table>
                                            </div>
                                        </form>
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