<?php
  session_start();
  if(isset($_SESSION['usuario'])){}else{
    header('Location: index.php');
  }
  include("models/cliente_modelo.php");
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <?php include('cabezera.php'); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <?php include('navegacion.php') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- TABLA CLIENTES -->
      <div class="container-fluid pt-4">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#modalAgregarCliente">

                  Agregar un nuevo cliente

                </button>
                <a id="actualizarPaginaCliente" class="btn btn-outline-primary" href="clientes.php">Actualizar</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped tablaClientes">
                  <thead>
                    <tr>
                      <th>ID Cliente</th>
                      <th>Nombre</th>
                      <th>Tipo Cliente</th>
                      <th>Email</th>
                      <th>Telefono</th>
                      <th>Dirección</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>

                  <tbody id="sucursalesBody">
                    <?php
                        ModeloCliente::llenarTablaClientes();
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
      <!-- /. TABLA SUCURSALES -->
      </section>

      <!-- /.content -->
    </div>


  <!--=====================================
  MODAL AGREGAR CLIENTE
  ======================================-->

    <div id="modalAgregarCliente" class="modal fade" role="dialog">

      <div class="modal-dialog">

        <div class="modal-content">

          <form id="formAddCliente">

            <!--=====================================
                HEADER DEL MODAL
            ======================================-->

            <div class="modal-header">

              <h5 class="modal-title" id="exampleModalLabel">Nuevo Cliente</h5>
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
                      <i class="fas fa-user"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control" name="nombreCliente" placeholder="Ingresar nombre del Cliente" required>
                </div>

                <!-- ENTRADA PARA EL TIPO DE CLIENTE -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-users-cog"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control" name="tipoCliente" placeholder="Ingresar el tipo de cliente" required>
                </div>

                
                <!-- ENTRADA PARA EL CORREO -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-envelope"></i>
                    </span>
                  </div>
                  <input type="email" class="form-control" name="correoCliente" placeholder="Ingresar correo del cliente" required>
                </div>

                <!-- ENTRADA PARA EL TELEFONO -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-phone"></i>
                    </span>
                  </div>
                  <input type="number" class="form-control" name="telefonoCliente" placeholder="Ingresar telefono del cliente" required>
                </div>

                <!-- ENTRADA PARA LA DIRECCION -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-route"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control" name="direccionCliente" placeholder="Ingresar dirección del cliente" required>
                </div>

                <!-- ENTRADA PARA EL PORCENTAJE 
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-percentage"></i>
                    </span>
                  </div>
                  <input type="number" class="form-control" name="porcentajeCliente" placeholder="Ingresar porcentaje de descuento" required>
                </div>
                -->
              </div>

            </div>

            <!--=====================================
            PIE DEL MODAL
            ======================================-->

            <div class="modal-footer">
              <button id="close" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
              <button id="registrarSucursal" name="registrarSucursal" type="submit" class="btn btn-primary">Agregar Cliente</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  <!--=====================================
  MODAL EDITAR CLIENTE
  ======================================-->

    <div id="modalEditarCliente" class="modal fade" role="dialog">

      <div class="modal-dialog">

        <div class="modal-content">

          <form id="formEditCliente">

            <!--=====================================
             HEADER DEL MODAL
            ======================================-->

            <div class="modal-header">

              <h5 class="modal-title">Editar Cliente</h5>
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
                      <i class="fas fa-user"></i>
                    </span>
                  </div>
                  <input id="nombreCliente" type="text" class="form-control" name="nombreCliente" placeholder="Ingresar nombre del Cliente" required>
                </div>

                <!-- ENTRADA PARA EL TIPO DE CLIENTE -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-users-cog"></i>
                    </span>
                  </div>
                  <input id="tipoCliente" type="text" class="form-control" name="tipoCliente" placeholder="Ingresar el tipo de cliente" required>
                </div>

                
                <!-- ENTRADA PARA EL CORREO -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-envelope"></i>
                    </span>
                  </div>
                  <input id="correoCliente" type="email" class="form-control" name="correoCliente" placeholder="Ingresar correo del cliente" required>
                </div>

                <!-- ENTRADA PARA EL TELEFONO -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-phone"></i>
                    </span>
                  </div>
                  <input id="telefonoCliente" type="number" class="form-control" name="telefonoCliente" placeholder="Ingresar telefono del cliente" required>
                </div>

                <!-- ENTRADA PARA LA DIRECCION -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-route"></i>
                    </span>
                  </div>
                  <input id="direccionCliente" type="text" class="form-control" name="direccionCliente" placeholder="Ingresar dirección del cliente" required>
                </div>

                <!-- ENTRADA PARA EL PORCENTAJE -
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-percentage"></i>
                    </span>
                  </div>
                  <input id="porcentajeCliente" type="number" class="form-control" name="porcentajeCliente" placeholder="Ingresar porcentaje de descuento" required>
                </div>
                -->
              </div>

            </div>

            <!--=====================================
              PIE DEL MODAL
              ======================================-->

            <div class="modal-footer">
              <button id="closeEdit" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
              <button id="editarSucursal" type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
          </form>
        </div>
      </div>
    </div>


    <?php include("footer.php") ?>

  </div>
  <!-- ./wrapper -->

  <?php include('scripts.php'); ?>
  <script src="dist/js/pages/clientes.js"></script>
</body>


</html>