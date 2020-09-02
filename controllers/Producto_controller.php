<?php

    require_once "../models/Producto_model.php";
    session_start();

    if(isset($_POST['select'])){
        if(isset($_SESSION['usuario'])){
            $productos = Producto_model::select();
            echo json_encode($productos);
        }
    }

    if(isset($_POST['insert'])){
        if(isset($_SESSION['usuario'])){

            $producto = array(
                "nombre"        => $_POST['nombre'],
                "categoria"     => $_POST['categoria'],
                "stock"         => 0,
                "stock_min"     => $_POST['stock_min'],
                "stock_max"     => $_POST['stock_max'],
                "precio_venta"  => $_POST['precio_venta'],
                "observaciones" => $_POST['observaciones']
            );

            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $producto['nombre']) && 
                preg_match('/^[()\-0-9 ]+$/', $producto['categoria']) &&
                preg_match('/^[()\-0-9 ]+$/', $producto['stock_min']) &&
                preg_match('/^[()\-0-9 ]+$/', $producto['stock_max']) &&
                preg_match('/^[()\-0-9 ]+$/', $producto['precio_venta']) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $producto['observaciones'])
            ){
                if($producto['stock_min'] <= 0 || $producto['stock_max'] <= $producto['stock_min']){
                    echo json_encode(['respuesta'=>'Parametros de stock invalidos!']);
                }else{
                    $response = Producto_model::insert($producto);
                    echo json_encode(['respuesta'=>$response]);
                }
            }else{
                echo json_encode(['respuesta'=>'Por favor verifica los caracteres incluidos.']);
            }
        }
    }

    if(isset($_POST['update'])){
        if(isset($_SESSION['usuario'])){

            $producto = array(
                "nombre"        => $_POST['nombre'],
                "categoria"     => $_POST['categoria'],
                "stock"         => 0,
                "stock_min"     => $_POST['stock_min'],
                "stock_max"     => $_POST['stock_max'],
                "precio_venta"  => $_POST['precio_venta'],
                "observaciones" => $_POST['observaciones'],
                "id"            => $_POST['id']
            );

            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $producto['nombre']) && 
                preg_match('/^[()\-0-9 ]+$/', $producto['categoria']) &&
                preg_match('/^[()\-0-9 ]+$/', $producto['stock_min']) &&
                preg_match('/^[()\-0-9 ]+$/', $producto['stock_max']) &&
                preg_match('/^[()\-0-9 ]+$/', $producto['precio_venta']) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $producto['observaciones']) &&
                preg_match('/^[()\-0-9 ]+$/', $producto['id'])
            ){
                if($producto['stock_min'] <= 0 || $producto['stock_max'] <= $producto['stock_min']){
                    echo json_encode(['respuesta'=>'Parametros de stock invalidos!']);
                }else{
                    $response = Producto_model::update($producto);
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
                    $response = Producto_model::delete($_POST['id']);
                    echo json_encode(['respuesta'=>$response]);
            }else{
                echo json_encode(['respuesta'=>'Por favor verifica los caracteres incluidos.']);
            }
        }
    }
