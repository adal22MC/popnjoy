<?php

    include('conexion.php');

    class ModeloProducto{

        private static $SELECT_ALL = "SELECT * FROM productos";

        private static $INSERT_PRODUCT = "INSERT INTO productos (nombre,categoria,stock,stock_min,
        stock_max,precio_venta,precio_compra,observaciones) values(?,?,?,?,?,?,?,?)";

        private static $UPDATE_PRODUCT = "UPDATE productos set nombre=?,categoria=?,stock=?,stock_min=?,stock_max=?,precio_venta=?,precio_compra=?,observaciones=? WHERE id_producto=?";

        public static function llenarTablaProductos(){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare(self::$SELECT_ALL);
                $pst->execute();

                $productos = $pst->fetchAll();

                foreach($productos as $row){
                    $categoria = self::getNameCategoria($row['categoria']);
                    echo '
                        <tr>
                            <td>'.$row['id_producto'].'</td>
                            <td>'.$row['nombre'].'</td>
                            <td>'.$categoria.'</td> 

                        ';
                    
                    // Validamos en que estado se encuentra el stock
                    if($row['stock'] > $row['stock_min'] ){
                        echo '
                        <td> 
                            <button class="btn btn-sm btn-success">'.$row['stock'].' </button>
                        </td>';
                    }else{
                        echo '
                        <td>  
                            <button class="btn btn-sm btn-danger">'.$row['stock'].' </button>
                        </td>';
                    }


                    echo '
                            <td>'.$row['precio_compra'].'</td>
                            <td>'.$row['precio_venta'].'</td>
                            <td>'.$row['observaciones'].'</td>
                            <td class="text-center py-0  align-middle">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-danger btn-sm btnBorrar mr-1" id='.$row['id_producto'].' >
                                    <i class="fas fa-trash-alt" id="'.$row['id_producto'].'"></i>
                                    </button>
                                
                                    <button class="btn btn-info btnEditar" data-toggle="modal" data-target="#modalEditarCliente" id="'.$row['id_producto'].'">
                                        <i class="fas fa-edit" id="'.$row['id_producto'].'"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    ';
                }
                $conexion->closeConexion();
                $con = null;

            }catch(PDOException $e){
                echo $e->getMessage();
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

        public static function llenarSelectCategorias(){
            try{
                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare('SELECT * FROM categorias');
                $pst->execute();

                $datos = $pst->fetchAll();

                foreach($datos as $row){
                    echo '                     
                            <option id="'.$row['id_categoria'].'" value="'.$row['id_categoria'].'">'.$row['descripcion'].'
                            </option>  
                    ';
                }

                $conexion->closeConexion();
                $con = null;

            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        public static function insertProduct($nom,$cat,$stock,$stockMin,$stockMax,$pVenta,$pCompra,$observaciones){
            try{
                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare(self::$INSERT_PRODUCT);
                $pst->execute([$nom,$cat,$stock,$stockMin,$stockMax,$pVenta,$pCompra,$observaciones]);

                return "ok";

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function edtiProduct($nom,$cat,$stock,$stockMin,$stockMax,$pVenta,$pCompra,$observaciones, $id){
            try{
                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare(self::$UPDATE_PRODUCT);
                $pst->execute([$nom,$cat,$stock,$stockMin,$stockMax,$pVenta,$pCompra,$observaciones,$id]);

                $conexion->closeConexion();
                $con = null;
                return "ok";

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function getProducId($id){
            try{
                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare("SELECT * FROM productos WHERE id_producto = ?");
                $pst->execute([$id]);
                $datos = $pst->fetch();

                $conexion->closeConexion();
                $con = null;

                return $datos;
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function deleteProductId($id){
            try{

                $stock = self::getStockProduct($id);
                if($stock != 0){
                    return "Este producto contiene stock! Para eliminarlo vacia el Stock!";
                }else{

                    $conexion = new Conexion();
                    $con = $conexion->getConexion();

                    $pst = $con->prepare("DELETE FROM productos WHERE id_producto = ?");
                    $pst->execute([$id]);

                    $conexion->closeConexion();
                    $con = null;

                    return "ok";
                }
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function getStockProduct($id){
            try{
                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare("SELECT stock FROM productos WHERE id_producto = ?");
                $pst->execute([$id]);

                $product = $pst->fetch();

                $conexion->closeConexion();
                $con = null;

                return $product['stock'];
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function llenarTablaProductosVenta(){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare(self::$SELECT_ALL);
                $pst->execute();

                $productos = $pst->fetchAll();

                foreach($productos as $row){
                    //$categoria = self::getNameCategoria($row['categoria']);
                    echo '
                        <tr>
                            <td>
                                <div class="text-center">
                                    <button class="btn btn-info btnAdd" id="'.$row['id_producto'].'">
                                        <i class="fas fa-reply btnAdd" id="'.$row['id_producto'].'"></i>
                                    </button>
                                </div>
                            </td>
                            <td>'.$row['id_producto'].'</td>
                            <td>'.$row['nombre'].'</td>
                    ';

                    // Validamos en que estado se encuentra el stock
                    if($row['stock'] > $row['stock_min'] ){
                        echo '
                        <td> 
                            <button class="btn btn-sm btn-success">'.$row['stock'].' </button>
                        </td>';
                    }else{
                        echo '
                        <td>  
                            <button class="btn btn-sm btn-danger">'.$row['stock'].' </button>
                        </td>';
                    }


                    echo'
                            <td>'.$row['precio_venta'].'</td>
                        </tr>
                    ';
                }
                $conexion->closeConexion();
                $con = null;

            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        public static function llenarTablaHistorialVentas(){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare("SELECT * FROM ventas order by fecha");
                $pst->execute();

                $ventas = $pst->fetchAll();

                foreach($ventas as $row){
                    
                    echo '
                        <tr>
                            <td>'.$row['idVenta'].'</td>
                            <td>'.$row['cliente'].'</td>
                            <td>'.$row['fecha'].'</td>
                            <td>'.$row['hora'].'</td>
                            <td>$'.$row['totalVendido'].'</td>
                            <td>
                                <div class="text-center">
                                    <button class="btn btn-danger btnPDF" id="'.$row['idVenta'].'">
                                        <i class="fas fa-file-pdf" id="'.$row['idVenta'].'"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    ';
                }
                $conexion->closeConexion();
                $con = null;

            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }
