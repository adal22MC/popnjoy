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

    <?php include('navegacion.php') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- TABLA PRODUCTOS -->
      <div class="container-fluid pt-4">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#modalAgregarProductos">

                  Agregar un nuevo producto

                </button>
                <a id="actualizarPaginaProductos" class="btn btn-outline-primary" href="productos.php">Actualizar</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped tablaProductos">
                  <thead>
                    <tr>
                      <th>ID Producto</th>
                      <th>Nombre</th>
                      <th>Categoria</th>
                      <th>Stock</th>
                      <th>Precio de Compra</th>
                      <th>Precio de Venta</th>
                      <th>Obsevaciones</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>

                  <tbody id="sucursalesBody">
                    <?php
                        ModeloProducto::llenarTablaProductos();
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
      </section>

      <!-- /.content -->
    </div>


  <!--=====================================
  MODAL AGREGAR PRODUCTO
  ======================================-->

  <div id="modalAgregarProductos" class="modal fade" role="dialog">

    <div class="modal-dialog">

      <div class="modal-content">

        <form id="formAddProduct">

          <!--=====================================
              HEADER DEL MODAL
          ======================================-->

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Producto</h5>
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
                <input type="text" class="form-control" name="nombreProducto" placeholder="Ingresar nombre del producto" required>
              </div>

              <!-- ENTRADA PARA EL TIPO DE CATEGORIA -->
              <div class="input-group pt-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fab fa-cuttlefish"></i>
                  </span>
                </div>
                <select class="form-control" name="categoria" id="selectCategoria">
                  <option value="Seleccione una categoria" id="categoriaDefault">Seleccione una categoria</option>
                  <?php
                      ModeloProducto::llenarSelectCategorias();
                  ?>
                </select>
              </div>

              <!-- ENTRADA PARA EL STOCK -->
              <div class="input-group pt-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-battery-three-quarters"></i>
                  </span>
                </div>
                <input type="number" class="form-control" name="stockProducto" placeholder="Ingresar cantidad inicial de Stock" required>
              </div>

              
              <!-- ENTRADA PARA EL STOCK MINIMO -->
              <div class="input-group pt-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-battery-quarter"></i>
                  </span>
                </div>
                <input type="number" class="form-control" name="stockMinimo" placeholder="Ingresar stock minimo" required>
              </div>

              <!-- ENTRADA PARA EL STOCK MAXIMO -->
              <div class="input-group pt-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-battery-full"></i>
                  </span>
                </div>
                <input type="number" class="form-control" name="stockMaximo" placeholder="Ingresar stock maximo" required>
              </div>

              <!-- ENTRADA PARA EL PRECIO DE VENTA -->
              <div class="input-group pt-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-dollar-sign"></i>
                  </span>
                </div>
                <input type="number" class="form-control" name="precioVenta" placeholder="Ingresar el precio de venta" required>
              </div>

              <!-- ENTRADA PARA EL PRECIO DE COMPRA  -->
              <div class="input-group pt-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-dollar-sign"></i>
                  </span>
                </div>
                <input type="number" class="form-control" name="precioCompra" placeholder="Ingresar el precio de compra" required>
              </div>

              <!-- ENTRADA PARA LAS OBSERVACIONES  -->
              <div class="input-group pt-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-comment-dots"></i>
                  </span>
                </div>
                <textarea placeholder="Observaciones" required name="observaciones" cols="50" rows="6"></textarea>
              </div>

            </div>

          </div>

          <!--=====================================
          PIE DEL MODAL
          ======================================-->

          <div class="modal-footer">
            <button id="closeInsertProduct" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
            <button id="registrarSucursal" name="registrarSucursal" type="submit" class="btn btn-primary">Agregar Producto</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!--=====================================
  MODAL EDITAR PRODUCTO
  ======================================-->

  <div id="modalEditarCliente" class="modal fade" role="dialog">

      <div class="modal-dialog">

        <div class="modal-content">

          <form id="formEditPrduct">

            <!--=====================================
                HEADER DEL MODAL
            ======================================-->

            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Editar Producto</h5>
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
                  <input type="text" class="form-control" id="nombreProducto" name="nombreProducto" placeholder="Ingresar nombre del producto" required>
                  <small class="form-text text-muted btn-block">Nombre del producto</small>
                </div>

                <!-- ENTRADA PARA EL TIPO DE CATEGORIA -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fab fa-cuttlefish"></i>
                    </span>
                  </div>
                  <select class="form-control" name="idcategoria" id="idselectCategoria">
                    <option value="Seleccione una categoria" id="categoriaDefault">Seleccione una categoria</option>
                    <?php
                        ModeloProducto::llenarSelectCategorias();
                    ?>
                  </select>
                  <small class="form-text text-muted btn-block">Categoria a la que pertenece</small>
                </div>

                <!-- ENTRADA PARA EL STOCK -->
                  <div class="input-group pt-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fas fa-battery-three-quarters"></i>
                      </span>
                    </div>
                    <input type="number" class="form-control" id="stockProducto" name="stockProducto" placeholder="Ingresar cantidad inicial de Stock" required>
                    <small class="form-text text-muted btn-block">Stock disponible</small>
                  </div>

                
                <!-- ENTRADA PARA EL STOCK MINIMO -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-battery-quarter"></i>
                    </span>
                  </div>
                  <input type="number" class="form-control" id="stockMinimo" name="stockMinimo" placeholder="Ingresar stock minimo" required>
                  <small class="form-text text-muted btn-block">Stock minimo</small>
                </div>

                <!-- ENTRADA PARA EL STOCK MAXIMO -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-battery-full"></i>
                    </span>
                  </div>
                  <input type="number" class="form-control" id="stockMaximo" name="stockMaximo" placeholder="Ingresar stock maximo" required>
                  <small class="form-text text-muted btn-block">Stock maximo</small>
                </div>

                <!-- ENTRADA PARA EL PRECIO DE VENTA -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-dollar-sign"></i>
                    </span>
                  </div>
                  <input type="number" class="form-control" id="precioVenta" name="precioVenta" placeholder="Ingresar el precio de venta" required>
                  <small class="form-text text-muted btn-block">Precio de venta</small>
                </div>

                <!-- ENTRADA PARA EL PRECIO DE COMPRA  -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-dollar-sign"></i>
                    </span>
                  </div>
                  <input type="number" class="form-control" id="precioCompra" name="precioCompra" placeholder="Ingresar el precio de compra" required>
                  <small class="form-text text-muted btn-block">Precio de compra</small>
                </div>

                <!-- ENTRADA PARA LAS OBSERVACIONES  -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-comment-dots"></i>
                    </span>
                  </div>
                  <textarea placeholder="Observaciones" id="observaciones" required name="observaciones" cols="50" rows="6"></textarea>
                  <small class="form-text text-muted btn-block">Observaciones</small>
                </div>

              </div>

            </div>

            <!--=====================================
            PIE DEL MODAL
            ======================================-->

            <div class="modal-footer">
              <button id="closeEditProduct" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
              <button id="editarProduct" name="registrarSucursal" type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
          </form>
        </div>
      </div>
    </div>


    <?php include("footer.php") ?>

  </div>
  <!-- ./wrapper -->

  <?php include('scripts.php'); ?>
  <script src="dist/js/pages/productos.js"></script>
  
</body>


</html>