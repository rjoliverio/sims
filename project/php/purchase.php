<?php
    session_start();
    include_once('dbconnect.php');
    if(isset($_SESSION['empid'])){
        $res=runQuery($conn,"SELECT * FROM employee_accounts INNER JOIN person_info ON employee_accounts.Person_id=person_info.Person_id WHERE employee_accounts.Employee_id='{$_SESSION['empid']}'");
        $res=mysqli_fetch_array($res);
    }else{
        header("Location: ../index.php");
    }
    if(isset($_SESSION['orders'])){
        unset($_SESSION['orders']);
    }
    if(isset($_SESSION['transid'])){
        unset($_SESSION['transid']);
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
        $(function(){
            $('#exampleModal').modal('show');
            // $('#searchmodal').on('shown.bs.modal', function(){
            //     var item = $('#modalsearchitem').val();
            //     $('#loadtable').load('loadProducts.php', {item:item});
            // });
            // $('#modalsearchitem').on('change', function(){
            //     var item = $('#modalsearchitem').val();
            //     $('#products').load('loadProducts.php', {item:item});
            // });
            var prodcount=0;
            function getSubtotal(){
                prodcount=0;
                var subtotal=0.00;
                $(".ordertable tbody tr").each(function(){
                    prodcount++;
                    $(this).find("td:first").text(prodcount);
                    subtotal+= parseFloat($(this).find("#prodtotal").text());
                });
                $('#subtotal').val(subtotal.toFixed(2));
                $('#totalamount').text(subtotal.toFixed(2));
            }
            function resetTrans(){
                $(".ordertable tbody tr").each(function(){
                   $(this).remove();
                });
                $('#subtotal').val("0.00");
                $('#totalamount').text("0.00");
                prodcount=0;
            }
            $('#reset').on('click',function(){
                resetTrans();
            });
            $('input[list="products"]').on('change',function(){
                if($(this).val()!=""){
                    if($('#id_trans').val()!=""){
                        var data=$(this).val();
                        prodcount++;
                        $.ajax({
                            url:"purchaseselect_ajax.php",
                            type:"POST",
                            data:{data:data,prodcount:prodcount},
                            success:function(res){
                                $('.ordertable tbody').append(res);
                                getSubtotal();
                            }
                        });
                        $('input[list="products"]').val("");
                    }else{
                        alert("Unable to transact! Make sure the Transaction ID is not empty.");
                        $('input[list="products"]').val("");
                    }
                }
            });
            $('#loadtransaction').on('click',function(){
                data=$('.userdetails span').text();
                $.ajax({
                    url:"loadtransaction_ajax.php",
                    type: "POST",
                    data:{empid:data},
                    success:function(res){
                        res=JSON.parse(res);
                        $('#id_trans').val(res.Trans_id);
                        $('#date_trans').val(res.Date);
                        $('#cashier').val(res.Fname+" "+res.Lname);
                    }
                });
            });
            $('#clickidsearch').on('click',function(){
                $('#transid').load('loadtransactionid_ajax.php',{click:"click"});
            });

            $('#loadtransactionid').on('click',function(){
                var data=$('#transid').val();
                data=JSON.parse(data);
                $('#id_trans').val(data.Trans_id);
                $('#date_trans').val(data.Date);
                $('#cashier').val(data.Fname+" "+data.Lname);
            });

            // $('.ordertable tbody').on('click','tr',function(){
            //     var qty=$(this).find('.qtynum').text();
            //     alert(qty);
                
            //     $(this).find('.qtyminus').on('click',function(){
            //         qty--;
            //     });
            //     $(this).find('.qtynum').text(qty);
                
            // });
            
            $('.ordertable tbody').on('click','.qtyplus',function(){
                var qty=parseInt($(this).parent().find('.qtynum').text());
                var total=parseFloat($(this).closest('tr').find('#prodtotal').text());
                var price=total/qty;
                qty++;
                $(this).parent().find('.qtynum').text(qty);
                total+=price;
                $(this).closest('tr').find('#prodtotal').text(total);
                getSubtotal();
            });
            $('.ordertable tbody').on('click','.qtyminus',function(){
                var qty=parseInt($(this).parent().find('.qtynum').text());
                var total=parseFloat($(this).closest('tr').find('#prodtotal').text());
                var price=total/qty;
                if(qty>1){
                    qty--;
                    $(this).parent().find('.qtynum').text(qty);
                    total-=price;
                    $(this).closest('tr').find('#prodtotal').text(total);
                    getSubtotal();
                }else{
                    alert("Invalid Quantity");
                }
                
            });
            $('.ordertable tbody').on('click','#proddelete',function(){
                $(this).closest('tr').remove();
                getSubtotal();
            });
            $('.ordertable tbody').on('dblclick','#prodqty',function(){
                var table=$(this).attr('contenteditable');
                if(table=='false'){
                    $(this).find('.qtyminus').hide();
                    $(this).find('.qtyplus').hide();
                    $(this).find('.qtynum').text("");
                    $(this).attr('contenteditable','true');
                }
            });
            $('.ordertable tbody').on('blur','#prodqty',function(){
                $(this).attr('contenteditable','false');
                var qtytext=$(this).text();
                if(qtytext==" "){
                    qtytext=1;
                }
                var total=parseFloat($(this).closest('tr').find('#prodtotal').text());
                var price=parseFloat($(this).closest('tr').find('#prodprice').text());
                total=price*qtytext;
                $(this).closest('tr').find('#prodtotal').text(total);
                var mytext="<i class='fas fa-minus-circle text-danger qtyadd qtyminus float-left'></i> <span class='qtynum'>"+ qtytext +"</span><i class=' float-right fas fa-plus-circle text-danger qtyplus qtyadd'></i>"
                $(this).html(mytext);
                getSubtotal();
            });
            $('.proceedpay').on('click',function(){
                var orders=[];
                $(".ordertable tbody tr").each(function(){
                    var obj={prodid:$(this).find('td').eq(1).text(),
                    prodprice:$(this).find('td').eq(3).text(),
                    prodname:$(this).find('td').eq(2).text(),
                    qty:$(this).find('.qtynum').text(),
                    totalprice:$(this).find('td').eq(6).text()};
                    orders.push(obj);
                });
                var order=JSON.stringify(orders);
                var transid=$('#id_trans').val();
                window.location="proceedtopayment.php?orders="+order+"&transid="+transid;
            });
        });
    </script>
    <?php
       include('header.php');
    ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                
                <div class="modal fade m-5" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Open Cash Register</h5>
                            </div>
                            <div class="modal-body">
                                Click <span class="text-success font-weight-bold">OK</span> to automatically start another transaction
                                or Click <span class="text-success font-weight-bold">Search</span> to search for the existing transaction ID.
                            </div>
                            <div class="modal-footer">
                                <a type="button" class="btn btn-secondary text-white" data-dismiss="modal">Search</a>
                                <button type="button" id="loadtransaction" class="btn btn-success" data-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                    <h1 class="mt-4">Purchase</h1>
                    <div class="row mb-3">
                        <div class="col-xl mr-2">
                            <div class="p-2 border border-gray purchasearea shadow-sm ">
                                <h4 class="mt-4"> Point of Sale </h4>
                                <form
                                    class="d-none w-100 d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                                    <div class="input-group">
                                    <input type="text" list="products" class=" form-control w-75" placeholder="Enter Item Name or Id here..." id="modalsearchitem">
                                <datalist id="products">
                                    <?php
                                        $query = "SELECT * FROM products";
                                        $rs = mysqli_query($conn, $query);
                                        foreach(mysqli_fetch_all($rs) as $trav){
                                            if($trav[3]>0){
                                            echo "<option class='text-warning' value='".$trav[0]."'>".$trav[1]." | ".$trav[3]." Stock/s </option>";
                                            }
                                        }
                                    ?>
                                </datalist>
                                    </div>
                                </form>
                                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table table-bordered mb-4 mt-3 ordertable table-striped" id="table" width="100%" cellspacing="0">
                                        <thead>
                                            <tr class="text-center">
                                                <th width="5%">#</th>
                                                <th width="20%">Id</th>
                                                <th width="29%">Item</th>
                                                <th width="13%">Price</th>
                                                <th width="20%">Qty</th>
                                                <th width="6%">Disc%</th>
                                                <th width="13%">Total</th>
                                                <th width="6%"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="col-xl-4 border border-gray shadow-sm">
                            <button type="button" class="btn btn-dark mt-2" id="reset"><i class="fas fa-times"></i> Reset</button>
                            <hr>
                            
                            <div class="form-group row">
                                <label for="id_trans" class="col-sm-4 col-form-label">Id Trans.</label>
                                <div class="col-sm-8 input input-group">
                                    <input type="text" class="form-control" id="id_trans" placeholder="" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-dark pr-2 pl-2 pt-0 pb-0" id="clickidsearch" type="button" data-toggle="modal" data-target="#idsearch"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade m-5" id="idsearch" tabindex="-1" role="dialog" aria-labelledby="idsearchLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Search for Transaction ID</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <select class="form-control" name="transid" id="transid"></select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="loadtransactionid" class="btn btn-success" data-dismiss="modal">Done</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="date_trans" class="col-sm-4 col-form-label">Date Trans.</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="date_trans" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cashier" class="col-sm-4 col-form-label">Cashier</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="cashier" placeholder="" readonly>
                                </div>
                            </div>
                            <!-- <div class="form-group row">
                                <label for="disc" class="col-sm-4 col-form-label">Dsc %</label>
                                <div class="col-sm-8 input input-group">
                                    <input type="text" class="form-control" id="totaldisc" placeholder="" value="0" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-dark pr-2 pl-2 pt-0 pb-0" id="clickModal" data-toggle="modal" data-target="#scanModal" type="button"><i class="fas fa-qrcode"></i></button>
                                    </div> -->
                                    <!-- MODAL QR SCAN -->
                                    <!-- <div class="modal fade" id="scanModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    </div> -->
                                    <!-- MODAL QR SCAN -->
                                <!-- </div>
                            </div> -->
                            <!-- <div class="form-group row">
                                <label for="discrp" class="col-sm-4 col-form-label">Disc Price</label>
                                <div class="col-sm-8 input-group">
                                    <div class="input-group-append">
                                        <button class="btn btn-dark pr-2 pl-2 pt-0 pb-0" type="button">₱</button>
                                    </div>
                                    <input type="text" class="form-control" id="totaldiscpr" placeholder="" value="0.00" readonly>
                                </div>
                            </div> -->
                            <div class="form-group row">
                                <label for="subtotal" class="col-sm-4 col-form-label">Sub Total</label>
                                <div class="col-sm-8 input-group">
                                    <div class="input-group-append">
                                        <button class="btn btn-dark pr-2 pl-2 pt-0 pb-0" type="button">₱</button>
                                    </div>
                                    <input type="text" class="form-control" id="subtotal" placeholder="" value="0.00" readonly>
                                </div>
                            </div>
                            <div class="card border-0">
                                <div class="row ">
                                    <div class="col">
                                        <div class="card-body float-left text-white bg-warning">
                                            <h1 class="card-title">Php</h1>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card-body">
                                            <h1 class="card-title float-right font-weight-bold" id="totalamount">0.00
                                            </h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <button type="button" class="btn btn-success w-100 mb-3 proceedpay">Proceed to Payment</button>
                        </div>
                    </div>
                </div>
                <!-- MODAL -->
                <!-- <div class="modal fade" id="searchmodal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="loadtable">
                            </div>
                        </div>
                    </div>
                </div> -->
            </main>
            <?php include('footer.php'); ?>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
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