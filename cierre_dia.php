<?php

  session_start();
  if(isset($_SESSION['usuario'])){}else{
    header('Location: index.php');
  }

  
  include("models/ventas_modelo.php");
  include("models/dia_modelo.php");
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
                    <!-- TABLA HISTORIAL VENTAS HOY  -->
                    <div class="col-md-12">
                        <div class="container-fluid">
                            
                                <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title pr-3 mt-2">Ventas de Hoy</h2>
                                    <?php
                                      $dia = new Dia();
                                      $ban = $dia->verificiarDia();
                                      if($ban){
                                    ?> 
                                    <button id="cerrarDia" class="btn btn-primary">CERRAR DIA</button>
                                    <?php
                                      }else{
                                    ?>  <button id="cerrarDia" class="btn btn-primary disabled">DIA CERRADO</button>
                                    <?php
                                      }
                                    ?>
                                    
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
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                            ModeloVentas::llenarTablaVentasDia();
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
  <script src="dist/js/pages/cierre_dia.js"></script>

</body>