const btnCierreDia = document.getElementById('cerrarDia');

btnCierreDia.addEventListener('click', async () => {

    if(document.querySelector("#cerrarDia.disabled")){

    }else{

        const result = await Swal.fire({
            title: '¿ESTA SEGURO DE CERRAR EL DIA?',
            text: "Si no lo esta puede cancelar la acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, cerrar!'
        });

        if(result.value){

            let datos = new FormData();
            datos.append('cerrar_dia', 'OK');
            
            let peticion = await fetch('apis/apisCerrarDia.php', {
                method : 'POST',
                body : datos
            });

            let resjson = await peticion.json();

            if(resjson.respuesta == "OK"){
                notificacionExitosa("¡Día cerrado exitosamente!");
                document.getElementById('cerrarDia').innerText = "DIA CERRADO";
                document.getElementById('cerrarDia').className += " disabled";
            }else{
                notifacionError(resjson.respuesta);
            }
        }
    }
})

function notifacionError(mensaje){
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    })
}

function notificacionExitosa(mensaje){
    Swal.fire(
        mensaje,
        '',
        'success'
    ).then(result => {
        //document.getElementById('actualizarPaginaProductos').click();
    });
}
