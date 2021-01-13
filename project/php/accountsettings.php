<?php
    session_start();
    include_once('dbconnect.php');
    if(isset($_SESSION['empid'])){
        $res=runQuery($conn,"SELECT * FROM employee_accounts INNER JOIN person_info ON employee_accounts.Person_id=person_info.Person_id WHERE employee_accounts.Employee_id='{$_SESSION['empid']}'");
        $res=mysqli_fetch_array($res);
    }else{
        header("Location: ../index.php");
    }
?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Account Settings</title>
        <link href="../css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
    <?php
       include('header.php');
    ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h1 class="mt-3">Profile</h1><hr>
                <p><font color='red'>Enter new values in the fields and press 'Submit' to update your profile.</font></p>
                <div class="profile">
                <?php
                    $id=$_SESSION['empid'];
                    $query=mysqli_query($conn,"SELECT * FROM employee_accounts INNER JOIN person_info ON employee_accounts.Person_id=person_info.Person_id WHERE employee_accounts.Employee_id='{$_SESSION['empid']}'")or die(mysqli_error());
                    $row=mysqli_fetch_array($query);
                ?>
                <center>
                    <form method="post" action="#">
                        <div class="form-group">
                                <img src="../images/<?php echo $row['Image']; ?>" width='50' height='50'><br>
                                <input type="file" name="image" class="profile-image">
                        </div>
                            <div class="form-group">
                                <label><b>First Name</b></label>
                                <input type="text" class="form-control" name="fname" style="width:20em;" placeholder="Enter your Fullname" value="<?php echo $row['Fname']; ?>"/>
                            </div>
                            <div class="form-group">
                                <label><b>Last Name</b></label>
                                <input type="text" class="form-control" name="lname" style="width:20em;" placeholder="Enter your Fullname" value="<?php echo $row['Lname']; ?>"/>
                            </div>
                            <div class="form-group">
                                <label><b>Email</b></label><br>
                                <?php
                                    echo $row['Email'];
                                ?>
                            </div>
                            <div class="form-group">
                                <label><b>Gender</b></label><br>
                                <?php
                                    echo $row['Gender'];
                                ?>
                            </div>
                            <div class="form-group">
                                <label><b>Contact Number</b></label>
                                <input type="text" class="form-control" name="contact_number" style="width:20em;" placeholder="Enter your Fullname" value="<?php echo $row['Contact_no']; ?>"/>
                            </div>
                            <div class="form-group">
                                <label><b>Address</b></label>
                                <input type="text" class="form-control" name="address" style="width:20em;" placeholder="Enter your Fullname" value="<?php echo $row['Address']; ?>"/>
                            </div>
                            <div class="form-group">
                                <label><b>Age</b></label>
                                <input type="text" class="form-control" name="age" style="width:20em;" placeholder="Enter your Fullname" value="<?php echo $row['Age']; ?>"/>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-primary" style="width:20em; margin:0;">
                            </div>
                    </form>
                </center>
                </div>
            </div>
        </main>
        <?php include('footer.php'); ?>
    </div>
    <?php
        if(isset($_POST['submit'])){
            $image = $_POST['image'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $contact_no = $_POST['contact_number'];
            $address = $_POST['address'];
            $age = $_POST['age'];
            
            $query = "UPDATE employee_accounts INNER JOIN person_info ON employee_accounts.Person_id=person_info.Person_id  SET Image = '$image', Fname = '$fname', Lname = '$lname', 
            Contact_no = '$contact_no', Address = '$address',Age = '$age' WHERE employee_accounts.Employee_id='{$_SESSION['empid']}'";
            $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
            ?>
            <script type="text/javascript">
            window.location = "accountsettings.php";
            </script>
            <?php
        }
    ?>

  
                
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="../assets/demo/chart-area-demo.js"></script>
        <script src="../assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="../assets/demo/datatables-demo.js"></script>
    </body>
</html>