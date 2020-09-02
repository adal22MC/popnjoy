<?php

    require_once ('conexion.php');

    class Categoria_model {

        private static $SELECT_ALL_CATEGORIAS = "SELECT * FROM categorias";
        private static $SELECT_ID_CATEGORIAS = "SELECT * FROM categorias WHERE id_categoria = ?";
        private static $ADD_CATEGORIA = "INSERT INTO categorias (descripcion) values (?)";
        private static $EDIT_CATEGORIA = "UPDATE categorias set descripcion=? WHERE id_categoria=?";

        public static function select(){
            try{
                $conexion = new Conexion();
                $con = $conexion->getConexion();
                $query = $con->prepare(self::$SELECT_ALL_CATEGORIAS);
                $query->execute();

                $categorias = $query->fetchAll();

                $conexion->closeConexion();
                $con = null;

                return $categorias;
                
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function insert($descripcion){
            try{
                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare(self::$ADD_CATEGORIA);
                $pst->execute([$descripcion]);

                $conexion->closeConexion();
                $con = null;

                $numRow = $pst->rowCount();

                if($numRow > 0){
                    return "OK";
                }

                return "Se genero un error en el registro";
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function update($id, $descripcion){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare(self::$EDIT_CATEGORIA);
                $pst->execute(array($descripcion,$id));

                $conexion->closeConexion();
                $con = null;

                return "OK";
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function delete($id){
            $ban = self::verificarCategoria($id);
            if($ban == true){
                try{
                    $conexion = new Conexion();
                    $con = $conexion->getConexion();
                    $pst = $con->prepare("DELETE FROM categorias WHERE id_categoria = $id");
                    $pst->execute();
    
                    $conexion->closeConexion();
                    $con = null;
    
                    return "OK";
                    
                }catch(PDOException $e){
                    return $e->getMessage();
                }
            }else{
                return "Hay materiales que pertenecen a esta categoria";
            }
        }

        // Verifica la categoria antes de la eliminación
        public static function verificarCategoria($idCategoria){
            try{
                $conexion = new Conexion();
                $con = $conexion->getConexion();
                $pst = $con->prepare("SELECT * FROM productos WHERE categoria = $idCategoria");
                $pst->execute();

                $filas = $pst->fetchAll();

                $conexion->closeConexion();
                $con = null;

                if(count($filas) > 0){
                    return false;
                }else{
                    return true;
                }
                
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function llenasTablaCategorias(){

            $conexion = new Conexion();
            $con = $conexion->getConexion();
            $pst = $con->prepare(self::$SELECT_ALL_CATEGORIAS);
            $pst->execute();
            $categorias = $pst->fetchAll();

            foreach($categorias as $row){
                echo '
                    <tr>
                        <td>'.$row['id_categoria'].'</td>
                        <td>'.$row['descripcion'].'</td>
                        <td class="text-center py-0  align-middle">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-danger mr-1 btnBorrar" id='.$row['id_categoria'].' >
                                <i class="fas fa-trash-alt" id="'.$row['id_categoria'].'"></i>
                                </button>
                            
                                <button class="btn btn-info btnEditar" data-toggle="modal" data-target="#modalEditarSucursal" id="'.$row['id_categoria'].'">
                                    <i class="fas fa-edit" id="'.$row['id_categoria'].'"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                ';
            }

            $conexion->closeConexion();
            $conn = null;

        }

        public static function getCategoriaId($id){
            try{

                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare(self::$SELECT_ID_CATEGORIAS);

                $pst->execute(array($id));
                $categoria = $pst->fetch();
       
                $conexion->closeConexion();
                $conn = null;

                return $categoria;

            }catch(PDOException $e) {
                return $e->getMessage();
            }
        }

    }
