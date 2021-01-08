<?php
    include_once('dbconnect.php');
    if(isset($_POST['orders'])){
        $orders=json_decode($_POST['orders']);
        $invoice=json_decode($_POST['invoice']);
        $simstrans=json_decode($_POST['simstrans']);

        foreach($orders as $rows){
            $sql="INSERT INTO orders VALUES($invoice->transid,$rows->prodid,$rows->qty)";
            mysqli_query($conn,$sql);
            $sql="UPDATE products SET Qty=(Qty-$rows->qty) WHERE Prod_id=$rows->prodid";
            mysqli_query($conn,$sql);
        }
        if($invoice->cardnumber==""){
            $invoice->cardnumber="NULL";
        }
        if($invoice->simscode==""){
            $invoice->simscode="NULL";
        }
        $sql="INSERT INTO invoice(Trans_id,Total,Discount,Payment,Payment_type,Card_number,SIMS_code) VALUES($invoice->transid,$invoice->total,$invoice->discount,$invoice->payment,'$invoice->paymenttype',$invoice->cardnumber,$invoice->simscode)";
        mysqli_query($conn,$sql);
        $sql="SELECT * from invoice ORDER BY Invoice_id desc LIMIT 1";
        $res=mysqli_query($conn,$sql);
        $res=mysqli_fetch_assoc($res);

        if($invoice->simscode!="NULL" && $invoice->total>=100){
            $sql="UPDATE simscode_membership SET Points='{$_POST['currentsimspt']}' WHERE SIMS_Code=$invoice->simscode";
            mysqli_query($conn,$sql);
            $sql="INSERT INTO simscode_transaction(SIMS_code,Invoice_id,Transaction_type,Amount) VALUES($simstrans->simscode,{$res['Invoice_id']},'$simstrans->transtype',$simstrans->amount)";
            mysqli_query($conn,$sql);
        }
        echo "Success";
    }
?>