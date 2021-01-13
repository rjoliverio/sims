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
    <title>Purchase</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <!-- <link href="../css/purchase.css" rel="stylesheet" /> -->
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js"crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/qrcode.js"></script>
    
</head>

<body class="sb-nav-fixed">
    <?php
       include('header.php');
    ?>
        <div id="layoutSidenav_content">
            <main>
                <?php
                        $sql="SELECT * FROM invoice 
                        INNER JOIN transactions ON transactions.Trans_id=invoice.Trans_id
                        INNER JOIN employee_accounts ON employee_accounts.Employee_id=transactions.Employee_id
                        INNER JOIN person_info ON person_info.Person_id=employee_accounts.Person_id
                        WHERE invoice.Invoice_id='{$_GET['invoiceid']}'";
                        $res=mysqli_query($conn,$sql);
                        $res=mysqli_fetch_assoc($res);
                    ?>
                <div class="container-fluid">
                    <div class="mt-4 row">
                        <div class="col-lg-8">
                            <h1>Receipt</h1>
                        </div>
                        <div class="col-lg-4 text-right">
                            <button class="btn btn-lg btn-secondary text-white printreceipt "><i class="fas fa-print"></i> Print Receipt</button>
                            <a type="button" class="btn btn-lg btn-success text-white donepayment text-decoration-none" href="reports.php">Done &raquo;</a>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center mb-3 purchasearea">
                        <div class='text-center m-auto'>
                            <img src='../images/sims2.png' width='150' height='150'>
                            <h4>ShopNimo Sales Receipt</h4>
                            <span>Nasipit, Talamban, Cebu 6000</span><br>
                            <span>Contact No. 0978123456</span>
                        </div><br><br>
                        <div class="alert alert-secondary " role="alert">
                            <h5 class="pt-2">Sales Details</h5>
                        </div>
                                <div class="text-center mt-3">
                                    <span class="font-weight-bold text-secondary">ShopNimo Convenience Store</span><br>
                                    <span><?php echo $res['Date']; ?></span><br>
                                    <span>Sales Receipt</span><br>
                                    <span>Sold by: <?php echo $res['Fname']." ".$res['Lname']; ?></span><br>
                                    <span>Sold to: Walk-in customer</span><br> <hr>
                                </div>
                                <table class="table table-bordered mb-3  ordertable table-striped" id="table" width="100%" cellspacing="0">
                                        <thead>
                                            <tr class="text-center">
                                                <th width="29%">Items</th>
                                                <th width="13%">Price</th>
                                                <th width="13%">Qty</th>
                                                <th width="6%">Disc%</th>
                                                <th width="15%">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php
                                                $sql="SELECT orders.Prod_id,orders.Qty,products.Price,products.ProdName FROM orders INNER JOIN products ON orders.Prod_id=products.Prod_id WHERE orders.Trans_id={$res['Trans_id']}";
                                                $rows=mysqli_query($conn,$sql);
                                                while($row=mysqli_fetch_assoc($rows)){
                                                    echo "<tr>
                                                            <td>".$row['ProdName']."</td>
                                                            <td id='prodprice'>".$row['Price']."</td>
                                                            <td id='prodqty' contenteditable='false'>".$row['Qty']."</td>
                                                            <td>0</td>
                                                            <td id='prodtotal'>".$row['Price'] * $row['Qty']."</td>
                                                            </tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                    <br>
                                    <div class="text-center mb-3">
                                        <table width="100%" class="receiptdetails">
                                                <tbody>
                                                    <tr class="border-bottom mb-4 subtotal">
                                                        <td class="text-left font-weight-bold">Subtotal</td>
                                                        <td>Php <span><?php echo number_format($res['Total'],2); ?><span></td>
                                                    </tr>
                                                    <tr class="border-bottom mb-4 discount">
                                                        <td class="text-left font-weight-bold">Discount</td>
                                                        <td>Php <span><?php echo number_format($res['Discount'],2); ?><span></td>
                                                    </tr>
                                                    <tr class="border-bottom mb-4 total">
                                                        <td class="text-left font-weight-bold">Total</td>
                                                        <td>Php <span><?php echo number_format($res['Total']-$res['Discount'],2); ?><span></td>
                                                    </tr>
                                                    <tr class="border-bottom mb-4 typeofpayment">
                                                        <td class="text-left font-weight-bold">Type of Payment</td>
                                                        <td><?php echo $res['Payment_type']; ?></td>
                                                    </tr>
                                                    <tr class="border-bottom mb-4 payment">
                                                        <td class="text-left font-weight-bold">Payment/Amount</td>
                                                        <td>Php <span><?php echo number_format($res['Payment'],2); ?><span></td>
                                                    </tr>
                                                    <tr class="change">
                                                        <td class="text-left font-weight-bold">Change</td>
                                                        <td>Php <span><?php echo number_format($res['Payment']-$res['Total'],2); ?><span></td>
                                                    </tr>
                                                </tbody>
                                        </table>
                                    </div>
                        </div>
                </div>
            </main>
            <?php include('footer.php'); ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="../assets/printThis/printThis.js"></script>
    <script>
         $('.printreceipt').on('click',function(){
                $('.purchasearea').printThis({
                    debug: false,               // show the iframe for debugging
                    importCSS: true,            // import parent page css
                    importStyle: true,         // import style tags
                    printContainer: true,       // print outer container/$.selector
                    loadCSS: ["/sims/project/css/styles.css","https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"],
                    pageTitle: "ShopNimo Sales Receipt",              // add title to print page
                    removeInline: false,        // remove inline styles from print elements
                    printDelay: 333,            // variable print delay
                    header: null,               // prefix to html
                    footer: '<br><br>Copyright © SIMS | Sales and Inventory Management System 2019',               // postfix to html
                    base: false,                // preserve the BASE tag or accept a string for the URL
                    formValues: true,           // preserve input/form values
                    canvas: false,              // copy canvas content
                    doctypeString: '<!DOCTYPE html>',       // enter a different doctype for older markup
                    removeScripts: false,       // remove script tags from print content
                    copyTagClasses: false,      // copy classes from the html & body tag
                });
            })
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <!-- <script src="../js/purchase.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <!-- <script src="../assets/demo/chart-area-demo.js"></script>
    <script src="../assets/demo/chart-bar-demo.js"></script> -->
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="../assets/demo/datatables-demo.js"></script>
</body>

</html>