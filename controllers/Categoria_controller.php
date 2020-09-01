<?php

    require_once "../models/Categoria_modelo.php";
    session_start();

    if(isset($_POST['select'])){
        if(isset($_SESSION['usuario'])){
            $categorias = Categoria_model::select();
            echo json_encode($categorias);
        }
    }

    if(isset($_POST['insert'])){
        if(isset($_SESSION['usuario'])){
            $response = Categoria_model::insert($_POST['descripcion']);
            echo json_encode(['respuesta'=>$response]);
        }
    }

    if(isset($_POST['update'])){
        if(isset($_SESSION['usuario'])){
            $response = Categoria_model::update($_POST['id'],$_POST['descripcion']);
            echo json_encode(['respuesta'=>$response]);
        }
    }

    if(isset($_POST['delete'])){
        if(isset($_SESSION['usuario'])){
            $response = Categoria_model::delete($_POST['id']);
            echo json_encode(['respuesta'=>$response]);
        }
    }