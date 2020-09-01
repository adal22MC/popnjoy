<?php

    include("../models/categoria_modelo.php");

    /* =======================================
        Api para dar de alta una categoria
      ======================================= */
    if(isset($_POST['addCategoria'])){
        if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST['desCategorias'])){
            $response = ModeloCategoria::addSucursal($_POST['desCategorias']);
            if($response == "ok"){
                echo json_encode(array("respuesta"=>"ALTA CORRECTA"));
            }else{
                echo json_encode(array("respuesta"=>"Error con la base de datos"));
            }
        }else{
            echo json_encode(array("respuesta"=>"Error en caracteres"));
        }
    }

    /* =======================================
        Api para obtener una categoria por id
      ======================================= */
    if(isset($_POST['getSucursalId'])){
        if(preg_match('/^[()\-0-9 ]+$/', $_POST['getSucursalId'])){
            $categoria = ModeloCategoria::getCategoriaId($_POST['getSucursalId']);
            echo json_encode($categoria);
        }else{
            echo json_encode(array("respuesta"=>"Error en caracteres"));
        }
    }

    /* =======================================
        Api para editar una categoria por id
      ======================================= */
    if(isset($_POST['idEdit'])){
        if(preg_match('/^[()\-0-9 ]+$/', $_POST['idEdit']) &&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['editDesCategoria'])
        ){
            $response = ModeloCategoria::editCategoria($_POST['idEdit'],$_POST['editDesCategoria']);
            if($response == "ok"){
                echo json_encode(array("respuesta"=>"MODIFICACION EXITOSA"));
            }else{
                echo json_encode(array("respuesta"=>"Error con la base de datos"));
            }
            
        }else{
            echo json_encode(array("respuesta"=>"Error en caracteres"));
        }
    }

    /* =======================================
        Api para eliminar una categoria por id
      ======================================= */
    if(isset($_POST['deleteCategoria'])){
        if(preg_match('/^[()\-0-9 ]+$/', $_POST['deleteCategoria'])){
            $response = ModeloCategoria::deleteCategoria($_POST['deleteCategoria']);
            if($response == "ok"){
                echo json_encode(array("respuesta"=>"ELIMINACION CORRECTA"));
            }else if($response == "contiente productos"){
                echo json_encode(array("respuesta"=>"Esta categoria no puede ser eliminada, hay productos que pertenecen a esta categoria!"));
            }else{
                echo json_encode(array("respuesta"=>"Error con la base de datos"));
            }
        }else{
            echo json_encode(array("respuesta"=>"Error en los caracteres"));
        }
    }
?>