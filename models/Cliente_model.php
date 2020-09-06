<?php

    require_once ('conexion.php');

    class Cliente_model {

        private static $SELECT = "SELECT * FROM clientes where status = 1";

        private static $INSERT = "INSERT INTO clientes (nombre,tipo,email,telefono,direccion,porcentaje) VALUES (?,?,?,?,?,?)";

        private static $EDIT = "UPDATE clientes SET nombre=?, tipo=?, email=? ,telefono=?, direccion=?, porcentaje=? WHERE id = ?";

        private static $DELETE = "UPDATE clientes set status = 0 WHERE id = ?";

        public static function select(){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();
                
                $query = $con->prepare(self::$SELECT);
                $query->execute();

                $clientes = $query->fetchAll();

                $conexion->closeConexion();
                $con = null;
                
                return $clientes;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function selectId($id){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();
                
                $query = $con->prepare("SELECT * FROM clientes WHERE status = 1 and id = ?");
                $query->execute([$id]);

                $cliente = $query->fetch();

                $conexion->closeConexion();
                $con = null;
                
                return $cliente;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function insert($cliente){
            try{
                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare(self::$INSERT);
                $pst->execute([$cliente['nombre'],$cliente['tipo'],$cliente['email'],$cliente['telefono'],$cliente['direccion'],$cliente['porcentaje']]);

                $conexion->closeConexion();
                $con = null;

                return "OK";
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function update($cliente){
            try{
                $conexion = new Conexion();
                $con = $conexion->getConexion();
                
                $pst = $con->prepare(self::$EDIT);
                $pst->execute([$cliente['nombre'],$cliente['tipo'],$cliente['email'],$cliente['telefono'],$cliente['direccion'],$cliente['porcentaje'],$cliente['id']]);
                return "OK";
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function delete($id){
            try{
                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare(self::$DELETE);
                $pst->execute([$id]);

                return "OK";
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function llenarSelectClienteVentas(){
            $conexion = new Conexion();
            $con = $conexion->getConexion();

            $pst = $con->prepare('SELECT * FROM clientes');
            $pst->execute();

            $datos = $pst->fetchAll();

            foreach($datos as $row){
                echo '                     
                        <option value="'.$row['id'].'">
                            '.$row['nombre'].'
                        </option>  
                ';
            }

            $conexion->closeConexion();
            $con = null;
        }
    }

    

