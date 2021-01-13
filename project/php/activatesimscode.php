<?php
include_once('dbconnect.php');
    if(isset($_GET['codeid'])){
        $codeid=$_GET['codeid'];
        $query="UPDATE simscode_membership SET Active='1' WHERE SIMS_code='$codeid'";
        mysqli_query($conn,$query);
        header("Location: simscodemember.php");
    }
    if(isset($_GET['activateid'])){
        $codeid=$_GET['activateid'];
        $query="UPDATE simscode_membership SET Active='1' WHERE SIMS_code='$codeid'";
        mysqli_query($conn,$query);
        header("Location: simsmembers.php");
    }
    if(isset($_GET['deleteid'])){
        $codeid=$_GET['deleteid'];
        $query="UPDATE simscode_membership SET Active='0' WHERE SIMS_code='$codeid'";
        mysqli_query($conn,$query);
        header("Location: simsmembers.php");
    }
?>