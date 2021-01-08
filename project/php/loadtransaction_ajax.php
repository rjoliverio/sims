<?php
    include_once('dbconnect.php');
    if(isset($_POST['empid'])){
        $query="INSERT INTO transactions (Employee_id) VALUES({$_POST['empid']})";
        mysqli_query($conn,$query);
        $query="SELECT * FROM transactions 
        INNER JOIN employee_accounts ON employee_accounts.Employee_id={$_POST['empid']}
        INNER JOIN person_info ON person_info.Person_id=employee_accounts.Person_id 
        ORDER BY Trans_id DESC LIMIT 1";
        $res=mysqli_query($conn,$query);
        $res=mysqli_fetch_assoc($res);
        echo json_encode($res);
    }
?>