<?php

    require_once "../models/Insumo_model.php";
    session_start();

    if(isset($_POST['select'])){
        if(isset($_SESSION['usuario'])){
            $insumos = Insumo_model::select();
            echo json_encode($insumos);
        }
    }

    if(isset($_POST['insert'])){
        if(isset($_SESSION['usuario'])){

            $insumo = array(
                "nombre"        => $_POST['nombre'],
                "stock"         => 0,
                "stock_min"     => $_POST['stock_min'],
                "stock_max"     => $_POST['stock_max'],
                "um"  => $_POST['unidad_medida']
            );

            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $insumo['nombre']) && 
                preg_match('/^[()\-0-9 ]+$/', $insumo['stock_min']) &&
                preg_match('/^[()\-0-9 ]+$/', $insumo['stock_max']) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $insumo['um'])
            ){
                if($insumo['stock_min'] <= 0 || $insumo['stock_max'] <= $insumo['stock_min']){
                    echo json_encode(['respuesta'=>'Parametros de stock invalidos!']);
                }else{
                    $response = Insumo_model::insert($insumo);
                    echo json_encode(['respuesta'=>$response]);
                }
            }else{
                echo json_encode(['respuesta'=>'Por favor verifica los caracteres incluidos.']);
            }
        }
    }

    if(isset($_POST['update'])){
        if(isset($_SESSION['usuario'])){

            $insumo = array(
                "nombre"        => $_POST['nombre'],
                "stock"         => 0,
                "stock_min"     => $_POST['stock_min'],
                "stock_max"     => $_POST['stock_max'],
                "um"            => $_POST['unidad_medida'],
                "id"            => $_POST['id']
            );

            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $insumo['nombre']) && 
                preg_match('/^[()\-0-9 ]+$/', $insumo['stock_min']) &&
                preg_match('/^[()\-0-9 ]+$/', $insumo['stock_max']) &&
                preg_match('/^[()\-0-9 ]+$/', $insumo['id']) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $insumo['um'])
            ){
                if($insumo['stock_min'] <= 0 || $insumo['stock_max'] <= $insumo['stock_min']){
                    echo json_encode(['respuesta'=>'Parametros de stock invalidos!']);
                }else{
                    $response = Insumo_model::update($insumo);
                    echo json_encode(['respuesta'=>$response]);
                }
            }else{
                echo json_encode(['respuesta'=>'Por favor verifica los caracteres incluidos.']);
            }
        }
    }

    if(isset($_POST['delete'])){
        if(isset($_SESSION['usuario'])){

            if(preg_match('/^[()\-0-9 ]+$/', $_POST['id'])){
                    $response = Insumo_model::validarDelete($_POST['id']);
                    if($response){
                        $response = Insumo_model::delete($_POST['id']);
                        echo json_encode(['respuesta'=>$response]);
                    }else{
                        echo json_encode(['respuesta'=>'Hay productos que depende de este insumo!']);
                    }
                    
            }else{
                echo json_encode(['respuesta'=>'Por favor verifica los caracteres incluidos.']);
            }
        }
    }
    
    if(isset($_POST['addStock'])){
        if(isset($_SESSION['usuario'])){

            if(
                preg_match('/^[()\-0-9 ]+$/', $_POST['cantidad']) &&
                preg_match('/^[()\-0-9 ]+$/', $_POST['id'])
            ){
                if($_POST['cantidad'] > 0){
                    $response = Insumo_model::addStock($_POST['id'],$_POST['cantidad'],200);
                    echo json_encode(['respuesta'=>$response]);
                }else{
                    echo json_encode(['respuesta'=>'La cantidad a aumentar no puede ser 0']);
                }
                   
            }else{
                echo json_encode(['respuesta'=>'Por favor verifica los caracteres incluidos.']);
            }
        }
    }

    if(isset($_POST['subtractStock'])){
        if(isset($_SESSION['usuario'])){

            if(
                preg_match('/^[()\-0-9 ]+$/', $_POST['cantidad']) &&
                preg_match('/^[()\-0-9 ]+$/', $_POST['id']) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['razon'])
            ){
                if($_POST['cantidad'] > 0){
                    $response = Insumo_model::subtractStock($_POST['id'],$_POST['cantidad'],$_POST['razon']);
                    echo json_encode(['respuesta'=>$response]);
                }else{
                    echo json_encode(['respuesta'=>'La cantidad a descontar no puede ser 0']);
                }
                   
            }else{
                echo json_encode(['respuesta'=>'Por favor verifica los caracteres incluidos.']);
            }
        }
    }
