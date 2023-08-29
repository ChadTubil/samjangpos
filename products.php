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
                            <li class="breadcrumb-item"><a href="dashboard.php" style="color: black;">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)" style="color: black;">Products</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->


                <div class="row">
                    <div class="col-12">
                        <div class="card" style="border: solid; border-color: black;">
                            <div class="card-header">
                                <h4 class="card-title">Products</h4>
                                <span>
                                    <button class="btn btn-success" onclick="document.location.href='products-add.php'">Add New</button>
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sqlProducts = "SELECT * FROM products_tbl WHERE prod_isdel = 0 AND prod_users_id = '$UID'";
                                                $queryProducts = mysqli_query($dbConString, $sqlProducts);
                                                while($fetchProducts = mysqli_fetch_assoc($queryProducts)) {
                                                    $STAT = $fetchProducts["prod_isactive"];
                                            ?>
                                            <tr>
                                                <td style="color: black;">
                                                    <?php 
                                                        if($fetchProducts['prod_code'] == ''){
                                                            print 'No code.';
                                                        }else{
                                                            print $fetchProducts['prod_code'];
                                                        }
                                                    ?>
                                                </td>
                                                <td style="color: black;"><?php print $fetchProducts["prod_name"] ?></td>
                                                <td style="color: black;">
                                                    <?php 
                                                        if($fetchProducts['prod_cat_id'] == ''){
                                                            print 'No category.';
                                                        }else{
                                                            $PCI = $fetchProducts['prod_cat_id'];
                                                            $sqlCategory = "SELECT * FROM categories_tbl WHERE cat_id = '$PCI'";
                                                            $queryCategory = mysqli_query($dbConString, $sqlCategory);
                                                            $fetchCategory = mysqli_fetch_assoc($queryCategory);

                                                            print $fetchCategory["cat_name"];
                                                        }
                                                    ?>
                                                </td>
                                                <td style="color: black;">
                                                    <?php 
                                                        if($fetchProducts["prod_isactive"] == 0){
                                                            print '<a style="background-color: green; color: white; padding: 5px; border-radius: 5px;">Available</a>';
                                                        }else{
                                                            print '<a style="background-color: red; color: white; padding: 5px; border-radius: 5px;">Not Available</a>';
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <button type="button" onclick="document.location.href='products-flavors.php?id=<?php print $fetchProducts['prod_id']; ?>'" class="btn btn-primary" style="height: 25px; font-size: 12px; padding: 0px 10px;"><i class="fa fa-plus"></i></button>
                                                    <button type="button" <?php if ($STAT == 0){ ?> hidden <?php   } ?> onclick="document.location.href='products-active.php?id=<?php print $fetchProducts['prod_id']; ?>'" class="btn btn-warning" style="height: 25px; font-size: 12px; padding: 0px 10px;"><i class="fa fa-check-circle"></i></button>
                                                    <button type="button" <?php if ($STAT == 1){ ?> hidden <?php   } ?> onclick="document.location.href='products-not-active.php?id=<?php print $fetchProducts['prod_id']; ?>'" class="btn btn-warning" style="height: 25px; font-size: 12px; padding: 0px 10px;"><i class="fa fa-times-circle"></i></button>
                                                    <button type="button" onclick="document.location.href='products-view.php?id=<?php print $fetchProducts['prod_id']; ?>'" class="btn btn-info" style="height: 25px; font-size: 12px; padding: 0px 10px;"><i class="fa fa-eye"></i></button>
                                                    <button type="button" onclick="document.location.href='products-edit.php?id=<?php print $fetchProducts['prod_id']; ?>'" class="btn btn-primary" style="height: 25px; font-size: 12px; padding: 0px 10px;"><i class="fa fa-edit"></i></button>
                                                    <button type="button" onclick="document.location.href='products-delete.php?id=<?php print $fetchProducts['prod_id']; ?>'" class="btn btn-danger" style="height: 25px; font-size: 12px; padding: 0px 10px;"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Code</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
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