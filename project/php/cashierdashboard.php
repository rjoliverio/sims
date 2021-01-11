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
        <title>Dashboard</title>
        <link href="../css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/easy-autocomplete.css" integrity="sha512-PZ83szWxZ41zcHUPd7NSgLfQ3Plzd7YmN0CHwYMmbR7puc6V/ac5Mm0t8QcXLD7sV/0AuKXectoLvjkQUdIz9g==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
    <?php
       include('header.php');
    ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary cardgradient1 text-white mb-4">
                                    <div class="card-header"><span class="lnr lnr-chart-bars mr-2"></span>Total Products</div>
                                    <div class="card-body text-center">
                                       <h4> <?php
                                            $query="SELECT COUNT(*) FROM products";
                                            $row=mysqli_query($conn,$query);
                                            $row=mysqli_fetch_array($row);
                                            echo $row[0];
                                        ?>
                                        </h4>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href data-toggle="modal" data-target=".bd-totalprod-modal-xl">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL -->
                                <div class="modal fade bd-totalprod-modal-xl"tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title h4" id="myExtraLargeModalLabel">Total Products</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-bordered mytable" id="dataTable" width="100%"cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Product ID</th>
                                                        <th>Product Name</th>
                                                        <th>Product Type</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                        <th>Date Added</th>
                                                        <th>Expiry Date</th>
                                                        <th>Supplier</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $query="SELECT * FROM products INNER JOIN supplier_store ON products.Supplier_id=supplier_store.Supplier_id";
                                                        $res=mysqli_query($conn,$query);
                                                        while($row=mysqli_fetch_assoc($res)){
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $row['Prod_id']; ?></td>
                                                        <td><?php echo $row['ProdName']; ?></td>
                                                        <td><?php echo $row['ProdType']; ?></td>
                                                        <td><?php echo $row['Qty']; ?></td>
                                                        <td><?php echo $row['Price']; ?></td>
                                                        <td><?php echo $row['Date_added']; ?></td>
                                                        <td><?php echo $row['Expiry_date']; ?></td>
                                                        <td><?php echo $row['Storename']; ?></td>
                                                    </tr>
                                                        <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- MODAL --> 

                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning cardgradient2 text-white mb-4">
                                <div class="card-header"><span class="lnr lnr-chart-bars mr-2"></span>Low Stock Products</div>
                                    <div class="card-body text-center">
                                       <h4> <?php
                                            $query="SELECT COUNT(*) FROM products WHERE Qty <= 20";
                                            $row=mysqli_query($conn,$query);
                                            $row=mysqli_fetch_array($row);
                                            echo $row[0];
                                        ?>
                                        </h4>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href data-toggle="modal" data-target=".bd-lowstock-modal-xl">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- MODAL -->
                            <div class="modal fade bd-lowstock-modal-xl"tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title h4" id="myExtraLargeModalLabel">Low Stock Products</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-bordered mytable" id="dataTable" width="100%"cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Product ID</th>
                                                        <th>Product Name</th>
                                                        <th>Product Type</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                        <th>Date Added</th>
                                                        <th>Expiry Date</th>
                                                        <th>Supplier</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $query="SELECT * FROM products INNER JOIN supplier_store ON products.Supplier_id=supplier_store.Supplier_id WHERE Qty <= 20";
                                                        $res=mysqli_query($conn,$query);
                                                        while($row=mysqli_fetch_assoc($res)){
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $row['Prod_id']; ?></td>
                                                        <td><?php echo $row['ProdName']; ?></td>
                                                        <td><?php echo $row['ProdType']; ?></td>
                                                        <td><?php echo $row['Qty']; ?></td>
                                                        <td><?php echo $row['Price']; ?></td>
                                                        <td><?php echo $row['Date_added']; ?></td>
                                                        <td><?php echo $row['Expiry_date']; ?></td>
                                                        <td><?php echo $row['Storename']; ?></td>
                                                    </tr>
                                                        <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- MODAL --> 
                            
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success cardgradient3 text-white mb-4">
                                <div class="card-header"><span class="lnr lnr-chart-bars mr-2"></span>Most Stock Products</div>
                                    <div class="card-body text-center">
                                       <h4> <?php
                                            $query="SELECT COUNT(*) FROM products WHERE Qty > 20";
                                            $row=mysqli_query($conn,$query);
                                            $row=mysqli_fetch_array($row);
                                            echo $row[0];
                                        ?>
                                        </h4>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href data-toggle="modal" data-target=".bd-moststock-modal-xl">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL -->
                            <div class="modal fade bd-moststock-modal-xl"tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title h4" id="myExtraLargeModalLabel">Out of Stock Products</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-bordered mytable" id="dataTable" width="100%"cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Product ID</th>
                                                        <th>Product Name</th>
                                                        <th>Product Type</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                        <th>Date Added</th>
                                                        <th>Expiry Date</th>
                                                        <th>Supplier</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $query="SELECT * FROM products INNER JOIN supplier_store ON products.Supplier_id=supplier_store.Supplier_id WHERE Qty > 20";
                                                        $res=mysqli_query($conn,$query);
                                                        while($row=mysqli_fetch_assoc($res)){
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $row['Prod_id']; ?></td>
                                                        <td><?php echo $row['ProdName']; ?></td>
                                                        <td><?php echo $row['ProdType']; ?></td>
                                                        <td><?php echo $row['Qty']; ?></td>
                                                        <td><?php echo $row['Price']; ?></td>
                                                        <td><?php echo $row['Date_added']; ?></td>
                                                        <td><?php echo $row['Expiry_date']; ?></td>
                                                        <td><?php echo $row['Storename']; ?></td>
                                                    </tr>
                                                        <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- MODAL --> 

                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger cardgradient4 text-white mb-4">
                                <div class="card-header"><span class="lnr lnr-chart-bars mr-2"></span>Out of Stock Products</div>
                                    <div class="card-body text-center">
                                       <h4> <?php
                                            $query="SELECT COUNT(*) FROM products WHERE Qty = 0";
                                            $row=mysqli_query($conn,$query);
                                            $row=mysqli_fetch_array($row);
                                            echo $row[0];
                                        ?>
                                        </h4>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href data-toggle="modal" data-target=".bd-outstock-modal-xl">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL -->
                            <div class="modal fade bd-outstock-modal-xl"tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title h4" id="myExtraLargeModalLabel">Most Stock Products</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-bordered mytable" id="dataTable" width="100%"cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Product ID</th>
                                                        <th>Product Name</th>
                                                        <th>Product Type</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                        <th>Date Added</th>
                                                        <th>Expiry Date</th>
                                                        <th>Supplier</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $query="SELECT * FROM products INNER JOIN supplier_store ON products.Supplier_id=supplier_store.Supplier_id WHERE Qty = 0";
                                                        $res=mysqli_query($conn,$query);
                                                        while($row=mysqli_fetch_assoc($res)){
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $row['Prod_id']; ?></td>
                                                        <td><?php echo $row['ProdName']; ?></td>
                                                        <td><?php echo $row['ProdType']; ?></td>
                                                        <td><?php echo $row['Qty']; ?></td>
                                                        <td><?php echo $row['Price']; ?></td>
                                                        <td><?php echo $row['Date_added']; ?></td>
                                                        <td><?php echo $row['Expiry_date']; ?></td>
                                                        <td><?php echo $row['Storename']; ?></td>
                                                    </tr>
                                                        <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- MODAL --> 

                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card mb-4">
                                    <div class="card-header"><i class="fas fa-chart-bar mr-1"></i>Sales Overview</div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">Top Selling Items</div>
                                    <div class="card-body ">
                                        <div class="table-responsive" >
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <th>Total Items Sold</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $query="SELECT SUM(orders.Qty) as qty,products.ProdName FROM `orders` 
                                                            INNER JOIN products ON orders.Prod_id=products.Prod_id WHERE Trans_id=0000000001 GROUP BY orders.Prod_id ORDER BY qty desc LIMIT 3";
                                                    $res=mysqli_query($conn,$query);
                                                    while($row=mysqli_fetch_assoc($res)){
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $row['ProdName']; ?></td>
                                                        <td><?php echo $row['qty']; ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         </div>

                        <div class="card mb-4">
                            <div class="card-header"><i class="fas fa-table mr-1"></i>Recent Purchase Invoice</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Purchase Date</th>
                                                <th>Transaction No.</th>
                                                <th>Cashier</th>
                                                <th>Total</th>
                                                <th>Discount</th>
                                                <th>Type of Payment</th>
                                            </tr>
                                        </thead>
                                       
                                        <tbody>
                                        <?php
                                             $query="SELECT * FROM invoice INNER JOIN transactions ON invoice.Trans_id=transactions.Trans_id 
                                                    INNER JOIN employee_accounts ON transactions.Employee_id=employee_accounts.Employee_id
                                                    INNER JOIN person_info ON employee_accounts.Person_id=person_info.Person_id ORDER BY transactions.Date desc LIMIT 10";
                                             $res=mysqli_query($conn,$query);
                                             while($row=mysqli_fetch_assoc($res)){
                                             ?>
                                             <tr>
                                                <td><?php echo $row['Date']; ?></td>
                                                <td><?php echo $row['Trans_id']; ?></td>
                                                <td><?php echo $row['Fname']." ".$row['Lname']; ?></td>
                                                <td><?php echo $row['Total']; ?></td>
                                                <td><?php echo $row['Discount']; ?></td>
                                                <td><?php echo $row['Payment_type']; ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                         
                            
                            
                        <!-- <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header"><i class="fas fa-chart-area mr-1"></i>Area Chart Example</div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header"><i class="fas fa-chart-bar mr-1"></i>Bar Chart Example</div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div> -->
                        
                    </div>
                </main>
                <?php include('footer.php'); ?>
            </div>
        </div>
        <?php 
            $sql = "SELECT DATE(transactions.Date) as date, SUM(orders.Qty) as sold FROM `transactions` 
            INNER JOIN orders ON orders.Trans_id=transactions.Trans_id GROUP BY DATE(transactions.Date) ORDER BY DATE(transactions.Date) DESC LIMIT 5";
            $result=mysqli_query($conn,$sql);
            ?>
            <?php 
            $date=array();
            $total=array();
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    array_push($date,$row['date']."");
                    $sql="SELECT SUM(invoice.Total) as total FROM transactions INNER JOIN invoice ON transactions.Trans_id=invoice.Trans_id WHERE DATE(transactions.Date)='{$row['date']}'";
                    $res=mysqli_query($conn,$sql);
                    $res=mysqli_fetch_assoc($res);
                    array_push($total,$res['total']);
                }
            }
            ?>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script>
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';
            var date=<?php echo json_encode($date); ?>;
            var total=<?php echo json_encode($total); ?>;
            total=total.map(i=>Number(i));
            // Bar Chart Example
            var ctx = document.getElementById("myBarChart");
            var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: date,
                datasets: [{
                label: "Revenue",
                backgroundColor: "rgba(2,117,216,1)",
                borderColor: "rgba(2,117,216,1)",
                data: total,
                }],
            },
            options: {
                scales: {
                xAxes: [{
                    time: {
                    unit: 'month'
                    },
                    gridLines: {
                    display: false
                    },
                    ticks: {
                    maxTicksLimit: 6
                    }
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: Math.max(...total)+2000,
                    maxTicksLimit: 5
                    },
                    gridLines: {
                    display: true
                    }
                }],
                },
                legend: {
                display: false
                }
            }
            });
        </script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="../assets/demo/datatables-demo.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/jquery.easy-autocomplete.min.js" integrity="sha512-Z/2pIbAzFuLlc7WIt/xifag7As7GuTqoBbLsVTgut69QynAIOclmweT6o7pkxVoGGfLcmPJKn/lnxyMNKBAKgg==" crossorigin="anonymous"></script>
        <script src="../js/search-suggestion.js"></script>
    </body>
</html>
