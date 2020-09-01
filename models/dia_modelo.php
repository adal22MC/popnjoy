<?php

    require_once ('conexion.php');

    class Dia{

        public function cerrarDia(){
            $ban = $this->verificiarDia();

            if($ban){
                // Cerramos el dia
                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare("SELECT * FROM ventas WHERE fecha = CURRENT_DATE");
                $pst->execute();
                $ventas = $pst->fetchAll();

                if($ventas){
                    
                    // Calculamos el total de venta en el dia
                    $calculoTotalVentaDia = $con->prepare("SELECT SUM(totalVendido) AS total FROM ventas WHERE fecha = CURRENT_DATE");
                    $calculoTotalVentaDia->execute();
                    $total = $calculoTotalVentaDia->fetch();

                    // Insertamos el cierre del dia con su total de venta
                    $insert_cierre = $con->prepare("INSERT INTO cierres (tv_dia) values (?)");
                    $insert_cierre->execute([$total['total']]);

                    // Obtenemos el ID del cierre de dia insertado anteriormente
                    $id_cierre = $con->prepare("SELECT MAX(id_c) AS id FROM cierres");
                    $id_cierre->execute();
                    $idCierre = $id_cierre->fetch();

                    foreach($ventas as $venta){
                        $insert_detalle_cierre = $con->prepare("INSERT INTO detalle_cierre (id_c, id_venta) VALUES (?, ?)");

                        $insert_detalle_cierre->execute([$idCierre['id'], $venta["idVenta"]]);

                    }
                    
                }else{
                    
                    $insert_cierre = $con->prepare("INSERT INTO cierres (tv_dia) values (?)");

                    $insert_cierre->execute(["0"]);
                    
                }

                return "OK";

            }

            return "EL DIA YA FUE CERRADO";
        }

        /* Verifica si el dia esta cerrado o no, si esta cerrado retorna false */
        public function verificiarDia(){
            try{
                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare("SELECT * FROM cierres WHERE fecha_c = CURRENT_DATE");
                $pst->execute();
                $datos = $pst->fetch();

                if($datos){
                    return false;
                }

                return true;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public function llenarTablaCierres(){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare("SELECT * FROM cierres");
                $pst->execute();

                $cierres = $pst->fetchAll();

                foreach($cierres as $cierre){
                    echo '
                        <tr>
                            <td>'.$cierre['id_c'].'</td>
                            <td>'.$cierre['fecha_c'].'</td>
                            <td>'.$cierre['hora'].'</td>
                            <td>'.$cierre['tv_dia'].'</td>
                            <td>*</td>
                        </tr>
                    ';
                }

            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }