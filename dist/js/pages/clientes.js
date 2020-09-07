const formCliente = document.getElementById('formCliente');

var btnAgregarCliente = document.getElementById('btnAgregarCliente');

var btnFormCliente = document.getElementById('btnFormCliente');

var tituloModal = document.getElementById('tituloModal');

var idCliente; 

var opcion; // 1 Insert, 2 Update

var tablaClientes;

function init(){
    tablaClientes = $("#tablaClientes").DataTable({
        "responsive": true,
        "autoWidth" : false,
        "ajax" : {
            "url" : "controllers/Cliente_controller.php",
            "type": "POST",
            "data": {
                "select" : "OK"
            },
            "dataSrc":""
        },
        "columns" :[
            {"data" : "id"},
            {"data" : "nombre"},
            {"data" : "tipo"},
            {"data" : "email"},
            {"data" : "telefono"},
            {"data" : "direccion"},
            {"data" : "porcentaje", "visible" : false},
            {"data" : "status", "visible" : false},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='fas fa-trash-alt'></i></button></div></div>"}
        ]
    });
}

init();

btnAgregarCliente.addEventListener('click', ()=>{
    formCliente.reset();
    btnFormCliente.innerText = "Guardar cliente";
    tituloModal.innerText = "Creando cliente";
    opcion = 1;
})

$(document).on('click', '.btnEditar', function(){
    opcion = 2;

    if(tablaClientes.row(this).child.isShown()){
        var data = tablaClientes.row(this).data();
    }else{
        var data = tablaClientes.row($(this).parents("tr")).data();
    }

    btnFormCliente.innerText = "Guardar cambios";
    tituloModal.innerText = "Modificando datos del cliente";

    idCliente = data['id'];

    $("#nombre").val(data['nombre']);
    $("#telefono").val(data['telefono']);
    $("#correo").val(data['email']);
    $("#direccion").val(data['direccion']);
    $("#tipo_cliente").val(data['tipo']);

    $("#modalCliente").modal("show");
})

formCliente.addEventListener('submit',async (e)=>{
    e.preventDefault();
    
    let datos = new FormData(formCliente);

    let mensaje;

    if(opcion == 1){
        datos.append('insert', 'OK');
        mensaje = "Creación de cliente exitosa";
    }else if(opcion == 2){
        datos.append('update', 'OK');
        datos.append('id', idCliente);
        mensaje = "Modificación exitosa";
    }

    try {

        let peticion =  await fetch('controllers/Cliente_controller.php',{
            method : 'POST',
            body : datos
        });

        let resjson = await peticion.json();

        if(resjson.respuesta == "OK"){
            notificacionExitosa(mensaje);
            tablaClientes.ajax.reload(null,false);
        }else{
            notificacionError(resjson.respuesta);
        }

    } catch (error) {
        console.log(error)
    }
})

$(document).on('click', '.btnBorrar', async function(){

    if(tablaClientes.row(this).child.isShown()){
        var data = tablaClientes.row(this).data();
    }else{
        var data = tablaClientes.row($(this).parents("tr")).data();
    }

    const result = await Swal.fire({
        title: '¿ESTA SEGURO DE ELIMINAR ESTE CLIENTE?',
        text: "Si no lo esta puede cancelar la acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0275d8',
        cancelButtonColor: '#d9534f',
        confirmButtonText: 'Si, eliminar!'
    });

    if(result.value){
        let datos = new FormData();
        datos.append('delete', 'OK');
        datos.append('id', data['id']);

        let peticion = await fetch('controllers/Cliente_controller.php', {
            method : 'POST',
            body : datos
        });

        let resjson = await peticion.json();

        if(resjson.respuesta === "OK"){
            notificacionExitosa('Eliminación exitosa');
            tablaClientes.ajax.reload(null,false);
        }else{
            notifacarError(resjson.respuesta);
        }
    }

});

function notificacionError(mensaje){
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
        
    });
}


