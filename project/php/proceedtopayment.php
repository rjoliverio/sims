<?php
    session_start();
    include_once('dbconnect.php');
    if(isset($_SESSION['empid'])){
        $res=runQuery($conn,"SELECT * FROM employee_accounts INNER JOIN person_info ON employee_accounts.Person_id=person_info.Person_id WHERE employee_accounts.Employee_id='{$_SESSION['empid']}'");
        $res=mysqli_fetch_array($res);
    }else{
        header("Location: ../index.php");
    }
    if(isset($_GET['orders'])&&isset($_GET['transid'])){
        $_SESSION['orders']=$_GET['orders'];
        $_SESSION['transid']=$_GET['transid'];
        header("Location: proceedtopayment.php");
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
    <link href="http://localhost/project/css/styles.css" rel="stylesheet" />
    <!-- <link href="../css/purchase.css" rel="stylesheet" /> -->
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js"crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/qrcode.js"></script>
    <style>
        .qtyadd{
            cursor:pointer;
        }
        .my-custom-scrollbar {
        position: relative;
        height: 383px;
        overflow: auto;
        }
        .table-wrapper-scroll-y {
        display: block;
        }

    </style>
</head>

<body class="sb-nav-fixed">
    <script>
        
    </script>
    <?php
       include('header.php');
    ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <?php
                        $sql="SELECT * FROM transactions 
                        INNER JOIN employee_accounts ON employee_accounts.Employee_id=transactions.Employee_id
                        INNER JOIN person_info ON person_info.Person_id=employee_accounts.Person_id
                        WHERE transactions.Trans_id='{$_SESSION['transid']}'";
                        $res=mysqli_query($conn,$sql);
                        $res=mysqli_fetch_assoc($res);
                    ?>
                    <div class="mt-4 row">
                        <div class="col-lg-8">
                            <h1>Payment</h1>
                        </div>
                        <div class="col-lg-4 text-right">
                            <a type="button" class="btn-lg btn-success text-white donepayment text-decoration-none" href="purchase.php">Done &raquo;</a>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-xl mr-2">
                            <div class="p-2 border border-gray purchasearea shadow-sm table-wrapper-scroll-y my-custom-scrollbar">
                                <h4 class="text-center  mt-2">Sales Details</h4><hr>
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
                                                $res=json_decode($_SESSION['orders']);
                                                foreach($res as $row){
                                                    echo "<tr>
                                                            <td>".$row->prodname."</td>
                                                            <td id='prodprice'>".$row->prodprice."</td>
                                                            <td id='prodqty' contenteditable='false'>$row->qty</td>
                                                            <td>0</td>
                                                            <td id='prodtotal'>".$row->totalprice."</td>
                                                            </tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <div class="text-center mb-3">
                                        <table width="100%" class="receiptdetails">
                                                <tbody>
                                                    <tr class="border-bottom mb-4 subtotal">
                                                        <td class="text-left font-weight-bold">Subtotal</td>
                                                        <td>Php <span>100.00<span></td>
                                                    </tr>
                                                    <tr class="border-bottom mb-4 discount">
                                                        <td class="text-left font-weight-bold">Discount</td>
                                                        <td>Php <span>0.00<span></td>
                                                    </tr>
                                                    <tr class="border-bottom mb-4 total">
                                                        <td class="text-left font-weight-bold">Total</td>
                                                        <td>Php <span>100.00<span></td>
                                                    </tr>
                                                    <tr class="border-bottom mb-4 typeofpayment">
                                                        <td class="text-left font-weight-bold">Type of Payment</td>
                                                        <td>Cash</td>
                                                    </tr>
                                                    <tr class="border-bottom mb-4 payment">
                                                        <td class="text-left font-weight-bold">Payment/Amount</td>
                                                        <td>Php <span>0.00<span></td>
                                                    </tr>
                                                    <tr class="change">
                                                        <td class="text-left font-weight-bold">Change</td>
                                                        <td>Php <span>0.00<span></td>
                                                    </tr>
                                                </tbody>
                                        </table>
                                    </div>
                            </div>
                            <a type="button" class="btn btn-secondary text-white w-100 text-center mt-3 printreceipt disabled" >Print Receipt</a>
                        </div>
                        
                        <div class="col-xl-4 border border-gray shadow-sm">
                            <div class="w-100">
                                <div class="w-100 mt-3 text-secondary">
                                    <h3 class="text-left d-inline">Total:</h3><h3 class="ml-5 d-inline text-right">Php&nbsp;</h3><h3 class="paymenttotal text-right d-inline">0.00</h3>
                                </div>
                                <hr>
                                <select id="typeofpayment" class="form-control">
                                    <option value="Cash" selected>Cash</option>
                                    <option value="Card" >Card</option>
                                    
                                </select>
                                <input type="number" class="form-control cardnum mt-3" placeholder="Card Number">
                                <div class="input-group mt-2">
                                    <input type="text" class="form-control" id="simsid" placeholder="SIMS Code" readonly aria-label="SIMS Code" aria-describedby="button-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn btn-dark pr-2 pl-2 pt-0 pb-0" id="simscodebtn" type="button" ><i class="fas fa-qrcode"></i></button>
                                    </div>
                                </div>
                                <div class="form-group row mt-2 simspoint">
                                <label for="simspoint" class="col-sm-4 col-form-label simspointlabel">SIMS Points:</label>
                                        <div class="col-sm-8 input input-group">
                                            <input type="text" class="form-control" readonly id="simspoints" placeholder="0.00" >
                                        </div>
                                </div>
                                <div class="form-group row simspoint">
                                    <label for="simspoint" class="col-sm-4 col-form-label ">Use as:</label>
                                    <div class="btn-group col-sm-8 btn-group-sm useas" role="group" aria-label="...">
                                        <button type="button" class="btn btn-outline-secondary useasdiscount">Discount</button>
                                        <button type="button" class="btn btn-secondary useaspayment">Payment</button>
                                    </div>
                                </div>
                                <div class="form-group row mt-2">
                                <label for="cash" class="col-sm-4 col-form-label cashlabel">Cash</label>
                                        <div class="col-sm-8 input input-group">
                                            <input type="number" class="form-control" id="cash" placeholder="0.00" >
                                        </div>
                                </div>
                                <div class="form-group row ">
                                <label for="discount" class="col-sm-4 col-form-label">Discount</label>
                                        <div class="col-sm-8 input input-group">
                                            <input type="text" class="form-control" id="discount" placeholder="0.00" readonly>
                                        </div>
                                </div>
                                <button type="button" class="btn btn-success w-100 mb-2 paypurchase">Pay</button>
                                
                                <!-- MODAL CHANGE -->
                                <div class="modal fade" id="changeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Change</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center ">
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <!-- MODAL CHANGE -->
                            </div>
                            
                                    <!-- MODAL QR SCAN -->
                                    <div class="modal fade" id="scanModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document" >
                                                <div class="modal-content mt-5">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Scan the SIMS Code here:</h5>
                                                        <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <b>Device has camera: </b>
                                                        <span id="cam-has-camera"></span>
                                                        <br>
                                                        <video class="mt-4" muted playsinline id="qr-video" width="465"></video>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    <!-- MODAL QR SCAN -->
                        </div> 
                    </div>
                </div>
            </main>
            <?php include('footer.php'); ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="../assets/printThis/printThis.js"></script>
    <script type="module">
    import QrScanner from "../js/qr-scanner.min.js";
                QrScanner.WORKER_PATH = '../js/qr-scanner-worker.min.js';
    $(function(){
            $('.simspoint').hide();
            function getSubtotal(){
                var subtotal=0.00;
                $(".ordertable tbody tr").each(function(){
                    subtotal+= parseFloat($(this).find("#prodtotal").text());
                });
                $('.receiptdetails .subtotal').find('span').text(subtotal.toFixed(2));
                $('.receiptdetails .total').find('span').text(subtotal.toFixed(2));
                $('.paymenttotal').text(subtotal.toFixed(2));
            }
            getSubtotal();
            $('.cardnum').hide();
            $('#typeofpayment').on('change',function(){
                $('.receiptdetails .typeofpayment').find('td').eq(1).text($(this).val());
                if($(this).val()=="Cash"){
                    $('.useaspayment').attr('disabled',false);
                    $('.useasdiscount').attr('disabled',false);
                    $('.cardnum').hide();
                    $('#cash').val("");
                    $('#cash').attr('readonly',false);
                }else{
                    $('.useaspayment').attr('disabled',true);
                    $('.useasdiscount').attr('disabled',true);
                    $('.cardnum').show();
                    $('#cash').attr('readonly',true);
                    $('#cash').val( $('.receiptdetails .total').find('span').text());
                }
            });
            
        
            $('.useas').hide();
			
            function openQrScan(){
                    const video = document.getElementById('qr-video');
                    const camHasCamera = document.getElementById('cam-has-camera');
                    const camQrResult = document.getElementById('cam-qr-result');
                    // var webcamstream=localMediaStream;
                    function setResult(label, result) {
                        if(result!=""){
                            $.ajax({
                                type:"POST",
                                url:"checkdiscount_ajax.php",
                                data:{result:result},
                                success:function(res){
                                    if(res!=0){
                                        var data=JSON.parse(res);
                                        $('#simspoints').val(data.Points);
                                        $('.simspoint').show();
                                        $('.useas').show();
                                        $('#simsid').val(data.SIMS_code);
                                        $('#scanModal').modal('hide');
                                        scanner.destroy();
                                    }else{
                                        alert("SIMS Code doesn't exist");
                                    }
                                }
                            });
                            
                        }
                    }

                    QrScanner.hasCamera().then(hasCamera => camHasCamera.textContent = hasCamera);
                    var scanner = new QrScanner(video, result => setResult(camQrResult, result));
                return scanner;
            }
            var scanner;
            $('.donepayment').hide();
            function resetReceipt(){
                if($('#typeofpayment').val()=="Cash"){
                    $('#cash').attr('readonly',false);
                }
                $('#cash').val("");
                $('#discount').val("");
                $('.receiptdetails .payment').find('span').text("0.00");
                $('.receiptdetails .change').find('span').text('0.00');
                $('.receiptdetails .typeofpayment').find('td').eq(1).text($('#typeofpayment').val());
                getSubtotal();
            }
            $('#simscodebtn').on('click',function(){
                    resetReceipt();
                    $('#scanModal').modal('show');
                    scanner=openQrScan();
                    scanner.start();
            });
            
			$('#closeModal').on('click',function(){
                scanner.destroy();
                $('#scanModal').modal('hide');
            });
            $('.useaspayment').on('click',function(){
                if($('#simspoints').val() >= parseFloat($('.paymenttotal').text())){
                    $('#cash').val(parseFloat($('.paymenttotal').text()));
                    $('.receiptdetails .typeofpayment').find('td').eq(1).text("SIMS Code");
                    $('#cash').attr('readonly',true);
                    $('.receiptdetails .change').find('span').text('0.00');
                    $('.receiptdetails .payment').find('span').text(parseFloat($('#cash').val()).toFixed(2));
                }else{
                    alert('Cannot be used as Payment!');
                }
            });
            $('.useasdiscount').on('click',function(){
                if($('#simspoints').val()>=100 && $('#simspoints').val()<parseFloat($('.paymenttotal').text())){
                    $('#discount').val($('#simspoints').val());
                    $('.receiptdetails .discount').find('span').text(parseFloat($('#simspoints').val()).toFixed(2));
                    $('.receiptdetails .total').find('span').text((parseFloat($('.receiptdetails .subtotal').find('span').text())-$('#simspoints').val()).toFixed(2));
                    $('.paymenttotal').text((parseFloat($('.receiptdetails .subtotal').find('span').text())-$('#simspoints').val()).toFixed(2));
                }else if($('#simspoints').val() >=parseFloat($('.paymenttotal').text())){
                    alert('Use this as Payment!');
                }else{
                    alert('Insufficient Points!');
                }
            });
            $('#cash').on('keyup',function(){
                if($(this).val()==""){
                    $('.receiptdetails .payment').find('span').text("0.00");
                    $('.receiptdetails .change').find('span').text("0.00");
                }else{
                    $('.receiptdetails .payment').find('span').text(parseFloat($('#cash').val()).toFixed(2));
                    $('.receiptdetails .change').find('span').text(($('#cash').val()-parseFloat($('.paymenttotal').text())).toFixed(2));
                }
                
            });
            
            
            
            function getOrders(){
                $.ajax({
                    url:"getsessionorders_ajax.php",
                    type:"POST",
                    data:{get:"get"},
                    success:function(res){
                        localStorage.setItem('orders',res);
                    }
                });
                var orders=localStorage.getItem('orders');
                return orders;
            }
            getOrders();
            function getTransID(){
                $.ajax({
                    url:"getsessiontransid_ajax.php",
                    type:"POST",
                    data:{get:"get"},
                    success:function(res){
                        localStorage.setItem('transid',res);
                    }
                });
                var trans=localStorage.getItem('transid');
                return trans;
            }
            getTransID();
            function createInvoice(){
                var trans=getTransID();
                localStorage.removeItem('transid');
                var obj={transid:trans,
                        total: $('.receiptdetails .subtotal').find('span').text(),
                        discount:$('.receiptdetails .discount').find('span').text(),
                        payment:$('.receiptdetails .payment').find('span').text(),
                        paymenttype: $('.receiptdetails .typeofpayment').find('td').eq(1).text(),
                        cardnumber:$('.cardnum').val(),
                        simscode:$('#simsid').val(),
                        simspoints:$('#simspoints').val()
                }
                return obj;
            }
            $('.paypurchase').on('click',function(){
                if($('#cash').val()>=parseFloat($('.receiptdetails .total').find('span').text())){
                    var orders=getOrders();
                    var invoice=createInvoice();
                    var simstrans={
                                simscode:invoice.simscode,
                                transtype:"",
                                amount:0
                                }
                    var points=0;
                    if(invoice.simscode!=""){
                        points=parseFloat(invoice.simspoints);
                        if(invoice.paymenttype=="SIMS Code"){
                            points-=parseFloat(invoice.total);
                            simstrans.transtype="Deduct";
                            simstrans.amount=invoice.payment;
                        }else if(invoice.discount!="0.00"){
                            points-=parseFloat(invoice.discount);
                            simstrans.transtype="Deduct";
                            simstrans.amount=parseFloat(invoice.discount);
                        }else{
                            if(parseFloat(invoice.total)>=100){
                                simstrans.transtype="Add";
                                simstrans.amount=Math.floor(parseFloat(invoice.total)/100);
                                points+=parseFloat(simstrans.amount);
                            }
                        }
                    }
                    invoice=JSON.stringify(invoice);
                    simstrans=JSON.stringify(simstrans);
                    $.ajax({
                        url:"processpurchase_ajax.php",
                        type:"POST",
                        data:{orders:orders,invoice:invoice,currentsimspt:points,simstrans:simstrans},
                        success:function(res){
                            if(res=="Success"){
                                $('.printreceipt').removeClass('disabled');
                                $('#cash').attr('readonly',true);
                                $('.cardnum').attr('readonly',true);
                                $('.paypurchase').html("Paid");
                                $('.paypurchase').attr('disabled',true);
                                $('#changeModal .modal-body').html("<h4>Php "+$('.receiptdetails .change').find('span').text()+"</h4>");
                                $('#changeModal').modal('show');
                                $('.donepayment').show();
                            }
                        }
                    });
                }else{
                    alert("Cash is empty!");
                }
            });
            $('.printreceipt').on('click',function(){
                $('.purchasearea').printThis({
                    debug: false,               // show the iframe for debugging
                    importCSS: true,            // import parent page css
                    importStyle: false,         // import style tags
                    printContainer: true,       // print outer container/$.selector
                    loadCSS: ["http://localhost/project/css/styles.css","https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"],
                    pageTitle: "ShopNimo Sales Receipt",              // add title to print page
                    removeInline: false,        // remove inline styles from print elements
                    printDelay: 333,            // variable print delay
                    header: "<div class='text-center m-auto'><img src='project/images/sims2.png' width='150' height='150'><h4>ShopNimo Sales Receipt</h4><span>Nasipit, Talamban, Cebu 6000</span><br><span>Contact No. 0978123456</span></div><br><br>",               // prefix to html
                    footer: '<br><br>Copyright © SIMS | Sales and Inventory Management System 2019',               // postfix to html
                    base: false,                // preserve the BASE tag or accept a string for the URL
                    formValues: true,           // preserve input/form values
                    canvas: false,              // copy canvas content
                    doctypeString: '<!DOCTYPE html>',       // enter a different doctype for older markup
                    removeScripts: false,       // remove script tags from print content
                    copyTagClasses: false,      // copy classes from the html & body tag
                });
            })
        });
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