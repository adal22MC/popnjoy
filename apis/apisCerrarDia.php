<?php

    require_once "../models/dia_modelo.php";

    if( isset($_POST['cerrar_dia']) ){
        $dia = new Dia();
        $response = $dia->cerrarDia();
        echo json_encode(['respuesta'=>$response]);
    }