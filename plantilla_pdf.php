<?php

session_start();
if (isset($_SESSION['usuario'])) {
} else {
    header('Location: index.php');
}

include('models/sucursal_modelo.php');

if (isset($_GET['idVenta'])) {
} else {
    header('Location: admin.php');
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('cabezera.php'); ?>
    <link rel="stylesheet" href="dist/css/img.css">
</head>

<body>

    <!-- Content Wrapper. Contains page content -->
    <div class="container">
        <div class="row">
            <div class="col-md-3 pt-4 mt-3 ">
                <div class="d-flex align-items-center flex-column">
                    <img src="dist/img/logo.jpeg" alt="logotipo">
                </div>
            </div>
            <div class="col-md-9 pt-4 mt-3">
                <?php
                ModeloSucursal::llenarEncabezadoPDF();
                ?>
            </div>
        </div>
        <h2>______________________________________________________________________</h2>
        <div class="row">
            <div class="col-sm-12">
                <h2 class="text-center"><b>Comprobante electronico</b></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <h5><b>Id venta :</b></h5>
                <h5><b>Sucursal :</b></h5>
                <h5><b>Cliente  :</b></h5>
                <h5><b>Fecha    :</b></h5>
            </div>
            <div class="col-md-9">
                <?php
                ModeloSucursal::llenarDetalleVenta($_GET['idVenta']);
                ?>
            </div>
        </div>
        <h2>______________________________________________________________________</h2>
                <!-- TABLA SUCURSALES -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <a id="actualizarPaginaSucursal" class="btn btn-outline-primary" href="sucursal.php">Productos que se vendieron</a>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped tablaSucursal">
                                        <thead>
                                            <tr>
                                                <th>CODIGO</th>
                                                <th>NOMBRE</th>
                                                <th>CATEGORIA</th>
                                                <th>PRECIO U</th>
                                                <th>CANTIDAD</th>
                                                <th>TOTAL</th>
                                            </tr>
                                        </thead>

                                        <tbody id="sucursalesBody">
                                            <?php
                                                ModeloSucursal::llenarTablaVentaPDF($_GET['idVenta']);
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
                
                <!-- /. TABLA SUCURSALES -->
        
        <h2>______________________________________________________________________</h2>
        <div class="row">
            <div class="col-md-12">
                <?php ModeloSucursal::pintarTotalVentaPDF($_GET['idVenta']); ?>
            </div>
        </div>
    </div>
    <!-- /.content -->

    <script>
      window.addEventListener("load", window.print());
    </script>

</body>

</html>