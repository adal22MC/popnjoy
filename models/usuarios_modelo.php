<?php

include('conexion.php');

class ModeloUsuario{

    public static function verificarUsuario($user, $pass){
        try{
            $conexion = new Conexion();
            $con = $conexion->getConexion();
            $pst = $con->prepare("SELECT * FROM usuarios where username= ? and password= ?");

            $pst->execute([$user,$pass]);

            $datos = $pst->fetch();

            $conexion->closeConexion();
            $con = null;

            if($datos == false){
                return "No estas registrado!";
            }else{
                return "OK";
            }

        }catch(PDOException $e){
            return $e->getMessage();
        }
    }
}

//ModeloUsuario::verificarUsuario('12', 'admin');


?>