const btnCierreDia = document.getElementById('cerrarDia');

var tablaVentas;

async function init(){
    tablaVentas = $("#tablaVentas").DataTable({
        "responsive": true,
        "autoWidth" : false,
        "ajax" : {
            "url" : "controllers/Venta_controller.php",
            "type": "POST",
            "data": {
                "select_ventas_current" : "OK"
            },
            "dataSrc":""
        },
        "columns" :[
            {"data" : "id_venta"},
            {"data" : "cliente"},
            {"data" : "fecha"},
            {"data" : "hora"},
            {"data" : "total_venta"},
            {"data" : "total_productos"},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='fas fa-trash-alt'></i></button></div></div>"}
        ]
    });

    let datos = new FormData();
    datos.append('check_apertura', 'OK');

    let peticion = await fetch('controllers/Cierre_controller.php', {
        method : 'POST',
        body : datos
    });

    let resjson = await peticion.json();

    if(resjson.respuesta === "OK"){
        document.getElementById('cerrarDia').className += " disabled";
    }
}

init();

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
            datos.append('close_day', 'OK');
            
            let peticion = await fetch('controllers/Cierre_controller.php', {
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
