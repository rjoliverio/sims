<?php
    include_once('dbconnect.php');
    if(isset($_POST['result'])){
        $query="SELECT * FROM simscode_membership WHERE SIMS_code='{$_POST['result']}'";
        $res=mysqli_query($conn,$query);
        if(mysqli_num_rows($res)>0){
            echo $_POST['result'];
        }else{
            echo "0";
        }
    }
?>