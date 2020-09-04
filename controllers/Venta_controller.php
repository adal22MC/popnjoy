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