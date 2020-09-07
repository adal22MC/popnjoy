<?php

    require_once "../models/Venta_model.php";
    session_start();

    if(isset($_POST['generarVenta'])){
        if(isset($_SESSION['usuario'])){
            $venta = $_POST['generarVenta'];
            $response = Venta_model::insert($venta);
            echo json_encode(['respuesta'=>$response]);
        }
    }

    if(isset($_POST['obtenerUltimaVenta'])){
        if(isset($_SESSION['usuario'])){
            
            $ventaID = Venta_model::obtenerUltimaVenta();
            echo json_encode($ventaID);
        }
    }