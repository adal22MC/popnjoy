var apertura = document.getElementById('apertura_dia');

apertura.addEventListener('click', async ()=>{

    let datos = new FormData();
    datos.append('check_apertura', 'OK');

    let peticion = await fetch('controllers/Cierre_controller.php', {
        method : 'POST',
        body : datos
    });

    let resjson = await peticion.json();

    console.log(resjson)

    if(resjson.respuesta === "OK"){
        
        const result = await Swal.fire({
            title: '¿ESTA SEGURO DE ABRIR EL DIA?',
            text: "Si no lo esta puede cancelar la acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0275d8',
            cancelButtonColor: '#d9534f',
            confirmButtonText: 'Si, abrir!'
        });
    
        if(result.value){
            let datos = new FormData();
            datos.append('open_day', 'OK');
    
            let peticion = await fetch('controllers/Cierre_controller.php', {
                method : 'POST',
                body : datos
            });
    
            let resjson = await peticion.json();
    
            if(resjson.respuesta === "OK"){
                notificacionExitosa('Apertura de día exitosa!');
            }else{
                notificar(resjson.respuesta);
            }
        }
        
    }else{
        notificar(resjson.respuesta);
    }
    
})


function notificar(mensaje){
    Swal.fire({
        title: 'Mensaje',
        text: mensaje
    })
}

function notificacionExitosa(mensaje){
    Swal.fire(
        mensaje,
        '',
        'success'
    ).then(result => {
        
    });
}