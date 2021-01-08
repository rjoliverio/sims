<?php
include_once('dbconnect.php');
    if(isset($_POST['click'])){
        $query="SELECT Trans_id,Date,Lname,Fname FROM transactions 
        INNER JOIN employee_accounts ON employee_accounts.Employee_id=transactions.Employee_id
        INNER JOIN person_info ON person_info.Person_id=employee_accounts.Person_id 
        WHERE transactions.Trans_id NOT IN(SELECT Trans_id from invoice)";
        $res=mysqli_query($conn,$query);
        $str="<option value='' selected>Choose from the following</option>";
        while($row=mysqli_fetch_assoc($res)){
            $str.="<option value='".json_encode($row)."'>".$row['Trans_id'] ." | ".$row['Date']."</option>";
        }
        echo $str;
    }
?>