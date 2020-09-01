<?php

    require_once "conexion.php";

    class Empresa_model {

        private $nombre;
        private $telefono;
        private $correo;
        private $direccion;
        private $pagina_web;

        public function __construct($nombre,$telefono,$correo,$direccion,$pagina_web){
            $this->nombre = $nombre;
            $this->telefono = $telefono;
            $this->correo = $correo;
            $this->direccion = $direccion;
            $this->pagina_web = $pagina_web;
        }

        public function update(){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $query = $conn->prepare("UPDATE datos_empresa set nombre = ?, telefono = ?, correo = ?, direccion = ?, pagina_web = ? WHERE id = 1");

                $query->execute([$this->nombre,$this->telefono,$this->correo,$this->direccion,$this->pagina_web]);

                $numRows = $query->rowCount();

                return "OK";
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function select(){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $query = $conn->prepare("SELECT * FROM datos_empresa WHERE id = 1");

                $query->execute();

                $datos = $query->fetch();

                return $datos;
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

    }