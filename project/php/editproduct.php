<?php
    session_start();
    include_once('dbconnect.php');
    if(isset($_SESSION['empid'])){
        $res=runQuery($conn,"SELECT * FROM employee_accounts INNER JOIN person_info ON employee_accounts.Person_id=person_info.Person_id WHERE employee_accounts.Employee_id='{$_SESSION['empid']}'");
        $res=mysqli_fetch_array($res);
    }else{
        header("Location: ../index.php");
    }

    if(isset($_POST['submit_prod'])){
        if(isset($_SESSION['alert_prod'])){
            unset($_SESSION['alert_prod']);
        }
        $id=$_GET['prodid'];
        $prodname=$_POST['name_prod'];
        $prodtype=$_POST['type_prod'];
        $qty=$_POST['qty_prod'];
        $price=$_POST['price_prod'];
        $expiry=$_POST['expiry_prod'];
        $supplier=$_POST['supplier_prod'];

        $query="UPDATE `products` SET `ProdName`='$prodname',`ProdType`='$prodtype',`Qty`='$qty',`Price`='$price',`Expiry_date`='$expiry',`Supplier_id`='$supplier' WHERE `Prod_id`='$id'";
        if(mysqli_query($conn,$query)){
            $_SESSION['alert_prod']="true";
            header("Location: products.php");
        }
    }
    if(isset($_POST['remove_prod'])){
        if(isset($_SESSION['alert_remove_prod'])){
            unset($_SESSION['alert_remove_prod']);
        }
        $id=$_GET['prodid'];
        $query="DELETE FROM `products` WHERE `Prod_id`='$id'";
        if(mysqli_query($conn,$query)){
            $_SESSION['alert_remove_prod']="true";
            header("Location: products.php");
        }
    }
?>