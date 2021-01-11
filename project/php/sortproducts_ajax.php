<?php
session_start();
    include_once('dbconnect.php');
    $resc=runQuery($conn,"SELECT * FROM employee_accounts INNER JOIN person_info ON employee_accounts.Person_id=person_info.Person_id WHERE employee_accounts.Employee_id='{$_SESSION['empid']}'");
    $resc=mysqli_fetch_array($resc);
    if(isset($_POST['category'])){
        if($_POST['category']!=""){
            $query="SELECT * FROM products INNER JOIN supplier_store ON products.Supplier_id=supplier_store.Supplier_id WHERE products.ProdType='{$_POST['category']}'";
        }else{
            $query="SELECT * FROM products INNER JOIN supplier_store ON products.Supplier_id=supplier_store.Supplier_id";
        }
    }
    if(isset($_POST['dateadded'])){
        if($_POST['dateadded']!=""){
            $query="SELECT * FROM products INNER JOIN supplier_store ON products.Supplier_id=supplier_store.Supplier_id WHERE products.Date_added='{$_POST['dateadded']}'";
        }else{
            $query="SELECT * FROM products INNER JOIN supplier_store ON products.Supplier_id=supplier_store.Supplier_id";
        }
    }
    if(isset($_POST['expirydate'])){
        if($_POST['expirydate']!=""){
            $query="SELECT * FROM products INNER JOIN supplier_store ON products.Supplier_id=supplier_store.Supplier_id WHERE products.Expiry_date='{$_POST['expirydate']}'";
        }else{
            $query="SELECT * FROM products INNER JOIN supplier_store ON products.Supplier_id=supplier_store.Supplier_id";
        }
    }
    if(isset($_POST['storename'])){
        if($_POST['storename']!=""){
            $query="SELECT * FROM supplier_store INNER JOIN products ON products.Supplier_id=supplier_store.Supplier_id WHERE supplier_store.Storename='{$_POST['storename']}'";
        }else{
            $query="SELECT * FROM products INNER JOIN supplier_store ON products.Supplier_id=supplier_store.Supplier_id";
        }
    }
    if(isset($_POST['stocks'])){
            $query="SELECT * FROM products INNER JOIN supplier_store ON products.Supplier_id=supplier_store.Supplier_id WHERE products.Qty{$_POST['stocks']}"; 
    }
    $res=mysqli_query($conn,$query);
?>

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
<?php while($row=mysqli_fetch_assoc($res)){ ?>
    <tr>
                                            <td><?php echo $row['Prod_id']; ?></td>
                                            <td><?php echo $row['ProdName']; ?></td>
                                            <td><?php echo $row['ProdType']; ?></td>
                                            <td><?php echo $row['Qty']; ?></td>
                                            <td>Php <?php echo number_format( $row['Price'],2); ?></td>
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