<?php
    session_start();
    include_once('dbconnect.php');
    if(isset($_POST['remove_mem'])){
        $id=$_GET['id'];
        $query="DELETE FROM person_info WHERE Person_id='$id'";
        if(mysqli_query($conn,$query)){
            $_SESSION['alert_remove_prod']="true";
            header("Location: simsmembers.php");
        }
    }

?>