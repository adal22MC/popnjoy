<?php

    require_once "conexion.php";
    require_once "Producto_model.php";

    class Producto_Insumos_model {

        public static function selectInsumos($id_producto){
            try{

                $insumos = Producto_model::selectInsumos($id_producto);
                return $insumos;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function renovarInsumos($insumos){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                // Eliminamos todos los insumos que usa el producto
                $query = $con->prepare("DELETE FROM producto_insumos WHERE producto = ?");
                $query->execute([$insumos[0]['producto']]);

                for($i=1; $i<count($insumos); $i++){
                    $query = $con->prepare("INSERT INTO producto_insumos VALUES (?,?,?)");
                    $query->execute([$insumos[0]['producto'],$insumos[$i]['insumo'],$insumos[$i]['cantidad']]);
                }

                return "OK";

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }
    }