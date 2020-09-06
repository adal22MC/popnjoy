<?php

    require_once "../models/Cierre_model.php";
    session_start();

    if(isset($_POST['check_apertura'])){
        if(isset($_SESSION['usuario'])){
            $response = Cierre_model::verificar_dia_cerrado();
            if($response == 'abierto'){
                echo json_encode(['respuesta'=>'La apertura de día ya se ha realizado antes.']);
            }else {
                echo json_encode(['respuesta'=>'OK']);
            }
        }
    }

    if(isset($_POST['open_day'])){
        if(isset($_SESSION['usuario'])){
            $response = Cierre_model::verificar_dia_cerrado();
            if($response == 'abierto'){
                echo json_encode(['respuesta'=>'La apertura de día ya se ha realizado antes.']);
            }else if($response == 'cerrado'){
                echo json_encode(['respuesta'=>'El dia ya a sido cerrado, espara al día de mañana para hacer la apertura nuevamente.']);
            }else{
                $response = Cierre_model::open_day();
                echo json_encode(['respuesta'=>$response]); 
            }
              
        }
    }

    if(isset($_POST['close_day'])){
        if(isset($_SESSION['usuario'])){
            $response = Cierre_model::verificar_dia_cerrado();
            if($response == 'abierto'){
                $response = Cierre_model::close_day();
                echo json_encode(['respuesta'=>$response]);
            }else if($response == 'cerrado'){
                echo json_encode(['respuesta'=>'El dia ya a sido cerrado, espara al día de mañana para hacer la apertura nuevamente.']);
            }else{
                echo json_encode(['respuesta'=>'El dia aun no a sido aperturado.']);
            }
              
        }
    }