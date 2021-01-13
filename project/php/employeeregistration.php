<?php
session_start();
include_once('dbconnect.php');
if(isset($_SESSION['empid'])){
    $res=runQuery($conn,"SELECT * FROM employee_accounts INNER JOIN person_info ON employee_accounts.Person_id=person_info.Person_id WHERE employee_accounts.Employee_id='{$_SESSION['empid']}'");
    $res=mysqli_fetch_array($res);
}else{
    header("Location: ../index.php");
}
    if(isset($_POST['addNew']))
    {	
      
      $fname= $_POST['fname'];
      $lname = $_POST['lname'];
      $email = $_POST['email'];
      $image = "../images/".$_POST['image'];
      $pnum = $_POST['pnum'];
      $address = $_POST['address'];
      $age = $_POST['age'];
      $gender = $_POST['gender'];
      $type = $_POST['type'];
      
      $pass = md5($_POST['passw']);
    
        mysqli_query($conn,"INSERT INTO `person_info`(`Fname`,`Lname`,`Email`,`Image`,`Contact_no`,`Address`,`Age`,`Gender`,`Person_type`) VALUES ('$fname','$lname','$email','$image','$pnum','$address','$age','$gender','$type')");
      $ID=mysqli_query($conn,"SELECT max(Person_id) FROM person_info");
      $ID=mysqli_fetch_row($ID);
      $ID=$ID[0];
      mysqli_query($conn, "INSERT INTO `employee_accounts`(`Person_id`,`Password`) VALUES ('$ID','$pass')");
  
    
      
      echo "<script>alert(\"Added\")</script>";
      
      header("Location: employeeregistration.php");
      

}
if(isset($_POST['saveNew'])){
    $id= $_POST['empID'];	
    $fname= $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $pnum = $_POST['pnum'];
    $address = $_POST['address'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $type = $_POST['type'];

    $queryS="UPDATE person_info SET Fname ='$fname', Lname ='$lname', Email = '$email',Contact_no = '$pnum', Address = '$address', Age = '$age',Gender = '$gender', Person_type = '$type'  WHERE Person_id = '$id'";
    $rs=mysqli_query($conn,$queryS);
    if($_POST['passw']!=""){
        $pass = md5( $_POST['passw']);
        $rs=mysqli_query($conn,"UPDATE employee_accounts SET Password = '$pass'");
    }
    
    echo "Saved!";
    
    header("Location: employeeregistration.php");				
}
if(isset($_REQUEST['id'])){
    
    $id =$_REQUEST['id'];
    
	
	
	// sending quer//
        mysqli_query($conn,"DELETE FROM person_info WHERE Person_id = '$id'");
      
	
	header("Location: employeeregistration.php");
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
    <title>Employee Registration</title>
    <link href="../css/contacts.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/easy-autocomplete.css" integrity="sha512-PZ83szWxZ41zcHUPd7NSgLfQ3Plzd7YmN0CHwYMmbR7puc6V/ac5Mm0t8QcXLD7sV/0AuKXectoLvjkQUdIz9g==" crossorigin="anonymous" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js"
        crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.idnum').hide();
            // Activate tooltip
            $('[data-toggle="tooltip"]').tooltip();

            // Select/Deselect checkboxes
            var checkbox = $('table tbody input[type="checkbox"]');
            $(".selectAll").click(function () {
                if (this.checked) {
                    checkbox.each(function () {
                        this.checked = true;
                    });
                } else {
                    checkbox.each(function () {
                        this.checked = false;
                    });
                }
            });
            checkbox.click(function () {
                if (!this.checked) {
                    $(".selectAll").prop("checked", false);
                }
            });
        });

    </script>
</head>

<body class="sb-nav-fixed">
    <?php
       include('header.php');
    ?>
    <?php
               $queryP="SELECT * FROM person_info INNER JOIN employee_accounts ON person_info.Person_id = employee_accounts.Person_id";
               $rs1=mysqli_query($conn,$queryP);
               $rs2=mysqli_query($conn,$queryP);
        ?>
    <div id="layoutSidenav_content">
        <main>
            <!-- Tab links -->
            <div class="tab">
                <button class="tablinks" id="defaultOpen" onclick="openCity(event, 'Cashiers')">Cashiers</button>
                <button class="tablinks" onclick="openCity(event, 'Managers')">Managers</button>
              
            </div>
            
            <div id="Cashiers" class="tabcontent">
                <div class="container">
                    <div class="wrapper">
                        <div class="table-title">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h2><b>Cashiers</b></h2>
                                </div>
                                <div class="col-sm-6">
                                    <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i
                                            class="material-icons">&#xE147;</i> <span>Register New Employee</span></a>
                                </div>

                            </div>
                        </div>
                        <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                <th>Employee ID</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <th>Address</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Date of Employment</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                      
                                         while($row=mysqli_fetch_array($rs1)){
                                             if($row['Person_type']=='Cashier'){
                                                ?>
                                <?php $id=$row['Person_id'];?>
                                <tr>
                                <td><?php echo $row['Employee_id'];?></td>
                                    <td><?php echo $row['Lname'];?></td>
                                    <td><?php echo $row['Fname'];?></td>
                                    <td><?php echo $row['Email'];?></td>
                                    <td><?php echo $row['Contact_no'];?></td>
                                    <td><?php echo $row['Address'];?></td>
                                    <td><?php echo $row['Age'];?></td>
                                    <td><?php echo $row['Gender'];?></td>
                                    <td><?php echo $row['Date_added'];?></td>
                                
                                    <td>
                                        <a href="#editEmployeeModal<?php echo $id;?>" class="edit"
                                            data-toggle="modal"><i class="material-icons" data-toggle="tooltip"
                                                title="Edit">&#xE254;</i></a>
                                                
                                                <a href="#delEmployeeModal<?php echo $id;?>" class="delete"
                                            data-toggle="modal"><i class="material-icons" data-toggle="tooltip"
                                                title="Delete">&#xE872;</i></a>
                                       
                                    </td>
                                   

                                </tr>
                                <div id="delEmployeeModal<?php echo $id;?>" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="employeeregistration.php" method="POST">
                                                <div class="modal-header">

                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <h4>Do you want to delete this?</h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="button" class="btn btn-primary" data-dismiss="modal"
                                                        value="No">
                                                        <?php echo "<a class='btn btn-danger' href='employeeregistration.php?id=$id'>Yes</a>";?>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                               
                                <div id="editEmployeeModal<?php echo $id;?>" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="employeeregistration.php" method="POST">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group idnum">
                                                        <label>ID</label>
                                                        <input type="text" class="form-control" name="empID"
                                                            value="<?php echo $row[0];?>" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>First Name</label>
                                                        <input type="text" class="form-control" name="fname"
                                                            value="<?php echo $row[1];?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Last Name</label>
                                                        <input type="text" class="form-control" name="lname"
                                                            value="<?php echo $row[2];?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="email" class="form-control" name="email"
                                                            value="<?php echo $row[3];?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Contact Number</label>
                                                        <input type="text" class="form-control" name="pnum"
                                                            value="<?php echo $row[5];?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Address</label>
                                                        <input type="text" class="form-control" name="address"
                                                            value="<?php echo $row[6];?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Age</label>
                                                        <input type="number" class="form-control" name="age"
                                                            value="<?php echo $row[7];?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Gender</label><br><br>
                                                        <input type="radio" name="gender" value="Male"
                                                            required>&nbsp<label>Male</label>&nbsp&nbsp
                                                        <input type="radio" name="gender" value="Female"
                                                            required>&nbsp<label>Female</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Employee Type</label><br><br>
                                                        <input type="radio" name="type" value="Cashier"
                                                            required>&nbsp<label>Cashier</label>&nbsp&nbsp
                                                        <input type="radio" name="type" value="Manager" required>&nbsp<label>Manager</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Password (Optional)</label>
                                                        <input type="password" class="form-control" name="passw">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="button" class="btn btn-default" data-dismiss="modal"
                                                        value="Cancel">
                                                    <input type="submit" name="saveNew" class="btn btn-info"
                                                        value="Save">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                                <?php
                                             }
                                           
                                            
                                        }
                                    ?>
                            </tbody>
                        </table>
                        </div>

                    </div>
                </div>
            </div>

            <div id="Managers" class="tabcontent">
                <div class="container">
                    <div class="wrapper">
                        <div class="table-title">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h2><b>Managers</b></h2>
                                </div>
                                <div class="col-sm-6">
                                    <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i
                                            class="material-icons">&#xE147;</i> <span>Register New Employee</span></a>
                                </div>

                            </div>
                        </div>
			<div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <th>Address</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Date of Employment</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                  while($col=mysqli_fetch_array($rs2)){
                                    if($col['Person_type']=='Manager'){
                                       ?>
                                <?php $id=$col['Person_id'];?>
                                <tr>
                                <td><?php echo $col['Employee_id'];?></td>
                                    <td><?php echo $col[2];?></td>
                                    <td><?php echo $col[1];?></td>
                                    <td><?php echo $col[3];?></td>
                                    <td><?php echo $col[5];?></td>
                                    <td><?php echo $col[6];?></td>
                                    <td><?php echo $col[7];?></td>
                                    <td><?php echo $col[8];?></td>
                                    <td><?php echo $col[9];?></td>
                                   
                                    <td>
                                        <a href="#editEmployeeModal<?php echo $id;?>" class="edit"
                                            data-toggle="modal"><i class="material-icons" data-toggle="tooltip"
                                                title="Edit">&#xE254;</i></a>
                                                <?php if($res['Person_id'] != $col['Person_id']){
                                                    ?>
                                                         <a href="#delEmployeeModal<?php echo $id;?>" class="delete"
                                                         data-toggle="modal"><i class="material-icons" data-toggle="tooltip"
                                                             title="Delete">&#xE872;</i></a>
                                                             <?php
                                                }
                                               
                                                ?>
                                       
                                    </td>
                                   

                                </tr>
                                <div id="delEmployeeModal<?php echo $id;?>" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="employeeregistration.php" method="POST">
                                                <div class="modal-header">
                                                   
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <h4>Do you want to delete this?</h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="button" class="btn btn-primary" data-dismiss="modal"
                                                        value="No">
                                                        <?php echo "<a class='btn btn-danger' href='employeeregistration.php?id=$id'>Yes</a>";?>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="editEmployeeModal<?php echo $id;?>" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="employeeregistration.php" method="POST">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group idnum">
                                                        <label>ID</label>
                                                        <input type="text" class="form-control" name="empID"
                                                            value="<?php echo $col[0];?>" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>First Name</label>
                                                        <input type="text" class="form-control" name="fname"
                                                            value="<?php echo $col[1];?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Last Name</label>
                                                        <input type="text" class="form-control" name="lname"
                                                            value="<?php echo $col[2];?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="email" class="form-control" name="email"
                                                            value="<?php echo $col[3];?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Contact Number</label>
                                                        <input type="text" class="form-control" name="pnum"
                                                            value="<?php echo $col[5];?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Address</label>
                                                        <input type="text" class="form-control" name="address"
                                                            value="<?php echo $col[6];?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Age</label>
                                                        <input type="number" class="form-control" name="age"
                                                            value="<?php echo $col[7];?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Gender</label><br><br>
                                                        <input type="radio" name="gender" value="Male"
                                                            required>&nbsp<label>Male</label>&nbsp&nbsp
                                                        <input type="radio" name="gender" value="Female"
                                                            required>&nbsp<label>Female</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Employee Type</label><br><br>
                                                        <input type="radio" name="type" value="Cashier"
                                                            required>&nbsp<label>Cashier</label>&nbsp&nbsp
                                                        <input type="radio" name="type" value="Manager" required>&nbsp<label>Manager</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Password (Optional)</label>
                                                        <input type="password" class="form-control" name="passw" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="button" class="btn btn-default" data-dismiss="modal"
                                                        value="Cancel">
                                                    <input type="submit" name="saveNew" class="btn btn-info"
                                                        value="Save">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                    }
                                }
                                ?>


                            </tbody>
                        </table>
			</div>
                    </div>
                </div>
            </div>

           

            <!-- Edit Modal HTML -->

            <div id="addEmployeeModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="employeeregistration.php" method="POST">
                            <div class="modal-header">
                                <h4 class="modal-title">Add Account</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" name="fname" required>
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" name="lname" required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="form-group">
                                                        <label>Image</label>
                                                        <input type="file" class="form-control" name="image"
                                                            value="<?php echo $col[4];?>" required>
                                                    </div>
                                <div class="form-group">
                                    <label>Contact Number</label>
                                    <input type="text" class="form-control" name="pnum" required>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address" required>
                                </div>
                                <div class="form-group">
                                    <label>Age</label>
                                    <input type="number" class="form-control" name="age" required>
                                </div>
                                <div class="form-group">
                                    <label>Gender</label><br><br>
                                    <input type="radio" name="gender" value="Male"
                                        required>&nbsp<label>Male</label>&nbsp&nbsp
                                    <input type="radio" name="gender" value="Female" required>&nbsp<label>Female</label>
                                </div>
                                <div class="form-group">
                                    <label>Employee Type</label><br><br>
                                    <input type="radio" name="type" value="Cashier"
                                        required>&nbsp<label>Cashier</label>&nbsp&nbsp
                                    <input type="radio" name="type" value="Manager" required>&nbsp<label>Manager</label>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="passw" required>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                <input type="submit" name="addNew" class="btn btn-success" value="Add">
                            </div>
                        </form>
                    </div>
                </div>
           </div>
            <!-- Edit Modal HTML -->
            <!-- Delete Modal HTML -->

        </main>
        <?php include('footer.php'); ?>
    </div>
    </div>
    <script>

        document.getElementById("defaultOpen").click();
        function openCity(evt, cityName) {
            // Declare all variables
            var i, tabcontent, tablinks;

            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Get all elements with class="tablinks" and remove the class "active"
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        } 
    </script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../assets/demo/chart-area-demo.js"></script>
    <script src="../assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="../assets/demo/datatables-demo.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/jquery.easy-autocomplete.min.js" integrity="sha512-Z/2pIbAzFuLlc7WIt/xifag7As7GuTqoBbLsVTgut69QynAIOclmweT6o7pkxVoGGfLcmPJKn/lnxyMNKBAKgg==" crossorigin="anonymous"></script>
    <script src="../js/search-suggestion.js"></script>
</body>

</html>