<?php
    session_start();
    include_once('dbconnect.php');
    if(isset($_SESSION['empid'])){
        $res=runQuery($conn,"SELECT * FROM employee_accounts INNER JOIN person_info ON employee_accounts.Person_id=person_info.Person_id WHERE employee_accounts.Employee_id='{$_SESSION['empid']}'");
        $res=mysqli_fetch_array($res);
    }else{
        header("Location: ../index.php");
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
                        <h1 class="mt-3">Products</h1><hr>
                    </div>
                    <div class="product_content p-3 mb-3">
                    
                            <?php if(isset($_SESSION['alert_prod'])){ ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> Product updated.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php } 
                                unset($_SESSION['alert_prod']);
                            ?>
                            <?php if(isset($_SESSION['alert_remove_prod'])){ ?>
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>Removed!</strong> Product successfully removed.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php } 
                                unset($_SESSION['alert_remove_prod']);
                            ?>
                        <?php 
                            if($res['Person_type']=="Manager"){
                        ?>
                        <div>
                            <a class="text-decoration-none btn btn-primary mb-3" href="addproduct.php">Add new product</a>
                        </div>
                        <?php } ?>
                        <div class="product-filter mb-4">
                            <span>Filter:&emsp;</span>
                            <select id="category"class="custom-select mr-2 ">
                                <option value="" selected >Category</option>
                                <?php 
                                    $query="SELECT DISTINCT ProdType FROM products";
                                    $res=mysqli_query($conn,$query);
                                    foreach(mysqli_fetch_all($res) as $row){
                                ?>
                                <option value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option>
                                <?php } ?>
                            </select>
                            <select id="dateadded"class="custom-select mr-2">
                                <option value="" selected >Date Added</option>
                                <?php 
                                    $query="SELECT DISTINCT Date_added FROM products";
                                    $res=mysqli_query($conn,$query);
                                    foreach(mysqli_fetch_all($res) as $row){
                                ?>
                                <option value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option>
                                <?php } ?>
                            </select>
                            <select id="expirydate"class="custom-select mr-2">
                                <option value="" selected >Expiry Date</option>
                                <?php 
                                    $query="SELECT DISTINCT Expiry_date FROM products";
                                    $res=mysqli_query($conn,$query);
                                    foreach(mysqli_fetch_all($res) as $row){
                                ?>
                                <option value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option>
                                <?php } ?>
                            </select>
                            <select id="storename"class="custom-select mr-2">
                                <option value="" selected >Supplier</option>
                                <?php 
                                    $query="SELECT Storename FROM supplier_store";
                                    $res=mysqli_query($conn,$query);
                                    foreach(mysqli_fetch_all($res) as $row){
                                ?>
                                <option value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option>
                                <?php } ?>
                            </select>
                            <button class="btn btn-success float-right" id="export">Export &raquo;</button>
                            <div class="text-center mt-3">
                                <input type="radio" name="quantity" value="=0"> Out of Stock&emsp;
                                <input type="radio" name="quantity" value=">20"> Most Stock&emsp;
                                <input type="radio" name="quantity" value="<=20"> Low Stock&emsp;
                            </div>
                        </div>
                        <div class="card mt-1">
                            <h5 class="card-header text-center">Product List</h5>
                            <div class="card-body " id="tablecontent">
                                <table class="table table-bordered mytable" id="dataTable" width="100%"cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Product ID</th>
                                            <th>Product Name</th>
                                            <th>Product Type</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Date Added</th>
                                            <th>Expiry Date</th>
                                            <th>Supplier</th>
                                            <?php
                                                $resc=runQuery($conn,"SELECT * FROM employee_accounts INNER JOIN person_info ON employee_accounts.Person_id=person_info.Person_id WHERE employee_accounts.Employee_id='{$_SESSION['empid']}'");
                                                $resc=mysqli_fetch_array($resc);
                                                if($resc['Person_type']=="Manager"){
                                            ?>
                                            <th></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $query="SELECT * FROM products INNER JOIN supplier_store ON products.Supplier_id=supplier_store.Supplier_id";
                                            $res=mysqli_query($conn,$query);
                                            while($row=mysqli_fetch_assoc($res)){
                                        ?>
                                        <tr>
                                            <td><?php echo $row['Prod_id']; ?></td>
                                            <td><?php echo $row['ProdName']; ?></td>
                                            <td><?php echo $row['ProdType']; ?></td>
                                            <td><?php echo $row['Qty']; ?></td>
                                            <td><?php echo $row['Price']; ?></td>
                                            <td><?php echo $row['Date_added']; ?></td>
                                            <td><?php echo $row['Expiry_date']; ?></td>
                                            <td><?php echo $row['Storename']; ?></td>
                                            <?php 
                                                if($resc['Person_type']=="Manager"){
                                            ?>
                                            <td><a href="#" class="text-decoraton-none" data-toggle="modal" data-target="#editModal<?php echo $row['Prod_id']; ?>"><i class="fas fa-edit"></i></a><a href="#" class="text-decoraton-none text-danger"data-toggle="modal" data-target="#deleteModal<?php echo $row['Prod_id']; ?>"><i class="fas fa-minus-circle"></i></a></td>
                                            <?php } ?>
                                        </tr>
                                        <!-- UPDATE PRODUCT -->
                                        <div class="modal fade" id="editModal<?php echo $row['Prod_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                <form action="editproduct.php?prodid=<?php echo $row['Prod_id']; ?>" method="POST">
                                                    <div class="form-group row">
                                                        <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Product Name</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" value="<?php echo $row['ProdName']; ?>" name="name_prod" class=" form-control form-control-sm" id="colFormLabelSm" placeholder="Enter product name..." required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Product Type</label>
                                                        <div class="col-sm-9">
                                                            <select class="custom-select custom-select-sm mb-2" name="type_prod" required>
                                                                <option value="Beverages" <?php if($row['ProdType']=="Beverages"){ echo "selected"; } ?>>Beverages</option>
                                                                <option value="Bread" <?php if($row['ProdType']=="Bread"){ echo "selected"; } ?>>Bread</option>
                                                                <option value="Canned" <?php if($row['ProdType']=="Canned"){ echo "selected"; } ?>>Canned</option>
                                                                <option value="Dairy" <?php if($row['ProdType']=="Dairy"){ echo "selected"; } ?>>Dairy</option>
                                                                <option value="Baking Goods" <?php if($row['ProdType']=="Baking Goods"){ echo "selected";} ?>>Baking Goods</option>
                                                                <option value="Produce" <?php if($row['ProdType']=="Produce"){ echo "selected"; } ?>>Produce</option>
                                                                <option value="Cleaners" <?php if($row['ProdType']=="Cleaners"){ echo "selected"; } ?>>Cleaners</option>
                                                                <option value="Paper Goods" <?php if($row['ProdType']=="Paper Goods"){ echo "selected"; } ?>>Paper Goods</option>
                                                                <option value="Personal Care" <?php if($row['ProdType']=="Personal Care"){ echo "selected"; } ?>>Personal Care</option>
                                                                <option value="Other" <?php if($row['ProdType']=="Other"){ echo "selected"; } ?>>Other</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Quantity</label>
                                                        <div class="col-sm-9">
                                                            <input type="number" value="<?php echo $row['Qty']; ?>" name="qty_prod" class="form-control form-control-sm" id="colFormLabelSm" placeholder="Enter product name..." required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Price</label>
                                                        <div class="col-sm-9">
                                                            <input type="number" step=0.01 value="<?php echo $row['Price']; ?>" name="price_prod" class="form-control form-control-sm" id="colFormLabelSm" placeholder="Enter product name..." required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Expiry Date</label>
                                                        <div class="col-sm-9">
                                                            <input type="date" value="<?php echo $row['Expiry_date']; ?>" name="expiry_prod" class="form-control form-control-sm" required id="colFormLabelSm" placeholder="Enter date..." required>
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
                                                                    while($rsrow=mysqli_fetch_array($rs)){
                                                                ?>
                                                                <option value="<?php echo $rsrow['Supplier_id']; ?>" <?php if($rsrow['Supplier_id'] == $row['Supplier_id']){ echo "selected"; }  ?>><?php echo $rsrow['Storename']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="submit_prod" class="btn btn-primary">Save changes</button>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- DELETE PRODUCT -->
                                        <div class="modal fade" id="deleteModal<?php echo $row['Prod_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Remove Product</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    Are you sure to remove product <?php echo $row['Prod_id']; ?>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <form action="editproduct.php?prodid=<?php echo $row['Prod_id']; ?>" method="post">
                                                        <button type="submit" name="remove_prod" class="btn btn-danger">Remove</button>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                            <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <?php include('footer.php'); ?>
            </div>
        </div>
        <script>
        $(function(){
            $('#category').on('change',function(){
                var val=$('#category').val();
                $.ajax({
                    type:'POST',
                    url:'sortproducts_ajax.php',
                    data:{category:val},
                    success:function(res){
                        $('#tablecontent').html(res);
                        $('.mytable').DataTable();
                    }
                });
            });
            $('#dateadded').on('change',function(){
                var val=$('#dateadded').val();
                $.ajax({
                    type:'POST',
                    url:'sortproducts_ajax.php',
                    data:{dateadded:val},
                    success:function(res){
                        $('#tablecontent').html(res);
                        $('.mytable').DataTable();
                    }
                });
            });
            $('#expirydate').on('change',function(){
                var val=$('#expirydate').val();
                $.ajax({
                    type:'POST',
                    url:'sortproducts_ajax.php',
                    data:{expirydate:val},
                    success:function(res){
                        $('#tablecontent').html(res);
                        $('.mytable').DataTable();
                    }
                });
            });
            $('#storename').on('change',function(){
                var val=$('#storename').val();
                $.ajax({
                    type:'POST',
                    url:'sortproducts_ajax.php',
                    data:{storename:val},
                    success:function(res){
                        $('#tablecontent').html(res);
                        $('.mytable').DataTable();
                    }
                });
            });
            $('input[name="quantity"]').on('change',function(){
                var val=$('input[name="quantity"]:checked').val();
                $.ajax({
                    type:'POST',
                    url:'sortproducts_ajax.php',
                    data:{stocks:val},
                    success:function(res){
                        $('#tablecontent').html(res);
                        $('.mytable').DataTable();
                    }
                });
            });

            $('#export').on('click',function(){
                var tables=$('.mytable').DataTable();
                var data=tables
                    .rows({ search: 'applied' })
                    .data();
                var table=[];
                for(var i=0; i<data.length; i++){
                    var obj={prodid:"",prodname:"",prodtype:"",qty:"",price:"",dateadded:"",expirydate:"",supplier:""};
                    obj.prodid=data[i][0];
                    obj.prodname=data[i][1];
                    obj.prodtype=data[i][2];
                    obj.qty=data[i][3];
                    obj.price=data[i][4];
                    obj.dateadded=data[i][5];
                    obj.expirydate=data[i][6];
                    obj.supplier=data[i][7];
                    table.push(obj);
                    // for (var j = 0, col; col = row.cells[j]; j++) {
                    //     //iterate through columns
                    //     //columns would be accessed using the "col" variable assigned in the for loop
                    // }  
                }
                var x=JSON.stringify(table);
                window.location="productexport.php?x="+x;
            });


        });
    </script>                                        
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