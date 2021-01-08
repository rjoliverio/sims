<?php
    session_start();
    include_once('dbconnect.php');
    if(isset($_SESSION['empid'])){
        $res=runQuery($conn,"SELECT * FROM employee_accounts INNER JOIN person_info ON employee_accounts.Person_id=person_info.Person_id WHERE employee_accounts.Employee_id='{$_SESSION['empid']}'");
        $res=mysqli_fetch_array($res);
    }else{
        header("Location: ../index.php");
    }
    if(isset($_GET['scan'])){
        $_SESSION['scan']=$_GET['scan'];
        header("Location: simscodemember.php");
    }
    if(isset($_SESSION['scan'])){
        $query="SELECT * FROM simscode_membership INNER JOIN person_info ON simscode_membership.Person_id=person_info.Person_id WHERE simscode_membership.SIMS_code='{$_SESSION['scan']}'";
        $row=mysqli_query($conn,$query);
        $row=mysqli_fetch_assoc($row);
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
        <title>Dashboard</title>
        <link href="../css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/qrcode.js"></script>
        <style>
             .member-profile{
                 background:#e9ecef;
             }
             .member-table{
                 table-layout:fixed;
             }
             .point-size{
                 font-size:97px;
             }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <?php include('header.php'); ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-3">SIMS Code Member Status</h1><hr>
                        <div class="row mb-4">
                            <div class="col-lg-6">
                                <div class="card mt-3">
                                    <h5 class="card-header text-center">Member Profile</h5>
                                    <div class="card-body">
                                    <table class="w-100 member-table">
                                        <tbody>
                                            <tr>
                                                <td class="text-center">Customer Name:</td>
                                                <td class="text-left text-info "><?php echo $row['Fname']." ".$row['Lname']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Age:</td>
                                                <td class="text-left text-info"><?php echo $row['Age']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Email:</td>
                                                <td class="text-left text-info"><?php echo $row['Email']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Contact Number:</td>
                                                <td class="text-left text-info"><?php echo $row['Contact_no']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Address:</td>
                                                <td class="text-left text-info"><?php echo $row['Address']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Date Created:</td>
                                                <td class="text-left text-info"><?php echo $row['Date_created']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Expiry Date:</td>
                                                <td class="text-left text-info"><?php echo $row['Expiry_date']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Status:</td>
                                                <td class="text-left text-white"><span class="bg-<?php if($row['Active']==1){ echo "success";}else{ echo "danger"; } ?> pl-3 pr-3 rounded-sm"><?php if($row['Active']==1){ echo "Active";}else{ echo "Expired"; } ?></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>
                                <div class="col-lg-6">
                                    <div class="card mt-3">
                                        <h5 class="card-header text-center">Current Points</h5>
                                        <div class="card-body text-center">
                                            <span class="text-center point-size"><?php echo number_format($row['Points'],2);?></span>
                                        </div>
                                        <div class="card-footer text-muted">
                                            <button class="btn btn-success btn-block <?php if($row['Active']==1){ echo "disabled"; } ?>">Activate</button>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <hr>
                        <div class="transactions">
                            <?php
                                $query="SELECT * FROM simscode_transaction WHERE SIMS_code={$_SESSION['scan']}";
                                $result=mysqli_query($conn,$query);
                            ?>
                            <div class="card mt-3">
                                        <h5 class="card-header text-center">Latest Transactions</h5>
                                        <div class="card-body ">
                                            <table class="table table-bordered" id="dataTable" width="100%"cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>SIMS Trans Code</th>
                                                        <th>SIMS Code</th>
                                                        <th>Invoice ID</th>
                                                        <th>Transaction Type</th>
                                                        <th>Amount</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php while($trav=mysqli_fetch_assoc($result)){ ?>
                                                    <tr>
                                                        <td><?php echo $trav['SIMS_trans_id']; ?></td>
                                                        <td><?php echo $trav['SIMS_code']; ?></td>
                                                        <td><?php echo $trav['Invoice_id']; ?></td>
                                                        <td><?php echo $trav['Transaction_type']; ?></td>
                                                        <td><?php echo $trav['Amount']; ?></td>
                                                        <td><?php echo $trav['Date']; ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                        </div>
                    </div>
                       
                </main>
                <?php include('footer.php'); ?>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <!-- <script src="../assets/demo/chart-area-demo.js"></script>
        <script src="../assets/demo/chart-bar-demo.js"></script> -->
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="../assets/demo/datatables-demo.js"></script>
    </body>
</html>