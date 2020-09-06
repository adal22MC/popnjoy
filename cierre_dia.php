<?php

  session_start();
  if(!isset($_SESSION['usuario'])){
    header('Location: index.php');
  }

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
                                    
                                    <button id="cerrarDia" class="btn btn-outline-primary btn-sm">
                                      CERRAR DIA
                                    </button>
                                    
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="tablaVentas" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                          <th>ID VENTA</th>
                                          <th>CLIENTE</th>
                                          <th>FECHA</th>
                                          <th>HORA</th>
                                          <th>TOTAL VENDIDO</th>
                                          <th>PRODUCTOS VENDIDOS</th>
                                          <th>ACCIONES</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        
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