<?php

require_once ("conexion.php");
require_once ("Cliente_model.php");
require_once ("Producto_model.php");

class Venta_model {

    private $totalVenta = 0;

    public static function insert($venta){
        try{

            $ban = self::verificarVenta($venta);
            if($ban){

                $conexion = new Conexion();
                $con = $conexion->getConexion();
                
                // Insertamos en la tabla ventas
                $query = $con->prepare("INSERT INTO ventas (cliente,total_venta,total_costo,ganancia) VALUES (?,?,?,?)");
                $query->execute([$venta[0]['cliente'],0,0,0]);

                // Obtenemos el id de la venta qu insertamos
                $query = $con->prepare("SELECT MAX(id_venta) as id_venta FROM ventas;");
                $query->execute();
                $id_venta = $query->fetch();

                //Empezamos a recorrer los producto de la venta
                for($i=1; $i<count($venta); $i++){
                    self::descontarProductoVenta($venta[$i]['producto'],$venta[$i]['cantidad'],$id_venta['id_venta']);
                }

                // Obtemos el total de la venta
                $query = $con->prepare("SELECT SUM(total_venta) as total_venta FROM ventas_producto WHERE id_venta = ?");
                $query->execute([$id_venta['id_venta']]);
                $total_venta = $query->fetch();

                // Obtemos el costo total de la venta
                $query = $con->prepare("SELECT SUM(total_costo) as total_costo FROM ventas_producto WHERE id_venta = ?");
                $query->execute([$id_venta['id_venta']]);
                $total_costo = $query->fetch();

                $ganancia = $total_venta['total_venta'] - $total_costo['total_costo'];

                // Modificamos la venta para insertar correctamente los totales y la ganancia
                $query = $con->prepare("UPDATE ventas set total_venta = ?, total_costo = ?, ganancia = ? WHERE id_venta = ? ");
                $query->execute([$total_venta['total_venta'],$total_costo['total_costo'],$ganancia,$id_venta['id_venta']]);

                return "OK"; 

            }else{
                return "Algunos productos tienen stock insuficiente";
            }

        }catch(PDOException $e){
            print_r($e->getMessage());
        }
    }

    /* Este metodo recibi id producto y cantidad que se vendio para descontar
       del stock y hacer los insert en las tablas correspondientes */
    public static function descontarProductoVenta($id, $cantidad, $venta){
        try{

            $conexion = new Conexion();
            $con = $conexion->getConexion();

            $cantidadBackups = $cantidad;

            $producto = Producto_model::selectId($id);
    
            // Seleccionamo el cns minimo
            $query = $con->prepare("SELECT MIN(cns) as cns FROM detalle_productos WHERE id_producto_dp = ? and stock > 0");
            $query->execute([$id]);
            $cns_min = $query->fetch();

            $ban = true;
            $cns = $cns_min['cns'];
            
            $total_venta = $producto['precio_venta'] * $cantidad;
            $total_costo = 0;

            while($ban){

                $query = $con->prepare("SELECT * FROM detalle_productos WHERE cns = ?");
                $query->execute([$cns]);
                $producto = $query->fetch();

                if($producto['stock'] >= $cantidad){
                    $disponible = $producto['stock'] - $cantidad;
                    $total_costo = $total_costo + ($cantidad * $producto['precio_compra']);
                    $query = $con->prepare("UPDATE detalle_productos set stock = ? WHERE cns = ?");
                    $query->execute([$disponible,$producto['cns']]);
                    $ban = false;
                }else{
                    $cantidad = $cantidad - $producto['stock'];
                    $total_costo = $total_costo + ($producto['stock'] * $producto['precio_compra']);
                    $query = $con->prepare("UPDATE detalle_productos set stock = 0 WHERE cns = ?");
                    $query->execute([$producto['cns']]);
                    $cns++;
                }

            }

            /* Insertamos el tabla ventas_producto */
            $query = $con->prepare("INSERT INTO ventas_producto (id_venta,id_producto,total_venta,total_costo,ganancia) VALUES (?,?,?,?,?)");
            $query->execute([$venta,$id,$total_venta,$total_costo,($total_venta-$total_costo)]);
            

            // Actualizamos el stock
            $producto = Producto_model::selectId($id);
            $stock = $producto['stock'] - $cantidadBackups;
            $query = $con->prepare("UPDATE productos set stock = ? WHERE id_producto = ?");
            $query->execute([$stock,$id]);

            // Insertamos en la tabla producto_descuentos
            $query = $con->prepare("INSERT INTO producto_descuentos (id_producto_pd,cantidad,razon) VALUES (?,?,?)");
            $query->execute([$id,$cantidadBackups,'Venta']);

            $conexion->closeConexion();
            $con = null;

            return true;

        }catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public static function verificarVenta($venta){
        for($i=1; $i<count($venta); $i++){
            $producto = Producto_model::selectId($venta[$i]['producto']);
            if($producto['stock'] < $venta[$i]['cantidad']){
                return false;
            }
        }
        return true;
    }
    /* Obtenemos el ID de la ultima venta realizada */
    public static function obtenerUltimaVenta(){
        try {
            $conexion = new Conexion();
            $con = $conexion->getConexion();
            $pst = $con->prepare("SELECT MAX(id_venta) as id FROM ventas ");
            $pst->execute();
    
            $venta = $pst->fetch();

            $conexion->closeConexion();
            $con = null;

            return $venta;

        } catch(PDOException $e){
            return $e->getMessage();
        }
    }
    /* Obtenemos la fehca, hora e id del cliente de una venta determinada */ 
    public static function obtenerHFVenta($id_v){
        try {
            $conexion = new Conexion();
            $con = $conexion->getConexion();
            $pst = $con->prepare("SELECT fecha, hora, cliente FROM ventas WHERE id_venta = ?");
            $pst->execute([$id_v]);
    
            $venta = $pst->fetch();

            $conexion->closeConexion();
            $con = null;

            return $venta;

        } catch(PDOException $e){
            return $e->getMessage();
        }
    }
     /* Obtenemos los productos de  una venta determinada */ 
     public static function obtenerProductosVenta($id_v){
        try {
            $conexion = new Conexion();
            $con = $conexion->getConexion();
            $pst = $con->prepare("SELECT p.id_producto as id, p.nombre, c.descripcion, vp.total_venta as total
            FROM ventas_producto vp, productos p, categorias c 
            WHERE vp.id_producto = p.id_producto and p.categoria = c.id_categoria and vp.id_venta = ?");
            $pst->execute([$id_v]);
    
            $venta = $pst->fetchAll();

            $conexion->closeConexion();
            $con = null;

            return $venta;

        } catch(PDOException $e){
            return $e->getMessage();
        }
    }
    /* Obtenemos los productos de  una venta determinada */ 
    public static function obtenerIdVentasFecha($fechaI,$fechaF){
        try {
            $conexion = new Conexion();
            $con = $conexion->getConexion();
            $pst = $con->prepare("SELECT id_venta as id
            FROM ventas
            WHERE fecha BETWEEN ? AND ?  ORDER BY fecha ASC");
            $pst->execute([$fechaI,$fechaF]);
    
            $venta = $pst->fetchAll();

            $conexion->closeConexion();
            $con = null;

            return $venta;

        } catch(PDOException $e){
            return $e->getMessage();
        }
    }
    
}



?>