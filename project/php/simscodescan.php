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
        <title>Dashboard</title>
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
                        <h1 class="mt-3">SIMS Code Scanner</h1><hr>
                        <div id="scan_modal" class="m-auto text-center">
                            <button type="button" class="btn btn-primary btn-lg" id="clickModal" data-toggle="modal" data-target="#scanModal">
                                Click to scan SIMS Code
                            </button>

                            <!-- Modal -->
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
                        </div>

                    </div>
                       
                </main>
                <?php include('footer.php'); ?>
            </div>
        </div>
        <script type="module">
			import QrScanner from "../js/qr-scanner.min.js";
    		    QrScanner.WORKER_PATH = '../js/qr-scanner-worker.min.js';
            $('#clickModal').on('click',function(){
                
                const video = document.getElementById('qr-video');
                const camHasCamera = document.getElementById('cam-has-camera');
                const camQrResult = document.getElementById('cam-qr-result');

                function setResult(label, result) {
                    if(result!=""){
                        $.ajax({
                            type:"POST",
                            url:"checkmember_ajax.php",
                            data:{result:result},
                            success:function(res){
                                if(res!=0){
                                    window.location="simscodemember.php?scan="+result;
                                }else{
                                    alert("SIMS Code doesn't exist");
                                }
                            }
                        });
                        
                    }
                    // label.textContent = result;
                    // label.style.color = 'teal';
                    // clearTimeout(label.highlightTimeout);
                    // label.highlightTimeout = setTimeout(() => label.style.color = 'inherit', 100);
                }

                QrScanner.hasCamera().then(hasCamera => camHasCamera.textContent = hasCamera);

                const scanner = new QrScanner(video, result => setResult(camQrResult, result));
                scanner.start();
            });
			$('#closeModal').on('click',function(){
                window.location="simscodescan.php";
            });

        </script>
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