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

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- TABLA CLIENTES -->
      <div class="container-fluid pt-4">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <button id="btnAgregarCliente" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalCliente">

                  Agregar un nuevo cliente

                </button>
                <a id="actualizarPaginaCliente" class="btn btn-outline-primary" href="clientes.php">Actualizar</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tablaClientes" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nombre</th>
                      <th>Tipo Cliente</th>
                      <th>Email</th>
                      <th>Telefono</th>
                      <th>Dirección</th>
                      <th>Porcentaje</th>
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
      <!-- /. TABLA SUCURSALES -->
      </section>

      <!-- /.content -->
    </div>


  <!--=====================================
  MODAL AGREGAR CLIENTE
  ======================================-->

    <div id="modalCliente" class="modal fade" role="dialog">

      <div class="modal-dialog">

        <div class="modal-content">

          <form id="formCliente">

            <!--=====================================
                HEADER DEL MODAL
            ======================================-->

            <div class="modal-header">

              <h5 class="modal-title" id="tituloModal">Nuevo Cliente</h5>
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
                  <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
                </div>

                <!-- ENTRADA PARA EL TIPO DE CLIENTE -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-users-cog"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control" id="tipo_cliente" name="tipo_cliente" placeholder="Tipo" required>
                </div>

                
                <!-- ENTRADA PARA EL CORREO -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-envelope"></i>
                    </span>
                  </div>
                  <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo" required>
                </div>

                <!-- ENTRADA PARA EL TELEFONO -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-phone"></i>
                    </span>
                  </div>
                  <input type="number" class="form-control" id="telefono"  name="telefono" placeholder="Telefono" required>
                </div>

                <!-- ENTRADA PARA LA DIRECCION -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-route"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección" required>
                </div>

              </div>

            </div>

            <!--=====================================
            PIE DEL MODAL
            ======================================-->

            <div class="modal-footer">
              <button id="close" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
              <button id="btnFormCliente" name="registrarSucursal" type="submit" class="btn btn-primary">Agregar Cliente</button>
            </div>
          </form>
        </div>
      </div>
    </div>


  <?php include('scripts.php'); ?>
  <script src="dist/js/pages/clientes.js"></script>
</body>


</html>