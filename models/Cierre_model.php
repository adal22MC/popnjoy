<?php

    require_once ('conexion.php');

    class Cierre_model {

        /* Verifica si el dia esta abierto o no, true si esta abierto */
        public static function verificar_dia_cerrado(){
            try{
                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare("SELECT * FROM cierre_dia WHERE fecha = CURRENT_DATE");
                $pst->execute();
                $datos = $pst->fetch();

                if($datos){
                    // SI el cierre ya esta creado, verificamos el estado
                    if($datos['estado'] == 1){
                        return 'abierto';
                    }else{
                        return 'cerrado';
                    }
                }

                return 'no creado';

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function open_day(){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $query = $con->prepare("INSERT INTO cierre_dia (total_ventido,total_costo,ganancia,estado) VALUES (0,0,0,1)");
                $query->execute();

                return "OK";

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function close_day(){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $cierre = self::getCierreActual();

                $query = $con->prepare("UPDATE cierre_dia set estado = 0 WHERE id_cd = ?");
                $query->execute([$cierre['id_cd']]);

                return "OK";

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function getCierreActual(){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                // Obtenemos el id del cierrte actual
                $query = $con->prepare("SELECT * FROM cierre_dia WHERE fecha = CURRENT_DATE");
                $query->execute();
                $cierre = $query->fetch();

                $conexion->closeConexion();
                $con = null;

                return $cierre;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function select(){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $cierre = self::getCierreActual();

                $query = $con->prepare("SELECT * FROM cierre_dia WHERE estado = 0");
                $query->execute();

                $cierres = $query->fetchAll();

                return $cierres;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

    }