<?php

    require_once "../models/Venta_model.php";
    require_once "../models/Cierre_model.php";
    session_start();

    if(isset($_POST['select'])){
        if(isset($_SESSION['usuario'])){
            
            //$response = Venta_model::insert($venta);
            //echo json_encode(['respuesta'=>$response]);
        }
    }

    if(isset($_POST['generarVenta'])){
        if(isset($_SESSION['usuario'])){

            $response = Cierre_model::verificar_dia_cerrado();
            if($response == 'abierto'){
                $venta = $_POST['generarVenta'];
                $response = Venta_model::insert($venta);
                echo json_encode(['respuesta'=>$response]);
            }else if($response == 'cerrado'){
                echo json_encode(['respuesta'=>'Lo sentimos, la venta no se ha podido generar, el día ya fue cerrado']);
            }else{
                echo json_encode(['respuesta'=>'Lo sentimos, la venta no se ha podido generar, aún no hay apertura de día']);
            }            
        }
    }

    /* Retorna todas las ventas del día actual */
    if(isset($_POST['select_ventas_current'])){
        if(isset($_SESSION['usuario'])){
            $ventas = Venta_model::select_ventas_current();
            echo json_encode($ventas);
        }
    }

    if(isset($_POST['obtenerUltimaVenta'])){
        if(isset($_SESSION['usuario'])){
            
            $ventaID = Venta_model::obtenerUltimaVenta();
            echo json_encode($ventaID);
        }
    }