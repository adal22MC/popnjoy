<?php

  session_start();
  if(isset($_SESSION['usuario'])){}else{
    header('Location: index.php');
  }

  include("models/producto_modelo.php");

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <?php include('cabezera.php'); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  
  <div class="wrapper">
      <?php include('navegacion.php') ?>

      <div class="content-wrapper">
        
          <section>
            <div class="container-fluid pt-4"> 
                <div class="row">
                    <!-- TABLA HISTORIAL VENTAS  -->
                    <div class="col-md-12">
                        <div class="container-fluid">
                            
                                <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title">Historial de ventas</h2>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped tableHistorialClientes">
                                    <thead>
                                        <tr>
                                        <th>ID VENTA</th>
                                        <th>CLIENTE</th>
                                        <th>FECHA</th>
                                        <th>HORA</th>
                                        <th>TOTAL VENDIDO</th>
                                        <th>PDF</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                            ModeloProducto::llenarTablaHistorialVentas();
                                        ?>
                                    </tbody>

                                    </table>
                                </div>
                                <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
  
                        </div>
                    <!-- /. TABLA PRODUCTOS -->
                    </div>
                      
                </div>
            </div>
          </section>

      </div>
      <!-- ./ content-wrapper-->


      <?php include('footer.php') ?>
  </div>

 
  <?php include('scripts.php'); ?>
  <script src="dist/js/pages/historial_ventas.js"></script>

</body>