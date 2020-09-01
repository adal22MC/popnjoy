<?php

  session_start();
  if(isset($_SESSION['usuario'])){}else{
    header('Location: index.php');
  }

  include_once("models/dia_modelo.php");

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
                    <!-- TABLA HISTORIAL CIERRES  -->
                    <div class="col-md-12">
                        <div class="container-fluid">
                            
                                <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title">Historial de cierres</h2>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped tableHistorialClientes">
                                    <thead>
                                        <tr>
                                            <th>ID CIERRE</th>
                                            <th>FECHA</th>
                                            <th>HORA</th>
                                            <th>TOTAL VENTA</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                           $dia = new Dia();
                                           $dia->llenarTablaCierres();
                                        ?>
                                    </tbody>

                                    </table>
                                </div>
                                <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
  
                        </div>
                    <!-- /. TABLA CIERRES -->
                    </div>
                </div>
            </div>
          </section>

      </div>
      <!-- ./ content-wrapper-->


      <?php include('footer.php') ?>
  </div>

 
  <?php include('scripts.php'); ?>
  <script src="dist/js/pages/historial_cierres.js"></script>

</body>