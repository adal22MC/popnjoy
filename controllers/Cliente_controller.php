<?php

    require_once "../models/Cliente_model.php";
    session_start();

    if(isset($_POST['select'])){
        if(isset($_SESSION['usuario'])){
            $clientes = Cliente_model::select();
            echo json_encode($clientes);
        }
    }

    if(isset($_POST['insert'])){
        if(isset($_SESSION['usuario'])){

            $cliente = array(
                "nombre"     => $_POST['nombre'],
                "tipo"       => $_POST['tipo_cliente'],
                "email"      => $_POST['correo'],
                "telefono"   => $_POST['telefono'],
                "direccion"  => $_POST['direccion'],
                "porcentaje"  => 0
            );

            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $cliente['nombre']) && 
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $cliente['tipo']) &&
                preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}+$/', $cliente['email']) &&
                preg_match('/^[()\-0-9 ]+$/', $cliente['telefono']) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ#.:\- ]+$/', $cliente['direccion'])
            ){
                
                $response = Cliente_model::insert($cliente);
                echo json_encode(['respuesta'=>$response]);
                
            }else{
                echo json_encode(['respuesta'=>'Por favor verifica los caracteres incluidos.']);
            }
        }
    }

    if(isset($_POST['update'])){
        if(isset($_SESSION['usuario'])){

            $cliente = array(
                "nombre"     => $_POST['nombre'],
                "tipo"       => $_POST['tipo_cliente'],
                "email"      => $_POST['correo'],
                "telefono"   => $_POST['telefono'],
                "direccion"  => $_POST['direccion'],
                "porcentaje" => 0,
                "id"         => $_POST['id']
            );

            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $cliente['nombre']) && 
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $cliente['tipo']) &&
                preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}+$/', $cliente['email']) &&
                preg_match('/^[()\-0-9 ]+$/', $cliente['telefono']) &&
                preg_match('/^[()\-0-9 ]+$/', $cliente['id']) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ#.:\- ]+$/', $cliente['direccion'])
            ){
                
                $response = Cliente_model::update($cliente);
                echo json_encode(['respuesta'=>$response]);
                
            }else{
                echo json_encode(['respuesta'=>'Por favor verifica los caracteres incluidos.']);
            }
        }
    }

    if(isset($_POST['delete'])){
        if(isset($_SESSION['usuario'])){

            $id = $_POST['id'];

            if(preg_match('/^[()\-0-9 ]+$/', $id) ){
                
                $response = Cliente_model::delete($id);
                echo json_encode(['respuesta'=>$response]);
                
            }else{
                echo json_encode(['respuesta'=>'Por favor verifica los caracteres incluidos.']);
            }
        }
    }