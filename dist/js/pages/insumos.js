// Tabla de los insumos
var tablaInsumos;

// Boton form del modal de insumos
var formInsumos = document.getElementById('formInsumos');

// Boton agregar producto
var btnAgregarInsumo = document.getElementById('btnAgregarInsumo');

// Titulo del modal
var tituloModal = document.getElementById('tituloModal');

// Boton form del modal
var btnFormInsumos = document.getElementById('btnFormInsumos');

// Variable opcion, insert => 1, update 2
var opcion;

// Id del producto
var id;

function init(){
    tablaInsumos = $("#tablaInsumos").DataTable({
        "responsive": true,
        "autoWidth" : false,
        "ajax" : {
            "url" : "controllers/Insumo_controller.php",
            "type": "POST",
            "data": {
                "select" : "OK"
            },
            "dataSrc":""
        },
        "columns" :[
            {"data" : "id_insumo", "visible" : false},
            {"data" : "nombre"},
            {"data" : "stock"},
            {"data" : "stock_min"},
            {"data" : "stock_max"},
            {"data" : "um"},
            {"data" : "status", "visible" : false},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='fas fa-trash-alt'></i></button></div></div>"}
        ]
    });


}

init();

formInsumos.addEventListener('submit', async (e) => {
    e.preventDefault();

    let mensaje = "";

    // Preparemos los datos
    let datosProducto = new FormData(formInsumos);
    if(opcion == 1){
        datosProducto.append('insert', 'OK');
        mensaje = "Registro de insumo exitoso!";
    }else{
        datosProducto.append('update', 'OK');
        datosProducto.append('id', id);
        mensaje = "Modificación exitosa!";
    }
    

    if(datosProducto.get('stock_min') < 0){
        notifacionError("El stock minimo no puede ser negativo!");
    }else if(datosProducto.get('stock_max') < 0){
        notifacionError("El stock maximo no puede ser negativo!");
    }else{
        try {
            let peticion = await fetch('controllers/Insumo_controller.php',{
                method : 'POST',
                body : datosProducto
            });

            let resjson = await peticion.json();

            if(resjson.respuesta === "OK"){
                $("#modalInsumos").modal('hide');
                notificacionExitosa(mensaje);
                tablaInsumos.ajax.reload(null,false);
            }else{
                notifacionError(resjson.respuesta);
            }

        } catch (error) {
            console.log(error);
        }
    }
    
})

btnAgregarInsumo.addEventListener('click', ()=>{
    formInsumos.reset();
    opcion = 1;
    tituloModal.innerHTML = "Creación de Insumo";
    btnFormInsumos.innerText = "Guardar";
});

$(document).on('click', '.btnEditar', function(){
    opcion = 2;

    if(tablaInsumos.row(this).child.isShown()){
        var data = tablaInsumos.row(this).data();
    }else{
        var data = tablaInsumos.row($(this).parents("tr")).data();
    }

    id = data['id_insumo'];

    tituloModal.innerHTML = "Modificando Insumo";
    btnFormInsumos.innerText = "Guardar cambios";

    $("#nombre").val(data['nombre']);
    $("#stock_min").val(data['stock_min']);
    $("#stock_max").val(data['stock_max']);
    $("#unidad_medida").val(data['um']);

    $("#modalInsumos").modal('show');
});

$(document).on('click', '.btnBorrar', async function(){

    if(tablaInsumos.row(this).child.isShown()){
        var data = tablaInsumos.row(this).data();
    }else{
        var data = tablaInsumos.row($(this).parents("tr")).data();
    }

    const result = await Swal.fire({
        title: '¿ESTA SEGURO DE ELIMINAR ESTE INSUMO?',
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
        datos.append('id', data['id_insumo']);

        let peticion = await fetch('controllers/Insumo_controller.php', {
            method : 'POST',
            body : datos
        });

        let resjson = await peticion.json();

        if(resjson.respuesta === "OK"){
            notificacionExitosa('Eliminación exitosa');
            tablaInsumos.ajax.reload(null,false);
        }else{
            notifacarError(resjson.respuesta);
        }
    }

});

function notifacarError(mensaje){
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