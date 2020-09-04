<?php

    require_once ('conexion.php');
    require_once ("Insumo_model.php");

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

        public static function addStock($id,$cantidad,$pc){
            try{

                $ban = self::verificarInsumosDisponibles($id,$cantidad);
                
                if($ban){

                    $conexion = new Conexion();
                    $con = $conexion->getConexion();

                    $query = $con->prepare("SELECT * FROM detalle_productos WHERE precio_compra = ?");
                    $query->execute([$pc]);

                    $precio = $query->fetch();

                    if($precio){
                        $total = $precio['stock'] + $cantidad;
                        $query = $con->prepare("UPDATE detalle_productos set stock = ? WHERE cns = ?");

                        $query->execute([$total,$precio['cns']]);
                    }else{
                        $query = $con->prepare("INSERT INTO detalle_productos (id_producto_dp,stock,precio_compra) VALUES (?,?,?)");

                        $query->execute([$id,$cantidad,$pc]);
                    }

                    if($query->rowCount() <= 0){
                        return "Ha ocurrido un error";
                    }

                    $producto = self::selectId($id);

                    $stock = $producto['stock'] + $cantidad;

                    $query = $con->prepare("UPDATE productos set stock = ? WHERE id_producto = ?");

                    $query->execute([$stock,$id]);

                    self::descontarInsumos($id,$cantidad);

                    $conexion->closeConexion();
                    $con = null;

                    return "OK";
                }else{
                    return "No hay insumos suficientes";
                }
                
                
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function verificarInsumosDisponibles($id,$cantidad){
            try{

                $insumos = self::selectInsumos($id);

                foreach($insumos as $row){
                    $disponible = Insumo_model::selectId($row['id_insumo']);
                    
                    if( ($row['cantidad'] * $cantidad) > $disponible['stock'] ){
                        return false;
                    }
                }
        
                return true;
                
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function descontarInsumos($id,$cantidad){
            try{

                $insumos = self::selectInsumos($id);

                foreach($insumos as $row){
                    $descontar = $row['cantidad'] * $cantidad;
                    Insumo_model::subtractStock($row['id_insumo'],$descontar,'Venta');
                }
                
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function subtractStock($id,$cantidad,$razon){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $cantidadBackups = $cantidad;

                $producto = self::selectId($id);

                if($producto['stock'] < $cantidad){
                    return "La cantidad es mayor al stock disponible";
                }

                // Seleccionamo el cns minimo
                $query = $con->prepare("SELECT MIN(cns) as cns FROM detalle_productos WHERE id_producto_dp = ?");
                $query->execute([$id]);
                $cns_min = $query->fetch();

                $ban = true;
                $cns = $cns_min['cns'];
                while($ban){

                    $query = $con->prepare("SELECT * FROM detalle_productos WHERE cns = ?");
                    $query->execute([$cns]);
                    $producto = $query->fetch();

                    if($producto['stock'] >= $cantidad){
                        $disponible = $producto['stock'] - $cantidad;
                        $query = $con->prepare("UPDATE detalle_productos set stock = ? WHERE cns = ?");
                        $query->execute([$disponible,$producto['cns']]);
                        $ban = false;
                    }else{
                        $cantidad = $cantidad - $producto['stock'];
                        $query = $con->prepare("UPDATE detalle_productos set stock = 0 WHERE cns = ?");
                        $query->execute([$producto['cns']]);
                        $cns++;
                    }

                }

                // Actualizamos el stock
                $producto = self::selectId($id);
                $stock = $producto['stock'] - $cantidadBackups;
                $query = $con->prepare("UPDATE productos set stock = ? WHERE id_producto = ?");
                $query->execute([$stock,$id]);

                // Insertamos en la tabla insumo_descuentos
                $query = $con->prepare("INSERT INTO producto_descuentos (id_producto_pd,cantidad,razon) VALUES (?,?,?)");
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

                $query = $con->prepare("SELECT * FROM productos WHERE status = 1 and id_producto = ?");
                $query->execute([$id]);

                $producto = $query->fetch();

                $conexion->closeConexion();
                $con = null;

                return $producto;                

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function selectInsumos($id){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $query = $con->prepare("SELECT pi.producto, i.id_insumo, i.nombre, pi.cantidad FROM producto_insumos pi, insumos i WHERE i.id_insumo = pi.insumo and pi.producto = ?");
                $query->execute([$id]);

                $producto = $query->fetchAll();

                $conexion->closeConexion();
                $con = null;

                return $producto;                

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

    }
