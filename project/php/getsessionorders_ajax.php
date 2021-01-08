<?php 
    session_start();
    if(isset($_POST['get'])){
        echo $_SESSION['orders'];
    }
?>