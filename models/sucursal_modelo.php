<?php

    include 'conexion.php';

    class ModeloSucursal{

        private static $INSERT_SUCURSAL = "INSERT INTO sucursal (nombre,ubicacion,telefono,email)
        values (?,?,?,?)";

        private static $DELETE_SUCURSAL = "DELETE FROM sucursal WHERE id_sucursal = ?";

        private static $EDIT_SUCURSAL = "UPDATE sucursal set nombre=?, ubicacion=?, 
        telefono=?, email=? WHERE id_sucursal = ?";

        private static $SELECT_ALL_SUCURSALES = "SELECT * FROM sucursal";

        public static function guardarSucursal($nombre,$ubicacion,$telefono,$correo){

            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare(self::$INSERT_SUCURSAL);

                $pst->execute(array($nombre,$ubicacion,$telefono,$correo));

                $conexion->closeConexion();
                $con = null;

                return "ok";
            }catch(PDOException $e) {
                return $e->getMessage();
            }

        }

        public static function getUltimaSucursal(){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare("SELECT * FROM `sucursal`");

                $pst->execute();

                $sucursal = $pst->fetchAll();
       
                $conexion->closeConexion();
                $conn = null;

                return $sucursal;

            }catch(PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function llenarTablaSucursales(){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare(self::$SELECT_ALL_SUCURSALES);

                $pst->execute();
                $sucursales = $pst->fetchAll();

                foreach($sucursales as $row){
                    echo '
                        <tr>
                            <td>'.$row['id_sucursal'].'</td>
                            <td>'.$row['nombre'].'</td>
                            <td>'.$row['ubicacion'].'</td>
                            <td>'.$row['telefono'].'</td>
                            <td>'.$row['email'].'</td>
                            <td class="text-center py-0  align-middle">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-info btnEditar" data-toggle="modal" data-target="#modalEditarSucursal" id="'.$row['id_sucursal'].'">
                                        <i class="fas fa-edit" id="'.$row['id_sucursal'].'"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    ';
                }

                $conexion->closeConexion();
                $conn = null;

            }catch(PDOException $e) {
                echo $e->getMessage();
            }
        }

        public static function getSucursalId($id){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare("SELECT * FROM sucursal where id_sucursal = $id");

                $pst->execute();
                $sucursal = $pst->fetch();
       
                $conexion->closeConexion();
                $con = null;

                return $sucursal;

            }catch(PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function editSucursal($id,$nombre,$ubicacion,$tel,$email){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare(self::$EDIT_SUCURSAL);

                $pst->execute(array($nombre,$ubicacion,$tel,$email,$id));

                $conexion->closeConexion();
                $conn = null;

                return "ok";
            }catch(PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function eliminarSucursal($id){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare(self::$DELETE_SUCURSAL);

                $pst->execute(array($id));

                $conexion->closeConexion();
                $conn = null;

                return "ok";
            }catch(PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function llenarEncabezadoPDF(){
            $s = self::getSucursalId(71);

            // <h5><b>'. $s['telefono'] .'</b></h5>
            echo '
                <h1> <b>'. $s['nombre'] .'</b> </h1>
                <h2> <b>RUT.: 77.053.781-9 </b></h2>
                <h3> <b>PRODUCCIÓN ELABORACIÓN FACCIÓN POR TERCEROS Y ENVASADO DE TODA CLASE DE ALIMENTOS EN ESPECIAL PALOMITAS DE MAIZ</b></h3>
                <h3>'. $s['ubicacion'] .'</h3>
                <h3><b>'. $s['email'] .'</b></h3>
            ';
        }

        public static function llenarDetalleVenta($idventa){
            try{    

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                // Seleccionamos el detalle de esa venta en la tabla ventas
                $datosVenta = $con->prepare("SELECT * from ventas WHERE idVenta = ?");
                $datosVenta->execute([$idventa]);

                $venta = $datosVenta->fetch();

                $sucu = self::getSucursalId(71);

                

                echo '
                    <h5>'.$venta['idVenta'].'</h5>
                    <h5>'.$sucu['nombre'].'</h5>
                    <h5>'.$venta['cliente'].'</h5>
                    <h5>'.$venta['fecha'].'</h5>
                ';

                $conexion->closeConexion();
                $con = null;

            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        public static function llenarTablaVentaPDF($idventa){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                // Seleccionamos el detalle de esa venta en la tabla ventas
                $datosVenta = $con->prepare("SELECT * FROM ventas WHERE idVenta = ?");
                $datosVenta->execute([$idventa]);

                $venta = $datosVenta->fetch();

                $detalles = $con->prepare("SELECT * FROM detalle_venta WHERE idVenta = ? order by cns");

                $detalles->execute([$idventa]);
                $detallesVenta = $detalles->fetchAll();


                foreach($detallesVenta as $item){
                    echo '
                    <tr>
                        <td><b>'.$item['codigo'].'</b></td>
                        <td><b>'.$item['nomProducto'].'</b></td>
                        <td><b>'.$item['categoria'].'</b></td>
                        <td><b>'.$item['precioU'].'</b></td>
                        <td><b>'.$item['cantidad'].'</b></td>
                        <td><b>$ '.$item['total'].'</b></td>
                    </tr>
                    ';
                }


            }catch(PDOException $e){
                print_r($e->getMessage());
            }
        }

        public static function pintarTotalVentaPDF($idventa){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                // Seleccionamos el detalle de esa venta en la tabla ventas
                $datosVenta = $con->prepare("SELECT * FROM ventas WHERE idVenta = ?");
                $datosVenta->execute([$idventa]);

                $venta = $datosVenta->fetch();

                echo '<h4><b>TOTAL DE LA VENTA $'.$venta['totalVendido'].'</b></h4>';

            }catch(PDOException $e){
                print_r($e->getMessage());
            }
        }

    }


    
    