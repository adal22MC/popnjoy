<?php

include("../models/sucursal_modelo.php");

/* =====================================================
    Api que se usa para registrar una nueva sucursal
   =====================================================*/
if (isset($_POST['registrarSucursal'])) {
    
    if (
        isset($_POST['nombreSucursal']) && isset($_POST['ubicacionSucursal']) && isset($_POST['telefonoSucursal'])
        && isset($_POST['correoSucursal'])
    ) {

        $nombre = $_POST['nombreSucursal'];
        $ubicacion = $_POST['ubicacionSucursal'];
        $telefono = $_POST['telefonoSucursal'];
        $correo = $_POST['correoSucursal'];

        
        $res = ModeloSucursal::guardarSucursal($nombre,$ubicacion,$telefono,$correo);

        if($res == "ok"){
            echo json_encode(array("respuesta" => "ALTA CORRECTA"));
        }else{
            echo json_encode(array("respuesta" => "ALTA ERRONEA"));
        }
        
    } else {
        echo json_encode(array("respuesta" => "algunos campos estan vacios"));
    }
    
}

/* ======================================================
    Api que devuelve la ultima sucursal agrega a la BD
   ====================================================== */
if(isset($_POST['getAllSucursales'])){
    $response = ModeloSucursal::getUltimaSucursal();
    echo json_encode($response);
}

/* ======================================================
    Api que devuelve datos de una sucursal por su id
   ====================================================== */
if(isset($_POST['id'])){
    $response = ModeloSucursal::getSucursalId($_POST['id']);
    echo json_encode($response);
}

/* ======================================================
    Api que modifica datos de una sucursal 
   ====================================================== */
if(isset($_POST['editarSucursal'])){
    
    if (
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ. ]+$/', $_POST['editnombreSucursal']) &&
        preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST['editcorreoSucursal']) &&
        preg_match('/^[()\-0-9 ]+$/', $_POST['edittelefonoSucursal']) &&
        preg_match('/^[()\-0-9 ]+$/', $_POST['idEditarSucursal']) &&
        preg_match('/^[#\.\-a-zA-Z0-9,: ]+$/', $_POST['editubicacionSucursal'])
    ) {

        $id = $_POST['idEditarSucursal'];
        $nombre = $_POST['editnombreSucursal'];
        $ubicacion = $_POST['editubicacionSucursal'];
        $telefono = $_POST['edittelefonoSucursal'];
        $email = $_POST['editcorreoSucursal'];

        $response = ModeloSucursal::editSucursal($id,$nombre,$ubicacion,$telefono,$email);
        if($response == "ok"){
            echo json_encode(array("respuesta"=>"MODIFICACION CORRECTA"));
        }else{
            echo json_encode(array("respuesta"=>"error"));
        }
        

    }else{
        echo json_encode(array("respuesta"=>"Error En caracteres"));
    }
}

/* ======================================================
    Api que elimina una sucursal 
   ====================================================== */
if(isset($_POST['eliminarSucursal'])){
    if(preg_match('/^[()\-0-9 ]+$/', $_POST['eliminarSucursal'])){
        $id = $_POST['eliminarSucursal'];
        $response = ModeloSucursal::eliminarSucursal($id);
        if($response == "ok"){
            echo json_encode(array("respuesta"=>"Eliminacion correcta"));
        }else{
            echo json_encode(array("respuesta"=>"Error al intenter eliminar"));
        }
        
    }else{
        echo json_encode(array("respuesta"=>"error en caracteres"));
    }
    
}


