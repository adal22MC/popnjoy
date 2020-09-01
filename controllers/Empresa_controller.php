<?php

    session_start();
    require_once "../models/Empresa_model.php";

    if(isset($_POST['update'])){
        if(isset($_SESSION['usuario'])){
            if($_POST['nombre_empresa'] != "" && $_POST['telefono'] != "" &&
               $_POST['correo'] != "" && $_POST['direccion'] != "" && $_POST['pagina_web'] != ""){

                $empresa = new Empresa_model($_POST['nombre_empresa'],$_POST['telefono'],$_POST['correo'],$_POST['direccion'],$_POST['pagina_web']);

                $response =  $empresa->update();
                
                echo json_encode(['respuesta'=>$response]);
            }else{
                echo json_encode(['respuesta'=>'La información de la empresa no puede estar vacia']);
            }
        }else{
            echo json_encode(['respuesta'=>'Acceso degenado']);
        }
    }

    if(isset($_POST['select'])){
        if(isset($_SESSION['usuario'])){

            $datos_empresa = Empresa_model::select();

            echo json_encode($datos_empresa);

        }
    }