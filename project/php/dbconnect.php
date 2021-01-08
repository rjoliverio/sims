<?php
    $conn=mysqli_connect('localhost','root','','sims');
    function runQuery($conn,$str){
        $res=mysqli_query($conn,$str);
        return $res;
    }
?>