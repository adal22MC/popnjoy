<?php

session_start();
if (!isset($_SESSION['usuario'])) {
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

      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-8 col-sm-12 pt-3">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Información de la Empresa</h3>
              </div>
              <!-- /.card-header -->

              <!-- form start -->
              <form id="formEditEmpresa" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="row">

                    <div class="col-lg-6 col-sm-12">
                      <!-- ENTRADA PARA EL NOMBRE DE LA EMPRESA -->
                      <div class="form-group">
                        <label for="exampleInputEmail1">Nombre de la Empresa</label>
                        <input name="nombre_empresa" type="text" class="form-control" id="nombre_empresa" placeholder="Nombre empresa" required>
                      </div>
                    </div>

                    <div class="col-lg-6 col-sm-12">
                      <!-- ENTRADA PARA EL TELEFONO DE LA EMPRESA -->
                      <div class="form-group">
                        <label for="exampleInputEmail1">Telefono</label>
                        <input name="telefono" type="text" class="form-control" id="telefono" placeholder="Telefono" required>
                      </div>
                    </div>

                  </div>

                  <div class="row">

                    <div class="col-lg-6 col-sm-12">
                      <!-- ENTRADA PARA EL CORREO DE LA EMPRESA -->
                      <div class="form-group">
                        <label for="exampleInputEmail1">Correo</label>
                        <input name="correo" type="email" class="form-control" id="correo" placeholder="Email" required>
                      </div>
                    </div>
                    

                    <div class="col-lg-6 col-sm-12">
                      <!-- ENTRADA PARA LA DIRECCION DE LA EMPRESA -->
                      <div class="form-group">
                        <label for="exampleInputEmail1">Dirección</label>
                        <input name="direccion" type="text" class="form-control" id="direccion" placeholder="Dirección" required>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-6 col-sm-12">
                      <!-- ENTRADA PARA LA PAGINA WEB DE LA EMPRESA -->
                      <div class="form-group">
                        <label for="exampleInputEmail1">Pagina web</label>
                        <input name="pagina_web" type="text" class="form-control" id="pagina_web" placeholder="Pagina web" required>
                      </div>
                    </div>
                  </div>
                  

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary float-right">Modificar</button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>

      <!-- /.content -->
    </div>


    <!--=====================================
    MODAL AGREGAR SUCURSAL
    ====================================== -->

    <div id="modalAgregarSucursal" class="modal fade" role="dialog">

      <div class="modal-dialog">

        <div class="modal-content">

          <form id="formSucursal" name="formSucursal">

            <!--=====================================
                  HEADER DEL MODAL
              ======================================-->

            <div class="modal-header">

              <h5 class="modal-title" id="exampleModalLabel">Nueva Sucursal</h5>
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
                      <i class="fa fa-hotel"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control" name="nombreSucursal" placeholder="Ingresar nombre de sucursal" required>
                </div>

                <!-- ENTRADA PARA EL UBICACION -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-map-marker-alt"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control" name="ubicacionSucursal" placeholder="Ingresar ubicación de sucursal" required>
                </div>

                <!-- ENTRADA PARA EL TELEFONO -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-phone"></i>
                    </span>
                  </div>
                  <input type="number" class="form-control" name="telefonoSucursal" placeholder="Ingresar telefono de la sucursal" required>
                </div>

                <!-- ENTRADA PARA EL CORREO -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-envelope"></i>
                    </span>
                  </div>
                  <input type="email" class="form-control" name="correoSucursal" placeholder="Ingresar correo de la sucursal" required>
                </div>



                <!-- ENTRADA PARA EL COMBO BOX 
                      <div class="input-group pt-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text">
                                  <i class="fa fa-user"></i>
                              </span>    
                          </div> 
                          <select class="form-control input-lg" name="tipoCliente" required>
                              <option value="">Seleccione tipo de cliente</option>
                              <option value="Distribuidor">Distribuidor</option>
                              <option value="Mayorista">Mayorista</option>
                              <option value="Empresa">Empresa</option>
                              <option value="General">General</option>
                          </select>
                      </div>
                      -->

              </div>

            </div>

            <!--=====================================
              PIE DEL MODAL
              ======================================-->

            <div class="modal-footer">
              <button id="close" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
              <button id="registrarSucursal" name="registrarSucursal" type="submit" class="btn btn-primary">Agregar sucursal</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!--=====================================
    MODAL EDITAR SUCURSAL
    ======================================-->

    <div id="modalEditarSucursal" class="modal fade" role="dialog">

      <div class="modal-dialog">

        <div class="modal-content">

          <form id="formEditSucursal">

            <!--=====================================
              HEADER DEL MODAL
              ======================================-->

            <div class="modal-header">

              <h5 class="modal-title">Editar Sucursal</h5>
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
                      <i class="fa fa-hotel"></i>
                    </span>
                  </div>

                  <input id="editnombreSucursal" type="text" class="form-control" name="editnombreSucursal" placeholder="Ingresar nombre de sucursal" required>
                </div>

                <!-- ENTRADA PARA EL UBICACION -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-map-marker-alt"></i>
                    </span>
                  </div>
                  <input id="editubicacionSucursal" type="text" class="form-control" name="editubicacionSucursal" placeholder="Ingresar ubicación de sucursal" required>
                </div>

                <!-- ENTRADA PARA EL TELEFONO -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-phone"></i>
                    </span>
                  </div>
                  <input id="edittelefonoSucursal" type="number" class="form-control" name="edittelefonoSucursal" placeholder="Ingresar telefono de la sucursal" required>
                </div>

                <!-- ENTRADA PARA EL CORREO -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-envelope"></i>
                    </span>
                  </div>
                  <input id="editcorreoSucursal" type="email" class="form-control" name="editcorreoSucursal" placeholder="Ingresar correo de la sucursal" required>
                </div>



                <!-- ENTRADA PARA EL COMBO BOX 
                <div class="input-group pt-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-user"></i>
                        </span>    
                    </div> 
                    <select class="form-control input-lg" name="tipoCliente" required>
                        <option value="">Seleccione tipo de cliente</option>
                        <option value="Distribuidor">Distribuidor</option>
                        <option value="Mayorista">Mayorista</option>
                        <option value="Empresa">Empresa</option>
                        <option value="General">General</option>
                    </select>
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
  <!-- Sucursal -->
  <script src="dist/js/pages/sucursal.js"></script>
</body>


</html>