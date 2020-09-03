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

      <!-- TABLA PRODUCTOS -->
      <div class="container-fluid pt-4">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <button id="btnAgregarProducto" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalProductos">

                  Agregar un nuevo producto

                </button>
                <a id="actualizarPaginaProductos" class="btn btn-outline-primary" href="productos.php">Actualizar</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tablaProductos" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>ID Producto</th>
                      <th>Producto</th>
                      <th>id_categoria</th>
                      <th>Stock</th>
                      <th>Stock Min</th>
                      <th>Stock Max</th>
                      <th>Precio de Venta</th>
                      <th>Obsevaciones</th>
                      <th>Status</th>
                      <th>Categoria</th>
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
      </section>

      <!-- /.content -->
    </div>


  <!--=====================================
  MODAL AGREGAR PRODUCTO
  ======================================-->

  <div id="modalProductos" class="modal fade" role="dialog">

    <div class="modal-dialog">

      <div class="modal-content">

        <form id="formProducto">

          <!--=====================================
              HEADER DEL MODAL
          ======================================-->

          <div class="modal-header">
            <h5 class="modal-title" id="tituloModal">Nuevo Producto</h5>
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
                    <i class="fab fa-product-hunt"></i>
                  </span>
                </div>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del producto" required>
              </div>

              <!-- ENTRADA PARA EL TIPO DE CATEGORIA -->
              <div class="input-group pt-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fab fa-cuttlefish"></i>
                  </span>
                </div>
                <select class="form-control" name="categoria" id="selectCategoria">
                  <option value="default">Seleccione una categoria</option>
                </select>
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

              <!-- ENTRADA PARA EL PRECIO DE VENTA -->
              <div class="input-group pt-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-dollar-sign"></i>
                  </span>
                </div>
                <input type="number" class="form-control" id="precio_venta" name="precio_venta" placeholder="Precio de venta" required>
              </div>

              <!-- ENTRADA PARA LAS OBSERVACIONES  -->
              <div class="input-group pt-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-comment-dots"></i>
                  </span>
                </div>
                <textarea placeholder="Observaciones" required id="observaciones" name="observaciones" cols="50" rows="3">Sin observaciones</textarea>
              </div>

            </div>

          </div>

          <!--=====================================
          PIE DEL MODAL
          ======================================-->

          <div class="modal-footer">
            <button id="closeInsertProduct" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
            <button id="btnFormProducto" name="registrarSucursal" type="submit" class="btn btn-primary">Agregar Producto</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!--=====================================
    MODAL AGREGAR STOCK
    ======================================-->

    <div id="modalStock" class="modal fade" role="dialog">

        <div class="modal-dialog">

            <div class="modal-content">

                <form id="formStock">

                    <!--=====================================
                        HEADER DEL MODAL
                    ======================================-->

                    <div class="modal-header">
                        <h5 class="modal-title" id="tituloModalStock">Aumentando Stock</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!--=====================================
                    CUERPO DEL MODAL
                    ======================================-->

                    <div class="modal-body">

                        <div class="box-body">

                            <!-- ENTRADA PARA LA CANTIDAD -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-cubes"></i>
                                    </span>
                                </div>
                                <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Cantidad" required>
                            </div>

                            <!-- ENTRADA PARA EL PRECIO DE COMPRA -->
                            <div id="entrada_precio_compra" class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-dollar-sign"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="precio_compra" name="precio_compra" placeholder="Precio de compra" required>
                            </div>

                            <!-- ENTRADA PARA LA RAZON DEL DESCUENTO DE STOCK -->
                            <div id="entrada_razon_descuento" class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-dollar-sign"></i>
                                    </span>
                                </div>
                                <textarea class="form-control" name="razon" id="razon" cols="30" rows="3" placeholder="Razón del descuento" required></textarea>
                            </div>

                        </div>

                    </div>

                    <!--=====================================
                    PIE DEL MODAL
                    ======================================-->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                        <button id="btnFormStock" type="submit" class="btn btn-primary">
                            Sumar al Stock
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

  <!-- ./wrapper -->

  <?php include('scripts.php'); ?>
  <script src="dist/js/pages/productos.js"></script>
  
</body>


</html>