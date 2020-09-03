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
    }