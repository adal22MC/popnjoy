<?php

    include('../models/ventas_modelo.php');


    /* ================================
        Api para procesar la venta
     ================================== */
    if(isset($_POST)){
        try{
            $json = file_get_contents('php://input'); //  Obtenemos el JSON
            $datos = json_decode($json); // Lo decodificamos

            $response = ModeloVentas::insertVentas($datos);

            echo json_encode($response);
            
        }catch(Exception $e){
            print_r($e->getMessage());
        }
       
    }else{
        echo json_encode(['respuesta'=>'ERROR']);
    }



?>