<?php

    require_once ('conexion.php');

    class Producto_model {

        private static $SELECT = "SELECT id_producto,nombre,categoria,stock,stock_min,stock_max,precio_venta,observaciones,status,c.descripcion FROM productos, categorias c WHERE status = 1 and c.id_categoria = categoria";

        private static $INSERT = "INSERT INTO productos (nombre,categoria,stock,stock_min,
        stock_max,precio_venta,observaciones,status) values(?,?,?,?,?,?,?,1)";

        private static $UPDATE = "UPDATE productos set nombre=?,categoria=?,stock=?,stock_min=?,stock_max=?,precio_venta=?,observaciones=? WHERE id_producto=?";

        private static $DELETE = "UPDATE productos set status = 0 WHERE id_producto = ?";

        public static function select(){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $query = $con->prepare(self::$SELECT);
                $query->execute();
                $productos = $query->fetchAll();

                $conexion->closeConexion();
                $con = null;

                return $productos;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function insert($producto){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $query = $con->prepare(self::$INSERT);
                $query->execute([$producto['nombre'],$producto['categoria'],$producto['stock'],
                $producto['stock_min'],$producto['stock_max'],$producto['precio_venta'],
                $producto['observaciones']]);
                

                $conexion->closeConexion();
                $con = null;

                return "OK";
                
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function update($producto){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $query = $con->prepare(self::$UPDATE);
                $query->execute([$producto['nombre'],$producto['categoria'],$producto['stock'],
                $producto['stock_min'],$producto['stock_max'],$producto['precio_venta'],
                $producto['observaciones'],$producto['id']]);
                

                $conexion->closeConexion();
                $con = null;

                return "OK";
                
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function delete($id){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $query = $con->prepare(self::$DELETE);
                $query->execute([$id]);
                

                $conexion->closeConexion();
                $con = null;

                return "OK";
                
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

    }
