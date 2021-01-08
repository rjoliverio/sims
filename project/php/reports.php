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
        <title>Reports</title>
        <link href="../css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
		<style>
        	/* table {
				width: 100%;
				text-align: left;
				font-family: sans-serif;
				font-size: 1rem;
				border-collapse: collapse;
			}

			table, th, td {
				border: 1px solid gray;
				padding: 10px;
			} */
        </style>
    </head>
    <body class="sb-nav-fixed">
    <?php
       include('header.php');
    ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                    	<h1 class="mt-3">Reports</h1><hr>
                        <div class="mainTable">
							<div class="card mt-1">
								<h5 class="card-header text-center">Purchase Invoice</h5>
								<div class="card-body " id="tablecontent">
									<table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
										<thead>
											<th>Invoice ID</th>
											<th>Date</th>
											<th>Payment</th>
											<th>Discount</th>
											<th>Payment Type</th>
											<th>Card Number</th>
											<th>SIMS Code</th>
											<th>Total</th>
										</thead>
										<tbody>
										<?php 
										$sql = "SELECT * FROM invoice INNER JOIN transactions ON transactions.Trans_ID = invoice.Trans_id";
										$result=mysqli_query($conn,$sql);
										?>
										<?php if ($result->num_rows > 0) {
												// output data of each row
												while($row = $result->fetch_assoc()) {
													$row['Card_number']=($row['Card_number']!="")?$row['Card_number']:"N/A";
													$row['SIMS_code']=($row['SIMS_code']!="")?$row['SIMS_code']:"N/A";
													echo "	
																<tr>
																<td><a href='invoicereceipt.php?invoiceid=".$row['Invoice_id']."'>".$row['Invoice_id']."</a></td>
																<td>".$row['Date']."</td>
																<td>".$row['Payment']."</td>
																<td>".$row['Discount']."</td>
																<td>".$row['Payment_type']."</td>
																<td>".$row['Card_number'] ."</td>
																<td>".$row['SIMS_code']."</td>
																<td>".$row['Total']."</td>
																</tr>
															";
												}
											} 
										?>
										</tbody>
									</table>
								</div>
							</div>

							<div class="card mt-3 mb-3">
								<h5 class="card-header text-center">Daily Sales</h5>
								<div class="card-body " id="tablecontent">
									<table class="table table-bordered mydatatable" id="dataTable" width="100%" cellspacing="0">
										<thead>
											<th>Date</th>
											<th>No. of Products Sold</th>
											<th>Total</th>
										</thead>
										<tbody>
										<?php 
										$sql = "SELECT DATE(transactions.Date) as date, SUM(orders.Qty) as sold FROM `transactions` 
										INNER JOIN orders ON orders.Trans_id=transactions.Trans_id GROUP BY DATE(transactions.Date) ORDER BY DATE(transactions.Date) DESC";
										$result=mysqli_query($conn,$sql);
										?>
										<?php if ($result->num_rows > 0) {
												// output data of each row
												while($row = $result->fetch_assoc()) {
												$sql="SELECT SUM(invoice.Total) as total FROM transactions INNER JOIN invoice ON transactions.Trans_id=invoice.Trans_id WHERE DATE(transactions.Date)='{$row['date']}'";
												$res=mysqli_query($conn,$sql);
												$res=mysqli_fetch_assoc($res);
													echo "	
																<tr>
																	<td>".$row['date']."</td>
																	<td>".$row['sold']."</td>
																	<td>".$res['total']."</td>
																	
																</tr>
															";
												}
											} 
											$conn->close();
										?>
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
		
		<script>
			$(function(){
				$('.mydatatable').DataTable();
			});
			
		</script>
        
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
