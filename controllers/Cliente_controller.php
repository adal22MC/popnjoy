<?php

    require_once "../models/Cliente_model.php";
    session_start();

    if(isset($_POST['select'])){
        if(isset($_SESSION['usuario'])){
            $clientes = Cliente_model::select();
            echo json_encode($clientes);
        }
    }