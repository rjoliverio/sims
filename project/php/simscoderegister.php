<?php
    session_start();
    include_once('dbconnect.php');
    if(isset($_SESSION['empid'])){
        $res=runQuery($conn,"SELECT * FROM employee_accounts INNER JOIN person_info ON employee_accounts.Person_id=person_info.Person_id WHERE employee_accounts.Employee_id='{$_SESSION['empid']}'");
        $res=mysqli_fetch_array($res);
    }else{
        header("Location: ../index.php");
    }
    if(!isset($_GET['send'])){
        unset($_SESSION['sendmsg']);
    }

    if(isset($_POST['sendsubmit'])){
        $_SESSION['sendmsg']="Email Sent!";
        $sender='simscodemembership@gmail.com';
        require '../assets/php-mailer-master/PHPMailerAutoload.php';
        $mail = new PHPMailer;
        $mail->SMTPDebug = 0;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = 'smtp.gmail.com;';  // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = $sender;                     // Your gmail address
        $mail->Password   = '@Simscode';                               // Your gmail password
        $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom($sender, 'ShopNimo');
        $mail->addAddress($_POST["sendemail"]);
        $file_name = $_FILES["sendfile"]["name"];
        move_uploaded_file($_FILES["sendfile"]["tmp_name"], $file_name);
        $mail->addAttachment($file_name);

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $_POST["sendsubject"];
        $mail->Body    = $_POST["sendmessage"];

        $mail->send();

        echo "<script>setTimeout(\"location.href = 'simscodescan.php';\", 1500);</script>";
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
        <title>SIMS Code Register</title>
        <link href="../css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/easy-autocomplete.css" integrity="sha512-PZ83szWxZ41zcHUPd7NSgLfQ3Plzd7YmN0CHwYMmbR7puc6V/ac5Mm0t8QcXLD7sV/0AuKXectoLvjkQUdIz9g==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/qrcode.js"></script>
        <style>
            .qr_border{
                width:250px;
                background:linear-gradient(to right,#203A43,#2c5364);

            }
            .qr_topborder{
                width:300px;

            }
            .borderwidth{
                border-width: 5px !important;
            }
            .next-button{
                padding-left:130px;
                padding-right:130px;
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <?php include('header.php'); ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-3">SIMS Code Register</h1><hr>
                        <div class="register_content <?php if(isset($_GET['send'])){ echo "d-none"; } ?>">
                            <form class="p-3 text-center" id="form1">
                                <div class="alert alert-secondary" role="alert">
                                    Customer Details
                                </div>
                                    <div class="text-center m-auto p-3 bg-light shadow rounded-lg">
                                        <input type="text" required class="form-control form-control-sm w-50 ml-auto mr-auto mb-1" id="fname" placeholder="First Name">
                                        <input type="text"required class="form-control form-control-sm w-50 ml-auto mr-auto mb-1" id="lname" placeholder="Last Name">
                                        <input type="email"required class="form-control form-control-sm w-50 ml-auto mr-auto mb-1" id="email" placeholder="Email Address">
                                        <input type="radio" value="Male" name="gender" id="gender">MALE &emsp;&emsp;
                                        <input type="radio" value="Female" name="gender" id="gender">FEMALE
                                        <input type="text"required class="form-control form-control-sm w-50 ml-auto mr-auto mb-1 mt-1" id="contactnum" placeholder="Contact Number">
                                        <input type="text"required class="form-control form-control-sm w-50 ml-auto mr-auto mb-1" id="address" placeholder="Address">
                                        <input type="number"required class="form-control form-control-sm w-50 ml-auto mr-auto mb-3" id="age" placeholder="Age">
                                        <input type="submit" id="submit"class="form-control form-control-sm btn btn-danger ml-auto mr-auto w-50" value="Generate QR Code" id="age" placeholder="Age">
                                    </div>
                                
                            </form>
                        </div>

                        <div class="qr_content <?php if(isset($_GET['send'])){ echo "d-none"; } ?>">
                            <h5 class="text-center mb-4">Please take a snip of this SIMS Code and click '<b>Next</b>':</h5>
                            <div class="qr_topborder border border-secondary m-auto p-2 text-center">
                                <div class="qr_border m-auto rounded-lg p-4 d-block">
                                    <div id="qrResult" class="bg-secondary borderwidth border border-white"style="height: 200px;width: 200px"></div>
                                </div>
                                <div class="qr_details bg-light mt-2 shadow">
                                    <span class="text-info"><b>SIMS Code</b></span><br>
                                    <span class="small" id="qr_p_details">Rj Oliverio | rjoliveri@gmail.com</span><br>
                                    <span class="small" id="qr_p_expiry">Expiry: 2022-19-03  </span>
                                </div>
                                
                            </div>
                            <div class="text-center mt-3 mb-3">
                                <a href="simscoderegister.php?send=true" class="btn btn-danger next-button">Next</a>
                            </div>
                        </div>

                        <div class="qr_send_customer <?php if(isset($_GET['send'])){ echo "d-block"; }else{ echo "d-none"; } ?> mb-4">
                            <div class="alert alert-success text-center" role="alert">
                                <?php if(isset($_SESSION['sendmsg'])){ echo "Email Sent!"; }else{ echo "Send the snipped SIMS Code to Customer's Email"; } ?>
                            </div>
                            <div class="<?php if(!isset($_SESSION['sendmsg'])){ echo "d-block"; }else{ echo "d-none"; } ?>">
                                <form action="simscoderegister.php?send=true" method="POST" enctype="multipart/form-data">
                                    <div class="text-center m-auto p-3 bg-light shadow rounded-lg">
                                        <input type="email" name="sendemail" class="form-control form-control-sm w-50 ml-auto mr-auto mb-1" id="sendemail" placeholder="Email Address">
                                        <input type="text" name="sendsubject"class="form-control form-control-sm w-50 ml-auto mr-auto mb-1" id="sendsubject" placeholder="Subject" value="SIMS Code Membership | ShopNimo">
                                        <textarea name="sendmessage" class="form-control form-control-sm w-50 ml-auto mr-auto mb-1" name="" id="" cols="30" rows="6" placeholder="Type your message here...">  Thank you for availing our SIMS Code membership! Attached here is your SIMS Code. You can now use this code to any ShopNimo store to claim points for every transaction you make with us and use this to have pay or as discounts on your next purchases. You may also ask on the cashier if you want to know your current status and points.
                                            Happy to serve you! 
                                                        -ShopNimo Convenience Store
                                        </textarea>
                                        <input type="file"required name="sendfile" class="form-control form-control-sm  w-50 ml-auto mr-auto mb-1 p-2 h-auto">
                                        <input type="submit" name="sendsubmit" class="form-control form-control-sm btn btn-danger ml-auto mr-auto w-50 mb-2" value="Send">
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </main>
                <?php include('footer.php'); ?>
            </div>
        </div>
        <script type="text/javascript">
            var qrcode = new QRCode(document.getElementById('qrResult'), {
                                width: 190,
                                height: 190
                            });
        $(function(){
            // $('.register_content').hide();
            $('.qr_content').hide();
            if(localStorage.getItem('userdetails')!=null){
                var mydata=JSON.parse(localStorage.getItem('userdetails'));
                $('#sendemail').val(mydata.Email);
            }
            
            $('#form1').on('submit',function(e){
                
                var fname=$('#fname').val();
                var lname=$('#lname').val();
                var email=$('#email').val();
                var gender=$('input[name="gender"]:checked').val();
                var contactnum=$('#contactnum').val();
                var address=$('#address').val();
                var age=$('#age').val();
                var str={fname:fname,lname:lname,email:email,gender:gender,contactnum:contactnum,address:address,age:age};
                str=JSON.stringify(str);
                e.preventDefault();
                $.ajax({
                    type:"POST",
                    url:"simscoderegister_ajax.php",
                    data:{myJson:str},
                    success:function(res){
                        if(res!="Error"){
                            $('.register_content').hide();
                            $('.qr_content').show();
                            
                            var data=JSON.parse(res);
                            
                            $('#qr_p_details').text(data.Fname+" "+data.Lname+" | "+data.Email);
                            $('#qr_p_expiry').text("Expiry: "+data.Expiry_date);
                            localStorage.setItem('userdetails',JSON.stringify(data));
                            qrcode.makeCode(data.SIMS_code);

                        }
                    }
                });
            });

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