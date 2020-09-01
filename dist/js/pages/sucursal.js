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

editarSucursal.addEventListener('submit', async function(e){
    e.preventDefault();
    let datos = new FormData(editarSucursal);
    datos.append('update', 'OK');
 
    let peticion = await fetch('controllers/Empresa_controller.php', {
        method : 'POST',
        body : datos
    })
 
    let resjson = await peticion.json();
    
    if(resjson.respuesta === "OK"){
        notificacionExitosa('Modificación de datos exitosa!');
    }else{
        notificarError(resjson.respuesta);
    }

});

function notificacionExitosa(mensaje){
    Swal.fire(
        mensaje,
        '',
        'success'
    )
}

function notificarError(mensaje){
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    })
}