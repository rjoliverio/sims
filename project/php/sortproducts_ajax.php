<?php
    include_once('dbconnect.php');
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
                                        </tr>
                                    </thead>
                                    <tbody>
<?php while($row=mysqli_fetch_assoc($res)){ ?>
    <tr>
                                            <td><?php echo $row['Prod_id']; ?></td>
                                            <td><?php echo $row['ProdName']; ?></td>
                                            <td><?php echo $row['ProdType']; ?></td>
                                            <td><?php echo $row['Qty']; ?></td>
                                            <td><?php echo $row['Price']; ?></td>
                                            <td><?php echo $row['Date_added']; ?></td>
                                            <td><?php echo $row['Expiry_date']; ?></td>
                                            <td><?php echo $row['Storename']; ?></td>
                                        </tr>
<?php } ?>
                                </tbody>
                                </table>