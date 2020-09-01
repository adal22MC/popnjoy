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

      <!-- TABLA SUCURSALES -->
      <div class="container-fluid pt-4">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <button id="agregarCategoria" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalCategorias">

                  Agregar Nueva Categoria

                </button>
                <a id="actualizarPaginaCategoria" class="btn btn-outline-primary" href="categorias.php">Actualizar</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tablaCategorias" class="table table-bordered table-striped tablaCategorias">
                  <thead>
                    <tr>
                      <th>ID Categoria</th>
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
      <!-- /. TABLA SUCURSALES -->
      </section>

      <!-- /.content -->
    </div>


  <!--=====================================
  MODAL AGREGAR CATEGORIAS
  ======================================-->

    <div id="modalCategorias" class="modal fade" role="dialog">

      <div class="modal-dialog">

        <div class="modal-content">

          <form id="formCategorias">

            <!--=====================================
                HEADER DEL MODAL
            ======================================-->

            <div class="modal-header">

              <h5 class="modal-title" id="modalTitulo">Nueva Categoria</h5>
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
                  <input id="descripcion" type="text" class="form-control" name="descripcion" placeholder="Descripción de la categoria" required>
                </div>

              </div>

            </div>

            <!--=====================================
            PIE DEL MODAL
            ======================================-->

            <div class="modal-footer">
              <button id="close" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
              <button id="btnFormCategoria" name="registrarCategoria" type="submit" class="btn btn-primary">Agregar Categorias</button>
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