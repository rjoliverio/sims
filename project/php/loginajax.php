<?php
session_start();
    include_once('dbconnect.php');
    if($conn){
        if(isset($_POST['empid'])&&isset($_POST['pass'])){
            $res=runQuery($conn,"SELECT * FROM employee_accounts WHERE Employee_id='".$_POST['empid']."'");
            if(mysqli_num_rows($res)>0){
                $res=mysqli_fetch_array($res);
                if($res['Password']==md5($_POST['pass'])){
                    echo ('Login');
                    $_SESSION['empid']=$res['Employee_id'];
                    $_SESSION['empdetails']=$res['Person_id'];
                }else{
                    echo "Incorrect Password";
                }
            }else{
                echo "Employee ID doesn't exist";
            }
        }
    }
    
    
?>