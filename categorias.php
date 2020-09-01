<?php
  session_start();
  if(isset($_SESSION['usuario'])){}else{
    header('Location: index.php');
  }
  include("models/categoria_modelo.php");
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

      <!-- TABLA SUCURSALES -->
      <div class="container-fluid pt-4">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#modalAgregarCategorias">

                  Agregar Nueva Categoria

                </button>
                <a id="actualizarPaginaCategoria" class="btn btn-outline-primary" href="categorias.php">Actualizar</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped tablaCategorias">
                  <thead>
                    <tr>
                      <th>ID Categoria</th>
                      <th>Descripcion</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>

                  <tbody id="categoriasBody">
                    <?php
                      ModeloCategoria::llenasTablaCategorias();
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
  MODAL AGREGAR CATEGORIAS
  ======================================-->

    <div id="modalAgregarCategorias" class="modal fade" role="dialog">

      <div class="modal-dialog">

        <div class="modal-content">

          <form id="formCategorias">

            <!--=====================================
                HEADER DEL MODAL
            ======================================-->

            <div class="modal-header">

              <h5 class="modal-title" id="exampleModalLabel">Nueva Categoria</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>

            </div>

            <!--=====================================
            CUERPO DEL MODAL
            ======================================-->

            <div class="modal-body">

              <div class="box-body">

                <!-- ENTRADA PARA LA DESCRIPCION -->
                <div class="input-group pt-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fab fa-cuttlefish"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control" name="desCategorias" placeholder="Ingresar la descripción la categoria" required>
                </div>

              </div>

            </div>

            <!--=====================================
            PIE DEL MODAL
            ======================================-->

            <div class="modal-footer">
              <button id="close" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
              <button id="registrarCategorias" name="registrarCategoria" type="submit" class="btn btn-primary">Agregar Categorias</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  <!--=====================================
  MODAL EDITAR CATEGORIA
  ======================================-->

    <div id="modalEditarSucursal" class="modal fade" role="dialog">

      <div class="modal-dialog">

        <div class="modal-content">

          <form id="formEditCategoria">

            <!--=====================================
             HEADER DEL MODAL
            ======================================-->

            <div class="modal-header">

              <h5 class="modal-title">Editar Categoria</h5>
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
                      <i class="fab fa-cuttlefish"></i>
                    </span>
                  </div>

                  <input id="editDesCateogoria" type="text" class="form-control" name="editDesCategoria" placeholder="Ingresar nombre de sucursal" required>
                </div>

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
  <script src="dist/js/pages/categorias.js"></script>

</body>


</html>