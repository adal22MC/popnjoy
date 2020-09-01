const editarSucursal = document.getElementById('formEditEmpresa');

async function init(){
    
   let datos = new FormData();
   datos.append('select', 'OK');

   let peticion = await fetch('controllers/Empresa_controller.php', {
       method : 'POST',
       body : datos
   })

   let resjson = await peticion.json();

   $("#nombre_empresa").val(resjson.nombre);
   $("#telefono").val(resjson.telefono);
   $("#correo").val(resjson.correo);
   $("#direccion").val(resjson.direccion);
   $("#pagina_web").val(resjson.pagina_web);
}

init();

editarSucursal.addEventListener('submit', function(e){

    $.ajax({
        url : "../controllers/Empresa_controller.php",
        type : "POST",
        data : {
            'update' : 'OK'
        },
        dataType : 'json',
        success : function(respuesta){
            
            if(respuesta.respuesta == "OK"){
                notificacionExitosa('Legalización realizado con exito!');
                obtenerUltimoDespacho();
            }else{
                notificarError(respuesta.respuesta);
            }
            
            console.log(respuesta)
        },
        error : function(xhr, status){
            notificarError('Ha ocurrido un error');
            console.log(xhr);
            console.log(status)
        }
    })

});

function notificacionExitosa(mensaje){
    Swal.fire(
        mensaje,
        '',
        'success'
    ).then(result => {
        window.location = "despacho.php";
    });
}

function notificarError(mensaje){
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    })
}