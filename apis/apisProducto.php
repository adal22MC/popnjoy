<?php

include ('../models/producto_modelo.php');


/* Agregar un producto */
if(isset($_POST['addProduct'])){
    $nombre = $_POST['nombreProducto'];
    $idCategoria = $_POST['categoria'];
    $stock = $_POST['stockProducto'];
    $stock_min = $_POST['stockMinimo'];
    $stock_max = $_POST['stockMaximo'];
    $precioVenta = $_POST['precioVenta'];
    $precioCompra = $_POST['precioCompra'];
    $observaciones = $_POST['observaciones'];

    if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $nombre) && 
           preg_match('/^[()\-0-9 ]+$/', $idCategoria) &&
           preg_match('/^[()\-0-9 ]+$/', $stock) &&
           preg_match('/^[()\-0-9 ]+$/', $stock_max) &&
           preg_match('/^[()\-0-9 ]+$/', $stock_min) &&
           preg_match('/^[()\-0-9 ]+$/', $precioCompra) &&
           preg_match('/^[()\-0-9 ]+$/', $precioVenta) &&
           preg_match('/^[#\.\-a-zA-Z0-9, ]+$/', $observaciones)
    ){
        $response = ModeloProducto::insertProduct($nombre,$idCategoria,$stock,$stock_min,$stock_max,$precioVenta,$precioCompra,$observaciones);
        if($response == "ok"){
            echo json_encode(['respuesta'=>'ALTA CORRECTA']);
        }else{
            echo json_encode(['respuesta'=>'Error en la base de datos.']);
        }
    }else{
        echo json_encode(['respuesta'=>'Error en carecteres.']);
    }
}

/* Obtener datatos de un producto */
if(isset($_POST['idProduct'])){
    if(preg_match('/^[()\-0-9 ]+$/', $_POST['idProduct'])){
        $response = ModeloProducto::getProducId($_POST['idProduct']);
        echo json_encode($response);
    }else{
        echo json_encode(['respuesta'=>'Eror en el id']);
    }
}

if(isset($_POST['editProduct'])){
    $idModificar = $_POST['editProduct'];
    $nombre = $_POST['nombreProducto'];
    $idCategoria = $_POST['idcategoria'];
    $stock = $_POST['stockProducto'];
    $stock_min = $_POST['stockMinimo'];
    $stock_max = $_POST['stockMaximo'];
    $precioVenta = $_POST['precioVenta'];
    $precioCompra = $_POST['precioCompra'];
    $observaciones = $_POST['observaciones'];

    if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $nombre) && 
           preg_match('/^[()\-0-9 ]+$/', $idCategoria) &&
           preg_match('/^[()\-0-9 ]+$/', $stock) &&
           preg_match('/^[()\-0-9 ]+$/', $stock_max) &&
           preg_match('/^[()\-0-9 ]+$/', $stock_min) &&
           preg_match('/^[()\-0-9 ]+$/', $precioCompra) &&
           preg_match('/^[()\-0-9 ]+$/', $precioVenta) &&
           preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ, ]+$/', $observaciones)
    ){
        $response = ModeloProducto::edtiProduct($nombre,$idCategoria,$stock,$stock_min,$stock_max,$precioVenta,$precioCompra,$observaciones,$idModificar);

        if($response == "ok"){
            echo json_encode(['respuesta'=>'MODIFICACION CORRECTA']);
        }else{
            echo json_encode(['respuesta'=>$response]);
        }
    }else{
        echo json_encode(['respuesta'=>'Error en carecteres.']);
    }
}

if(isset($_POST['deleteProduct'])){
    if(preg_match('/^[()\-0-9 ]+$/', $_POST['deleteProduct'])){
        $response = ModeloProducto::deleteProductId($_POST['deleteProduct']);
        if($response == "ok"){
            echo json_encode(['respuesta'=>'ELIMINACION CORRECTA']);
        }else{
            echo json_encode(['respuesta'=>$response]);
        }
    }else{
        echo json_encode(['respuesta'=>'Eror en el id']);
    }
}
