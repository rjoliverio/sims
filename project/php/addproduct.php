<?php
    session_start();
    include_once('dbconnect.php');
    if(isset($_SESSION['empid'])){
        $res=runQuery($conn,"SELECT * FROM employee_accounts INNER JOIN person_info ON employee_accounts.Person_id=person_info.Person_id WHERE employee_accounts.Employee_id='{$_SESSION['empid']}'");
        $res=mysqli_fetch_array($res);
    }else{
        header("Location: ../index.php");
    }
    if(isset($_SESSION['empid'])&&$res['Person_type']!="Manager"){
        header("Location: /project/php/cashierdashboard.php");
    }

    if(isset($_POST['submit_prod'])){
        if(isset($_SESSION['alert_prod'])){
            unset($_SESSION['alert_prod']);
        }
        $prodname=$_POST['name_prod'];
        $prodtype=$_POST['type_prod'];
        $qty=$_POST['qty_prod'];
        $price=$_POST['price_prod'];
        $expiry=$_POST['expiry_prod'];
        $supplier=$_POST['supplier_prod'];

        $query="INSERT INTO `products`(`ProdName`,`ProdType`,`Qty`,`Price`,`Expiry_date`,`Supplier_id`) VALUES ('$prodname','$prodtype','$qty','$price','$expiry','$supplier')";
        if(mysqli_query($conn,$query)){
            $_SESSION['alert_prod']="true";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Products</title>
        <link href="../css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/qrcode.js"></script>
        <style>
            .custom-select{
                display:inline!important;
                width:auto !important;
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <?php include('header.php'); ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-3">Add New Product</h1><hr>
                    </div>
                    <div class="product_content p-3 mb-3">
                        <div class="m-auto w-50">
                            <?php if(isset($_SESSION['alert_prod'])){ ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> New product added.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php } 
                                unset($_SESSION['alert_prod']);
                            ?>
                            <form action="addproduct.php" method="POST">
                                    <div class="form-group row">
                                        <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Product Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="name_prod" class="form-control form-control-sm" id="colFormLabelSm" placeholder="Enter product name..." required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Product Type</label>
                                        <div class="col-sm-9">
                                            <select class="custom-select custom-select-sm" name="type_prod" required>
                                                <option selected>Choose from the following ... </option>
                                                <option value="Beverages">Beverages</option>
                                                <option value="Bread">Bread</option>
                                                <option value="Canned">Canned</option>
                                                <option value="Dairy">Dairy</option>
                                                <option value="Baking Goods">Baking Goods</option>
                                                <option value="Produce">Produce</option>
                                                <option value="Cleaners">Cleaners</option>
                                                <option value="Paper Goods">Paper Goods</option>
                                                <option value="Personal Care">Personal Care</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Quantity</label>
                                        <div class="col-sm-9">
                                            <input type="number" name="qty_prod" class="form-control form-control-sm" id="colFormLabelSm" required placeholder="Enter product quantity...">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Price</label>
                                        <div class="col-sm-9">
                                            <input type="number" step=0.01 name="price_prod" class="form-control form-control-sm" required id="colFormLabelSm" placeholder="Enter price...">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Expiry Date</label>
                                        <div class="col-sm-9">
                                            <input type="date" name="expiry_prod" class="form-control form-control-sm" required id="colFormLabelSm" placeholder="Enter date...">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Supplier</label>
                                        <div class="col-sm-9">
                                            <select class="custom-select custom-select-sm" name="supplier_prod" required>
                                                <option selected>Choose from the suppliers ...</option>
                                                <?php 
                                                    $queryS="SELECT * FROM supplier_store";
                                                    $rs=mysqli_query($conn,$queryS);
                                                    while($row=mysqli_fetch_array($rs)){
                                                ?>
                                                <option value="<?php echo $row['Supplier_id']; ?>"><?php echo $row['Storename']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="submit" class="btn btn-block btn-sm btn-success" value="Add Product" name="submit_prod">
                            </form>
                        </div>
                    </div>
                </main>
                <?php include('footer.php'); ?>
            </div>
                                     
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <!-- <script src="../assets/demo/chart-area-demo.js"></script>
        <script src="../assets/demo/chart-bar-demo.js"></script> -->
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="../assets/demo/datatables-demo.js"></script>
    </body>
</html>
                