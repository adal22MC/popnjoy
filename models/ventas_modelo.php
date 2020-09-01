<?php

require_once('conexion.php');

class ModeloVentas{

    private $totalVenta = 0;


    // Este metodo no se usa
    public static function llenarTablaVentas(){
        try{

            $conexion = new Conexion();
            $con = $conexion->getConexion();

            $pst = $con->prepare("SELECT * FROM ventas");
            $pst->execute();

            $datos = $pst->fetchAll();

            foreach($datos as $row){
                echo '
                    <tr>
                        <td>'.$row['idVenta'].'</td>
                        <td>'.$row['cliente'].'</td>
                        <td>'.$row['fecha'] . $row['hora'].'</td>
                        <td>'.$row['totalVendido'].'</td>
                        <td>
                            <div class="text-center">
                                <button class="btn btn-danger btnBorrar" id='.$row['idVenta'].' >
                                <i class="fas fa-trash-alt" id="'.$row['idVenta'].'"></i>
                                </button>
                            
                                <button class="btn btn-info btnEditar" data-toggle="modal" data-target="#modalEditarSucursal" id="'.$row['idVenta'].'">
                                    <i class="fas fa-edit" id="'.$row['idVenta'].'"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                ';
            }

        }catch(PDOException $e){
            return $e->getMessage();
        }
    }

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

    public static function insertVentas($ventas){
        try{

            // Consultamos el nombre del cliente
            $clienteDatos = self::getDatosCliente($ventas[0]->idCliente);
            $totalVenta = self::calcularTotalVenta($ventas);

            
            $conexion = new Conexion();
            $con = $conexion->getConexion();
            
            
            $pst = $con->prepare(("INSERT INTO ventas (cliente,totalVendido) VALUES (?,?)"));
            $pst->execute([$clienteDatos['nombre'],$totalVenta]);

            // SELECT MAX(idVenta) from ventas
            $pst = $con->prepare("SELECT MAX(idVenta) as idVenta from ventas");
            $pst->execute();
            $idVenta = $pst->fetch();

            $res = self::insertDetalleVenta($idVenta['idVenta'],$ventas);

            
            return ['respuesta'=>'BIEN', 'idVenta'=>$idVenta['idVenta']];

        }catch(PDOException $e){
            print_r($e->getMessage());
        }
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