<?php

    require_once "conexion.php";

    class Migrar {

        public function migrarCierres(){
            // Cerramos el dia
            $conexion = new Conexion();
            $con = $conexion->getConexion();

            $pst = $con->prepare("SELECT * FROM ventas WHERE fecha = '2020/07/23'");
            $pst->execute();
            $ventas = $pst->fetchAll();

            if($ventas){
                
                // Calculamos el total de venta en el dia
                $calculoTotalVentaDia = $con->prepare("SELECT SUM(totalVendido) AS total FROM ventas WHERE fecha = '2020/07/23'");
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

            }
        }
    }

    $mi = new Migrar();
    $mi->migrarCierres();

