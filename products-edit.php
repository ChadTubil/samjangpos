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
        $txtImage = $_FILES["fileUpload"]["name"];
        $txtCode = $_POST['Code'];
        $txtName = $_POST['Name'];
        $txtCategory = $_POST['Category'];
        $txtDine = $_POST['Dine'];
        $txtTake = $_POST['Take'];
        $txtPrice = $_POST['Price'];
        $txtDescription = $_POST['Description'];
        $date = date('Y-m-d');

        
        $sqlUpdate = "UPDATE products_tbl SET prod_image = '$txtImage', prod_code = '$txtCode', prod_name = '$txtName',
        prod_cat_id = $txtCategory, prod_dine = '$txtDine', prod_take = '$txtTake', prod_price = '$txtPrice', prod_description = '$txtDescription' WHERE prod_id = '$id'";
        mysqli_query($dbConString, $sqlUpdate);

        move_uploaded_file($_FILES["fileUpload"]["tmp_name"], "image/".$_FILES["fileUpload"]["name"]);

        header("location: products.php");
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
                            <li class="breadcrumb-item active"><a href="javascript:void(0)" style="color: black;">Edit</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->


                <div class="row">
                    <div class="col-12">
                        <div class="card" style="border: solid; border-color: black;">
                            <div class="card-header">
                                <h4 class="card-title">Edit Product</h4>
                                <!-- <span>
                                    <button class="btn btn-success" onclick="document.location.href='course-year-add.php'">Add Course</button>
                                </span> -->
                            </div>
                            <div class="card-body">
                                <form method="post" role="form" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="basic-form">
                                            <div class="form-row">
                                                <div class="col-sm-4">
                                                    <label style="color: black;">Code</label>
                                                    <input style="border-color: black; "type="text" class="form-control" value="<?php print $fetchProducts["prod_code"]; ?>" name="Code">
                                                </div>
                                                <div class="col-sm-8">
                                                    <label style="color: black">Name</label>
                                                    <input style="border-color: black; " type="text" class="form-control" value="<?php print $fetchProducts["prod_name"]; ?>" name="Name" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-sm-4">
                                                    <label style="color: black;">Category</label>
                                                    <select class="form-control" name="Category" style="border-color: black;" required>
                                                        <option value="<?php print $fetchProducts["prod_cat_id"]; ?>" selected>
                                                            <?php
                                                                $PCI = $fetchProducts["prod_cat_id"];
                                                                $sqlCategory = "SELECT * FROM categories_tbl WHERE cat_id = '$PCI'";
                                                                $queryCategory = mysqli_query($dbConString, $sqlCategory);
                                                                $fetchCategory = mysqli_fetch_assoc($queryCategory);

                                                                print $fetchCategory["cat_name"];
                                                            ?>
                                                        </option>
                                                        <?php
                                                            $sqlCourier = mysqli_query($dbConString, "SELECT cat_id, cat_name FROM categories_tbl WHERE cat_isdel = 0");  // Use select query here 

                                                            while($data = mysqli_fetch_array($sqlCourier))
                                                            {
                                                                echo "<option value='". $data['cat_id'] ."'>" .$data['cat_name'] ."</option>";  // displaying data in option menu //first id second display
                                                            }	
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label style="color: black">Cost (Dine In)</label>
                                                    <input style="border-color: black; " type="text" class="form-control" value="<?php print $fetchProducts["prod_dine"]; ?>" name="Dine" required>
                                                </div> 
                                                <div class="col-sm-2">
                                                    <label style="color: black">Cost (Take Out)</label>
                                                    <input style="border-color: black; " type="text" class="form-control" value="<?php print $fetchProducts["prod_take"]; ?>" name="Take" required>
                                                </div> 
                                                <div class="col-sm-4">
                                                    <label style="color: black">Price</label>
                                                    <input style="border-color: black; " type="text" class="form-control" value="<?php print $fetchProducts["prod_price"]; ?>" name="Price" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-sm-7">
                                                    <label style="color: black;">Description</label>
                                                    <textarea style="border-color: black; " type="text" class="form-control" name="Description"><?php print $fetchProducts["prod_description"]; ?></textarea>
                                                </div>
                                                <div class="col-sm-5">
                                                    <label style="color: black;">Image</label>
                                                        <div class="control-group file-upload" id="file-upload">
                                                            <div class="image-box text-center" style="border-style: groove; border-color: black;">
                                                                <p style="padding-top: 2%; color: black;"><i class="fa fa-upload"></i> Change Image</p>
                                                                <img src="image/<?php print $fetchProducts["prod_image"]; ?>" alt="" style="width: 200px; height: 200px;" required>
                                                            </div>
                                                            <div class="controls" style="display: none;">
                                                                    <input type="file" name="fileUpload" value="<?php print $fetchProducts["prod_image"]; ?>">
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer" style="text-align: right;">
                                        <button class="btn btn-primary" type="submit" name="btnSave">SAVE</button>
                                    </div>
                                </form>
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
    <script>
        $(".image-box").click(function(event) {
            var previewImg = $(this).children("img");

            $(this)
                .siblings()
                .children("input")
                .trigger("click");

            $(this)
                .siblings()
                .children("input")
                .change(function() {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var urll = e.target.result;
                        $(previewImg).attr("src", urll);
                        previewImg.parent().css("background", "transparent");
                        previewImg.show();
                        previewImg.siblings("p").hide();
                    };
                    reader.readAsDataURL(this.files[0]);
                });
        });
    </script>

</body>

</html>