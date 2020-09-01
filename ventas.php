<?php

  session_start();
  if(isset($_SESSION['usuario'])){}else{
    header('Location: index.php');
  }

  //include("models/ventas_modelo.php");
  include("models/producto_modelo.php");
  //include("models/cliente_modelo.php");
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

                <div class="col-md-6">

                    <!-- TABLE: VENTAS -->
                    <div class="card">
                        <div class="card-header border-transparent">
                          <h3 id="totalApagar" class="card-title">Lista de productos a vender</h3>
                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                              <i class="fas fa-minus"></i>
                            </button>
                            <!--
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                              <i class="fas fa-times"></i>
                            </button>
                            -->
                          </div>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body p-0">
                          <div class="table-responsive">
                            <table class="table m-0 listProductVenta">
                              <thead>
                                <tr>
                                  <th>Eliminar</th>
                                  <th>Producto</th>
                                  <th>Cantidad</th>
                                  <th>Total</th>
                                </tr>
                              </thead>
                              <tbody id="bodyListProducts">
                                
                              </tbody>
                            </table>
                          </div>
                          <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer clearfix">
                          <a href="ventas.php" class="btn btn-sm btn-danger float-left">Cancelar todo</a>
                          <button id="procesarVenta" class="btn btn-sm btn-info float-right">Procesar venta</button>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>


                <div class="col-md-6">
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
                            <table id="example1" class="table table-bordered table-striped tablaProductos">
                              <thead>
                                <tr>
                                  <th>Acciones</th>
                                  <th>ID Producto</th>
                                  <th>Nombre</th>
                                  <th>Stock</th>
                                  <th>Precio de Venta</th>
                                </tr>
                              </thead>

                              <tbody>
                                <?php
                                    ModeloProducto::llenarTablaProductosVenta();
                                ?>
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



        <!--=====================================
      MODAL MOSTRAR TABLA HISTORIAL VENTAS
      ====================================== -->

      <div id="modalHistorialVentas" class="modal fade" role="dialog">

        <div class="modal-dialog">

          <div class="modal-content">

            <form id="formHistorialVentas">

              <!--=====================================
                  HEADER DEL MODAL
              ======================================-->

              <div class="modal-header">

                <h5 class="modal-title" id="exampleModalLabel">Historiales de las ventas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>

              </div>

              <!--=====================================
              CUERPO DEL MODAL
              ======================================-->

              <div class="modal-body">

                <div class="box-body">

                  <div class="row">
                    <!-- TABLA HISTORIAL VENTAS  -->
                    <div class="col-md-12">
                      <!-- TABLA PRODUCTOS -->
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-12">

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
                          <!-- /.col -->
                        </div>
                        <!-- /.row -->
                      </div>
                      <!-- /. TABLA PRODUCTOS -->
                    </div>
                  </div>

                </div>

              </div>

              <!--=====================================
              PIE DEL MODAL
              ======================================-->

              <div class="modal-footer">
                <button id="closeHistorialVentas" type="button" class="btn btn-default pull-left" data-dismiss="modal">SALIR</button>
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