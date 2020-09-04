<?php

    require_once ('conexion.php');

    class Cliente_model {

        private static $SELECT = "SELECT * FROM clientes where status = 1";

        private static $INSERT_CLIENTE = "INSERT INTO clientes (nombre,tipo,email,telefono,direccion,porcentaje) VALUES (?,?,?,?,?,?)";

        private static $EDIT_CLIENT = "UPDATE clientes SET nombre=?, tipo=?, email=? ,telefono=?, direccion=?, porcentaje=? WHERE id = ?";

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

        public static function llenarTablaClientes(){
            $conexion = new Conexion();
            $con = $conexion->getConexion();

            $pst = $con->prepare('SELECT * FROM clientes');
            $pst->execute();
            $clientes = $pst->fetchAll();

            foreach($clientes as $row){
                echo '
                    <tr>
                        <td>'.$row['id'].'</td>
                        <td>'.$row['nombre'].'</td>
                        <td>'.$row['tipo'].'</td>
                        <td>'.$row['email'].'</td>
                        <td>'.$row['telefono'].'</td>
                        <td>'.$row['direccion'].'</td>
                        <td class="text-center py-0  align-middle">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-danger mr-1 btnBorrar" id='.$row['id'].' >
                                <i class="fas fa-trash-alt" id="'.$row['id'].'"></i>
                                </button>
                            
                                <button class="btn btn-info btnEditar" data-toggle="modal" data-target="#modalEditarCliente" id="'.$row['id'].'">
                                    <i class="fas fa-edit" id="'.$row['id'].'"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                ';
            }
            $conexion->closeConexion();
            $con = null;
        }

        public static function addCliente($nom,$tipo,$email,$tel,$direc,$des){
            try{
                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare(self::$INSERT_CLIENTE);
                $pst->execute([$nom,$tipo,$email,$tel,$direc,$des]);

                $conexion->closeConexion();
                $con = null;

                return "ok";
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function getClientId($id){
            try{
                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare("SELECT * FROM clientes WHERE id = ?");
                $pst->execute([$id]);

                $datosCliente = $pst->fetch();
                return $datosCliente;
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function editClient($id,$nombre,$tipo,$email,$tel,$dir,$por){
            try{
                $conexion = new Conexion();
                $con = $conexion->getConexion();
                
                $pst = $con->prepare(self::$EDIT_CLIENT);
                $pst->execute([$nombre,$tipo,$email,$tel,$dir,$por,$id]);
                return "ok";
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function deleteClient($id){
            try{
                $conexion = new Conexion();
                $con = $conexion->getConexion();

                $pst = $con->prepare("DELETE FROM clientes WHERE id = $id");
                $pst->execute();

                return "ok";
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

    

