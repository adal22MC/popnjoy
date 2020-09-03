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

      <div class="content-wrapper">
        
          <section>
            <div class="container-fluid pt-4"> 
              <div class="row">

                <div class="col-md-6">

                    <!-- ENTRADA PARA EL PRODUCTO -->
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fab fa-product-hunt"></i>
                            </span>
                            </div>
                        <select class="form-control" name="selectProducto" id="selectProducto">
                            <option value="default">Seleccione un producto</option>
                        </select>
                    </div>
 
                    <!-- TABLE: PRODUCTOS -->
                    <div class="card">
                        <div class="card-header border-transparent">
                          <h3 id="totalApagar" class="card-title">Lista de insumos que ocupa el producto</h3>
                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                              <i class="fas fa-minus"></i>
                            </button>
                          </div>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body p-0">
                          <div class="table-responsive">
                            <table id="tablaProductosInsumos" class="table m-0">
                              <thead>
                                <tr>
                                  <th>Eliminar</th>
                                  <th>Insumo</th>
                                  <th>Cantidad</th>
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
                          <a href="producto_insumos.php" class="btn btn-sm btn-danger float-left">Cancelar todo</a>
                          <button id="guardarCambios" class="btn btn-sm btn-info float-right">Guardar</button>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>


                <div class="col-md-6">
                  <!-- TABLA INSUMOS -->
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-12">

                        <div class="card">
                          <div class="card-header">
                            <h2 class="card-title">Lista de todos los insumos</h2>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body">
                            <table id="tablaInsumos" class="table table-bordered table-striped tablaProductos">
                              <thead>
                                <tr>
                                  <th>Id_insumo</th>
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
                </div>
                
              </div>
            </div>
          </section>

      </div>
      <!-- ./ content-wrapper-->


      <?php include('footer.php') ?>
  </div>

 
  <?php include('scripts.php'); ?>
  <script src="dist/js/pages/producto_insumos.js"></script>

</body>