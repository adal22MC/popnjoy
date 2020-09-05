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

        public static function addStock($id,$cantidad,$pc){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $query = $con->prepare("SELECT * FROM detalle_insumos WHERE precio_compra = ?");
                $query->execute([$pc]);

                $precio = $query->fetch();

                if($precio){
                    $total = $precio['stock'] + $cantidad;
                    $query = $con->prepare("UPDATE detalle_insumos set stock = ? WHERE cns = ?");

                    $query->execute([$total,$precio['cns']]);
                }else{
                    $query = $con->prepare("INSERT INTO detalle_insumos (id_insumo_di,stock,precio_compra) VALUES (?,?,?)");

                    $query->execute([$id,$cantidad,$pc]);
                }

                if($query->rowCount() <= 0){
                    return "Ha ocurrido un error";
                }

                $insumo = self::selectId($id);

                $stock = $insumo['stock'] + $cantidad;

                $query = $con->prepare("UPDATE insumos set stock = ? WHERE id_insumo = ?");

                $query->execute([$stock,$id]);

                $conexion->closeConexion();
                $con = null;

                return "OK";
                
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function subtractStock($id,$cantidad,$razon){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $cantidadBackups = $cantidad;

                $insumo = self::selectId($id);

                if($insumo['stock'] < $cantidad){
                    return "La cantidad es mayor al stock disponible";
                }

                // Seleccionamo el cns minimo
                $query = $con->prepare("SELECT MIN(cns) as cns FROM detalle_insumos WHERE id_insumo_di = ? and stock > 0");
                $query->execute([$id]);
                $cns_min = $query->fetch();

                $ban = true;
                $cns = $cns_min['cns'];
                while($ban){

                    $query = $con->prepare("SELECT * FROM detalle_insumos WHERE cns = ?");
                    $query->execute([$cns]);
                    $insumo = $query->fetch();

                    if($insumo['stock'] >= $cantidad){
                        $disponible = $insumo['stock'] - $cantidad;
                        $query = $con->prepare("UPDATE detalle_insumos set stock = ? WHERE cns = ?");
                        $query->execute([$disponible,$insumo['cns']]);
                        $ban = false;
                    }else{
                        $cantidad = $cantidad - $insumo['stock'];
                        $query = $con->prepare("UPDATE detalle_insumos set stock = 0 WHERE cns = ?");
                        $query->execute([$insumo['cns']]);
                        $cns++;
                    }

                }

                // Actualizamos el stock
                $insumo = self::selectId($id);
                $stock = $insumo['stock'] - $cantidadBackups;
                $query = $con->prepare("UPDATE insumos set stock = ? WHERE id_insumo = ?");
                $query->execute([$stock,$id]);

                // Insertamos en la tabla insumo_descuentos
                $query = $con->prepare("INSERT INTO insumo_descuentos (id_insumo_id,cantidad,razon) VALUES (?,?,?)");
                $query->execute([$id,$cantidadBackups,$razon]);

                $conexion->closeConexion();
                $con = null;

                return "OK";
                
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function selectId($id){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $query = $con->prepare("SELECT * FROM insumos WHERE status = 1 and id_insumo = ?");
                $query->execute([$id]);

                $insumo = $query->fetch();

                $conexion->closeConexion();
                $con = null;

                return $insumo;                

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

    }
