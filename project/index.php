<?php
    session_start();
    // if(isset($_SESSION['empid'])){
    //     header("Location: php/cashierdashboard.php");
    // }
    session_destroy();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>Login | SIMS</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <link href="https://fonts.googleapis.com/css?family=Assistant:300&display=swap" rel="stylesheet">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet">
</head>

<body class="text-center">
    <script>
        $(function(){
            $('#warning').hide();
            $('form').on('submit', function(e){
              var empid=$('#empid').val();
              var pass=$('#pass').val();
              e.preventDefault();
              if($.isNumeric(empid)){
              $.ajax({
                type:"POST",
                url:'php/loginajax.php',
                data:{empid:empid,pass:pass},
                success:function(res){
                  if(res=='Login'){
                    window.location="php/cashierdashboard.php";
                  }else{
                    $('#warning').show().text(res); 
                  }
                }
              });
              }else{
                $('#warning').show().text("Employee ID doesn't exist");
              } 
          });
        });
    </script>
    <form class="form-signin" id="indexform" method="POST" action="php/cashierdashboard.php">
        <img class="mb-2" src="images/sims.png" alt="" width="150" height="150">
        <h1 class="h3 mb-3 signinfont">Sign in to SIMS</h1>
        <p class="text-danger small" id="warning"></p>
        <div class="bordergray bg-white rounded-lg p-4">
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text " id="basic-addon1"><i class='fas fa-user-alt'></i></span>
                </div>
                <input type="text" class="form-control" required id="empid" name="empid" placeholder="Employee ID"
                    aria-label="Employee ID" aria-describedby="basic-addon1">
            </div>

            <div class="input-group ">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon02"><i class='fas fa-lock'></i></span>
                </div>
                <input type="password" class="form-control" required id="pass" name="pass" placeholder="Password"
                    aria-label="Password" aria-describedby="basic-addon02">
            </div>


            <div class="checkbox mb-2">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>
            <input type="submit" class="btn btn-info btn-block" id="submit" value="Sign In">

        </div>
    
    <div class="borderforpass rounded-lg p-2 mt-3">
        <span class="text-secondary">Forgot Password? </span><a href="php/password.php" id="clickhere"
            rel="noopener noreferrer">Click Here</a>
    </div>
    <p class="mt-4 mb-3 text-muted">&copy; 2019-2020</p>
    </form>
</body>

</html>