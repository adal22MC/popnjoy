<?php

    require_once('../models/cliente_modelo.php');

    /* Retorna los datos de todos los clientes */
    if(isset($_POST['getAllClients'])){
        $clientes = ModeloCliente::getAllClients();
        echo json_encode($clientes);
    }

    /* Agrega un nuevo cliente */
    if(isset($_POST['addCliente'])){

        $nombre = $_POST['nombreCliente'];
        $tipo = $_POST['tipoCliente'];
        $email = $_POST['correoCliente'];
        $tel = $_POST['telefonoCliente'];
        $direccion = $_POST['direccionCliente'];
        $descuento = 0;

        if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $nombre) && 
           preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $tipo) &&
           preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}+$/', $email) &&
           preg_match('/^[()\-0-9 ]+$/', $tel) &&
           preg_match('/^[#\.\-a-zA-Z0-9,ñÑáéíóúÁÉÍÓÚ ]+$/', $direccion) &&
           preg_match('/^[()\-0-9 ]+$/', $descuento)
        ){
            $reponse = ModeloCliente::addCliente($nombre,$tipo,$email,$tel,$direccion,$descuento);
            if($reponse == "ok"){
                echo json_encode(["respuesta"=>"ALTA CORRECTA"]);
            }else{
                echo json_encode(["respuesta"=>"Error en la base de datos."]);
            }
        }else{
            echo json_encode(["respuesta"=>"Error en caracteres!."]);
        }
    }

    /* Retorna datos de un cliente especifico */
    if(isset($_POST['id'])){

        $id = $_POST['id'];

        if(preg_match('/^[()\-0-9 ]+$/', $id)){
            $reponse = ModeloCliente::getClientId($id);
            echo json_encode($reponse);
        }else{
            echo json_encode(array('respuesta'=>'Error en los caracteres'));
        }
    }

    /* edita un cliente por su id */
    if(isset($_POST['editClientId'])){
        
        $id = $_POST['editClientId'];
        $nombre = $_POST['nombreCliente'];
        $tipo = $_POST['tipoCliente'];
        $email = $_POST['correoCliente'];
        $tel = $_POST['telefonoCliente'];
        $direccion = $_POST['direccionCliente'];
        $descuento = 0;


        if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $nombre) && 
           preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $tipo) &&
           preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}+$/', $email) &&
           preg_match('/^[()\-0-9 ]+$/', $tel) &&
           preg_match('/^[#\.\-a-zA-Z0-9, ]+$/', $direccion) &&
           preg_match('/^[()\-0-9 ]+$/', $id)
        ){
            $reponse = ModeloCliente::editClient($id,$nombre,$tipo,$email,$tel,$direccion,$descuento);
            if($reponse == "ok"){
                echo json_encode(['respuesta'=>'MODIFICACION CORRECTA']);
            }else{
                echo json_encode(['respuesta'=>'Error en la base de datos.']);
            }
        }else{
            echo json_encode(['respuesta'=>'Error en los caracteres.']);
        }    
          
    }

    /* Elimina un cliente por su ID */
    if(isset($_POST['deleteId'])){
        if(preg_match('/^[()\-0-9 ]+$/', $_POST['deleteId'])){
            $reponse = ModeloCliente::deleteClient($_POST['deleteId']);
            if($reponse == "ok"){
                echo json_encode(['respuesta'=>'ELIMINACION CORRECTA']);
            }else{
                echo json_encode(['respuesta'=>'Error en la base de datos.']);
            }
        }else{
            echo json_encode(['respuesta'=>'Error en los caracteres.']);
        }
    }
?>