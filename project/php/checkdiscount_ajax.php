<?php
    include_once('dbconnect.php');
    if(isset($_POST['result'])){
        $sql="SELECT * FROM simscode_membership WHERE SIMS_code={$_POST['result']}";
        $res=mysqli_query($conn,$sql);
        if(mysqli_num_rows($res)>0){
            $res=mysqli_fetch_assoc($res);
            echo json_encode($res);
        }else{
            echo 0;
        }
    }
?>