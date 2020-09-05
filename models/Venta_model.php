<?php

require_once ("conexion.php");
require_once ("Cliente_model.php");
require_once ("Producto_model.php");

class Venta_model {

    private $totalVenta = 0;

    public static function llenarTablaVentasDia(){
        try{

            $conexion = new Conexion();
            $con = $conexion->getConexion();

            $pst = $con->prepare("SELECT * FROM ventas WHERE fecha = CURRENT_DATE");
            $pst->execute();

            $datos = $pst->fetchAll();

            foreach($datos as $row){
                echo '
                    <tr>
                        <td>'.$row['idVenta'].'</td>
                        <td>'.$row['cliente'].'</td>
                        <td>'.$row['fecha'].'</td>
                        <td>'.$row['hora'].'</td>
                        <td>'.$row['totalVendido'].'</td>
                    </tr>
                ';
            }

        }catch(PDOException $e){
            return $e->getMessage();
        }
    }

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

    public static function getDatosCliente($id){
        try{

            $conexion = new Conexion();
            $con = $conexion->getConexion();
            
            $pst = $con->prepare(("SELECT * FROM clientes WHERE id = ?"));
            $pst->execute([$id]);
            $datosCliente = $pst->fetch();

            $conexion->closeConexion();
            $con = null;

            return $datosCliente;
        }catch(PDOException $e){
            print_r($e->getMessage());
        }
    }

    public static function calcularTotalVenta($ventas){
        
        try{
            $conexion = new Conexion();
            $con = $conexion->getConexion();
            $totalVenta = 0;
            
            for($i = 1; $i < count($ventas); $i++){ // id, cantidad 
                $pst = $con->prepare("SELECT * FROM productos WHERE id_producto = ?");
                $pst->execute([$ventas[$i]->id]);
                $producto = $pst->fetch();
                $totalVenta = $totalVenta + $producto['precio_venta'] * $ventas[$i]->cantidad; 
            }

            $conexion->closeConexion();
            $con = null;

            return $totalVenta;
        }catch(PDOException $e){
            print_r($e->getMessage());
        }
    }

    public static function insertDetalleVenta($idVenta,$ventas){
        
        
        try{
            $conexion = new Conexion();
            $con = $conexion->getConexion();
            
            for($i = 1; $i < count($ventas); $i++){ // id, cantidad 
                $pst = $con->prepare("SELECT * FROM productos WHERE id_producto = ?");
                $pst->execute([$ventas[$i]->id]);
                $producto = $pst->fetch();
                
                // Insertamos el detalle de la venta
                $insertDetalleVenta = $con->prepare("INSERT INTO detalle_venta (idVenta,nomProducto,cantidad,precioU,total,categoria,codigo) VALUES (?,?,?,?,?,?,?)");

                $total = $producto['precio_venta'] * $ventas[$i]->cantidad;
                $categoria = self::getNameCategoria($producto['categoria']);

                $insertDetalleVenta->execute([$idVenta,$producto['nombre'],$ventas[$i]->cantidad,$producto['precio_venta'],$total,$categoria,$producto['id_producto']]);

                // Descontamos del Stock
                $stockActulizado = $producto['stock'] - $ventas[$i]->cantidad;
                $updateStock = $con->prepare("UPDATE productos set stock = ? where id_producto = ?");
                $updateStock->execute([$stockActulizado, $producto['id_producto']]);
            }

            $conexion->closeConexion();
            $con = null;

            return "BIEN";
        }catch(PDOException $e){
            return $e->getMessage();
        }
        
    }

    public static function getNameCategoria($idCategoria){
        try{

            $conexion = new Conexion();
            $con = $conexion->getConexion();

            $pst = $con->prepare("SELECT descripcion FROM categorias WHERE id_categoria = ?");
            $pst->execute([$idCategoria]);
            $categoria = $pst->fetch();

            $conexion->closeConexion();
            $con = null;

            return $categoria['descripcion'];
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

}

//ModeloVentas::calcularTotalVenta(["cliente"=>"1", ]);



?>