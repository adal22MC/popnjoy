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

    <?php include('navegacion.php') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- TABLA INSUMOS -->
      <div class="container-fluid pt-4">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">

                <button id="btnAgregarInsumo" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalInsumos">
                  Agregar un nuevo Insumo
                </button>
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tablaInsumos" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>ID Insumo</th>
                      <th>Insumo</th>
                      <th>Stock</th>
                      <th>Stock min</th>
                      <th>Stock max</th>
                      <th>Unidad de medida</th>
                      <th>Status</th>
                      <th>Acciones</th>
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
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /. TABLA INSUMOS -->
      </section>

      <!-- /.content -->
    </div>


  <!--=====================================
  MODAL AGREGAR INSUMO
  ======================================-->

  <div id="modalInsumos" class="modal fade" role="dialog">

    <div class="modal-dialog">

      <div class="modal-content">

        <form id="formInsumos">

          <!--=====================================
              HEADER DEL MODAL
          ======================================-->

          <div class="modal-header">
            <h5 class="modal-title" id="tituloModal">Nuevo Insumo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <!--=====================================
          CUERPO DEL MODAL
          ======================================-->

          <div class="modal-body">

            <div class="box-body">

              <!-- ENTRADA PARA EL NOMBRE -->
              <div class="input-group pt-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-info"></i>
                  </span>
                </div>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del insumo" required>
              </div>

              <!-- ENTRADA PARA EL STOCK MINIMO -->
              <div class="input-group pt-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-battery-quarter"></i>
                  </span>
                </div>
                <input type="number" class="form-control" id="stock_min" name="stock_min" placeholder="Stock minimo" required>
              </div>

              <!-- ENTRADA PARA EL STOCK MAXIMO -->
              <div class="input-group pt-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-battery-full"></i>
                  </span>
                </div>
                <input type="number" class="form-control" id="stock_max" name="stock_max" placeholder="Stock maximo" required>
              </div>

              <!-- ENTRADA PARA LA UNIDAD DE MEDIDA -->
              <div class="input-group pt-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-balance-scale-right"></i>
                  </span>
                </div>
                <input type="text" class="form-control" id="unidad_medida" name="unidad_medida" placeholder="Unidad de medida" required>
              </div>

            </div>

          </div>

          <!--=====================================
          PIE DEL MODAL
          ======================================-->

          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
            <button id="btnFormInsumos" type="submit" class="btn btn-primary">
                Agregar Insumo
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ./wrapper -->

  <?php include('scripts.php'); ?>
  <script src="dist/js/pages/insumos.js"></script>
  
</body>


</html>