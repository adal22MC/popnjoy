<?php

    require_once ('conexion.php');

    class Insumo_model {

        private static $SELECT = "SELECT * FROM insumos WHERE status = 1";

        private static $INSERT = "INSERT INTO insumos (nombre,stock,stock_min,
        stock_max,um,status) values(?,?,?,?,?,1)";

        private static $UPDATE = "UPDATE insumos set nombre=?,stock=?,stock_min=?,stock_max=?,um=? WHERE id_insumo = ?";

        private static $DELETE = "UPDATE insumos set status = 0 WHERE id_insumo = ?";

        public static function select(){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $query = $con->prepare(self::$SELECT);
                $query->execute();
                $insumos = $query->fetchAll();

                $conexion->closeConexion();
                $con = null;

                return $insumos;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function insert($insumo){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $query = $con->prepare(self::$INSERT);
                $query->execute([$insumo['nombre'],$insumo['stock'],
                $insumo['stock_min'],$insumo['stock_max'],$insumo['um']]);
                

                $conexion->closeConexion();
                $con = null;

                return "OK";
                
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function update($insumo){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $query = $con->prepare(self::$UPDATE);
                $query->execute([$insumo['nombre'],$insumo['stock'],
                $insumo['stock_min'],$insumo['stock_max'],$insumo['um'],$insumo['id']]);
                

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

        public static function validarDelete($id){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $query = $con->prepare("SELECT * FROM producto_insumos WHERE insumo = ?");
                $query->execute([$id]);
                
                $datos = $query->fetchAll();

                $conexion->closeConexion();
                $con = null;

                if(count($datos) == 0){
                    return true;
                }

                return false;
                
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

    }
