<?php

  session_start();
  if(isset($_SESSION['usuario'])){
    header('Location: admin.php');
  }

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema | Log in</title>
  <link rel="shortcut icon" href="dist/img/logo.jpeg" type="image/x-icon">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Theme style  -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">


  <!-- sweetalert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
  <!-- SweetAlert 2 -->
  <script src="plugins/sweetalert2/sweetalert2.all.js"></script>

  <!-- ESTILOS PERSONALIZADOS  -->
  <link rel="stylesheet" href="dist/css/index.css"> 
</head>

<body class="bg-dark">

    <div class="container pt-4">
        <div class="row justify-content-md-center  mt-5">
            <div class="col-sm-11 col-ms-12 col-lg-6" id="contenedor">
                <div class="card border-0">
                    <div class="card-header text-white">
                        <img src="dist/img/logo.jpeg" alt="logoPos">
                    </div>
                    <div class="card-body form">
                        <form id="formIngresar">
                            <div class="form-group">
                                <input name="usuario" id="username" class="form-control text" type="text" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <input name="pass" id="password" class="form-control text" type="password" placeholder="Password" required>
                            </div>
                            <button id="entrar" type="submit" class="btn btn-block rounded-pill">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <strong>Copyright &copy; 2020</strong>
        All rights reserved Pop'n Joy.
    </footer>
  

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App 
    <script src="dist/js/adminlte.min.js"></script>
    

    <?php include('scripts.php') ?>
    <script src="dist/js/pages/index.js"></script>

</body>

</html>