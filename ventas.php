<?php

session_start();
if (isset($_SESSION['usuario'])) {
} else {
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

            <div class="col-md-5">

              <!-- ENTRADA PARA EL STOCK MINIMO -->
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-dollar-sign"></i>
                  </span>
                </div>
                <label class="form-control" id="labelTotal">Total a pagar : </label>
              </div>

              <!-- TABLE: VENTAS -->
              <div class="card">
                <div class="card-header border-transparent">
                  <h3 id="totalApagar" class="card-title">Lista de productos a vender</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->

                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table id="tableListaProductos" class="table m-0 listProductVenta">
                      <thead>
                        <tr>
                          <th>Eliminar</th>
                          <th>Producto</th>
                          <th>Cantidad</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                  </div>
                  <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->

                <div class="card-footer clearfix">
                  <a href="ventas.php" class="btn btn-sm btn-danger float-left">Cancelar</a>
                  <button id="procesarVenta" class="btn btn-sm btn-info float-right">Realizar venta</button>
                </div>
                <!-- /.card-footer -->
              </div>
              <!-- /.card -->
            </div>


            <div class="col-md-7">
              <!-- TABLA PRODUCTOS -->
              <div class="container-fluid">
                <div class="row">
                  <div class="col-12">

                    <div class="card">
                      <div class="card-header">
                        <h2 class="card-title">Lista de todos los productos</h2>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <table id="tablaProductos" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Nombre</th>
                              <th>Categoria</th>
                              <th>Stock</th>
                              <th>Stock min</th>
                              <th>Stock max</th>
                              <th>Precio</th>
                              <th>Observaciones</th>
                              <th>Status</th>
                              <th>Descripcion</th>
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
              <!-- /. TABLA PRODUCTOS -->
            </div>

          </div>
        </div>
      </section>

    </div>
    <!-- ./ content-wrapper-->


    <!--=====================================
      MODAL SELECCIONAR CLIENTE
      ====================================== -->

    <div id="modalSeleccionarCliente" class="modal fade" role="dialog">

      <div class="modal-dialog">

        <div class="modal-content">

          <form id="formSeleccionarCliente" name="formSucursal">

            <!--=====================================
                  HEADER DEL MODAL
              ======================================-->

            <div class="modal-header">

              <h5 class="modal-title" id="exampleModalLabel">Selecciona el cliente al que le venderas</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>

            </div>

            <!--=====================================
              CUERPO DEL MODAL
              ======================================-->

            <div class="modal-body">

              <div class="box-body">
                <!-- ENTRADA PARA ELEGI EL NOMBRE DEL CLIENTE -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fab fa-cuttlefish"></i>
                    </span>
                  </div>
                  <select class="form-control" name="selectCliente" id="selectCliente">
                      <option value="default">Selecciona un cliente</option>
                  </select>
                </div>
              </div>

            </div>

            <!--=====================================
              PIE DEL MODAL
              ======================================-->

            <div class="modal-footer">
              <button id="closeAddVentas" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
              <button id="registrarSucursal" name="registrarSucursal" type="submit" class="btn btn-primary">Aceptar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <?php include('footer.php') ?>
  </div>


  <?php include('scripts.php'); ?>
  <script src="dist/js/pages/ventas.js"></script>

</body>