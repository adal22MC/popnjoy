<?php

include('../models/usuarios_modelo.php');

/* VERIFICAR SI EL USUARIO PUEDE ENTRAR AL SISTEMA */
if(isset($_POST['usuario']) 
    && preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['usuario'])
    && preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['pass'])
  ){
      
      $respuesta = ModeloUsuario::verificarUsuario($_POST['usuario'],$_POST['pass']);
      
      if($respuesta == "OK"){
        session_start();
        $_SESSION['usuario'] = 'usuario';
        echo json_encode(['respuesta'=>'OK']);
      }else{
        echo json_encode(['respuesta'=>$respuesta]);
      }
      
      
  }else{
    echo json_encode(['respuesta'=>'Caracteres no permitidos o campos vacio!']);
  }

?>