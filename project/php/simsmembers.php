<?php
    session_start();
    include_once('dbconnect.php');
    if(isset($_SESSION['empid'])){
        $res=runQuery($conn,"SELECT * FROM employee_accounts INNER JOIN person_info ON employee_accounts.Person_id=person_info.Person_id WHERE employee_accounts.Employee_id='{$_SESSION['empid']}'");
        $res=mysqli_fetch_array($res);
    }else{
        header("Location: ../index.php");
    }
    unset($_SESSION['scan']);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>SIMS Code Members</title>
        <link href="../css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/easy-autocomplete.css" integrity="sha512-PZ83szWxZ41zcHUPd7NSgLfQ3Plzd7YmN0CHwYMmbR7puc6V/ac5Mm0t8QcXLD7sV/0AuKXectoLvjkQUdIz9g==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/qrcode.js"></script>
        <style>
             .modal-border{
                 width:800px !important;
             }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <?php include('header.php'); ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-3">SIMS Code Members</h1><hr>
                        <div id="scan_modal" class="m-auto text-center">
                        <?php if(isset($_SESSION['alert_remove_prod'])){ ?>
                                <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
                                    <strong>Removed!</strong> Member successfully removed.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php } 
                                unset($_SESSION['alert_remove_prod']);
                            ?>
                            <table class="table table-bordered mytable" id="dataTable" width="100%"cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>SIMS Code</th>
                                        <th>Customer Name</th>
                                        <th>Points</th>
                                        <th>Date Created</th>
                                        <th>Expiry</th>
                                        <th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $query="SELECT * FROM simscode_membership INNER JOIN  person_info ON simscode_membership.Person_id=person_info.Person_id";
                                    $res=mysqli_query($conn,$query);
                                    while($row=mysqli_fetch_assoc($res)){
                                ?>
                                    <tr>
                                        <td><?php echo $row['SIMS_code']; ?></td>
                                        <td><?php echo $row['Fname']." ".$row['Lname']; ?></td>
                                        <td><?php echo $row['Points']; ?></td>
                                        <td><?php echo $row['Date_created']; ?></td>
                                        <td><?php echo $row['Expiry_date']; ?></td>
                                        <td><a href="#" class="text-decoraton-none mr-2 text-danger" data-toggle="modal" data-target="#deleteModal<?php echo $row['SIMS_code']; ?>"><i class="fas fa-user-minus"></i></a> <?php if($row['Active']==1){ ?><a href="activatesimscode.php?deleteid=<?php echo $row['SIMS_code']; ?>" class="text-decoraton-none text-success"><i class="fas fa-toggle-on"></i></i></a> <?php }else{ ?><a href="activatesimscode.php?activateid=<?php echo $row['SIMS_code']; ?>" class="text-decoraton-none text-warning"><i class="fas fa-toggle-off"></i></a> <?php } ?></td>
                                    </tr>
                                    <!-- DELETE PRODUCT -->
                                    <div class="modal fade" id="deleteModal<?php echo $row['SIMS_code']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Remove Member</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    Are you sure to remove <?php echo $row['Fname']." ".$row['Lname']; ?>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <form action="deletemember.php?id=<?php echo $row['Person_id']; ?>" method="post">
                                                        <button type="submit" name="remove_mem" class="btn btn-danger">Remove</button>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php } ?>
                                </tbody>
                            </table>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/jquery.easy-autocomplete.min.js" integrity="sha512-Z/2pIbAzFuLlc7WIt/xifag7As7GuTqoBbLsVTgut69QynAIOclmweT6o7pkxVoGGfLcmPJKn/lnxyMNKBAKgg==" crossorigin="anonymous"></script>
        <script src="../js/search-suggestion.js"></script>
    </body>
</html>