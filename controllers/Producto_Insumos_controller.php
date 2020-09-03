<?php

    require_once "../models/Producto_Insumos_model.php";
    session_start();

    if(isset($_POST['selectInsumos'])){
        if(isset($_SESSION['usuario'])){
            if(preg_match('/^[()\-0-9 ]+$/', $_POST['id'])){
                $insumos = Producto_Insumos_model::selectInsumos($_POST['id']);
                echo json_encode($insumos);
            }else{
                echo json_encode(['respuesta'=>'Por favor verifica los caracteres incluidos.']);
            }
        }
    }

    if(isset($_POST['insumos'])){
        if(isset($_SESSION['usuario'])){
            $insumos = $_POST['insumos'];
            $response = Producto_Insumos_model::renovarInsumos($insumos);
            echo json_encode(['respuesta'=>$response]);
        }
    }