var formCategoria = document.getElementById('formCategorias');

var tablaCategorias;

// Titulo del modal
var tituloModal = document.getElementById('modalTitulo');

// Boton agregar categoria
var btnAgregarCategoria = document.getElementById('agregarCategoria');

// Boton form del modal cateogira
var btnFormCategoria = document.getElementById('btnFormCategoria');

// Variable opcioón para saber si sera un insert o update
var opcion; // 1 insert, 2 update

// Variable en la que se guarda el id de la categoria
var id;

async function init(){

    tablaCategorias = $("#tablaCategorias").DataTable({
        "responsive": true,
        "autoWidth" : false,
        "ajax" : {
            "url" : "controllers/Categoria_controller.php",
            "type": "POST",
            "data": {
                "select" : "OK"
            },
            "dataSrc":""
        },
        "columns" :[
            {"data" : "id_categoria"},
            {"data" : "descripcion"},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='fas fa-trash-alt'></i></button></div></div>"}
        ]
    });

}

init();

formCategoria.addEventListener('submit',async function(e){
    e.preventDefault();

    let accion;
    let mensaje;

    if(opcion == 1){
        accion = "insert";
        mensaje = "Registro exitoso";
    }else if(opcion == 2){
        accion = "update";
        mensaje = "Modificación exitosa";
    }

    let datos = new FormData(formCategoria);
    datos.append(accion,'OK');
    datos.append('id', id);

    let peticion = await fetch('controllers/Categoria_controller.php', {
        method : 'POST',
        body : datos
    });

    let resjson = await peticion.json();

    console.log(resjson);
    if(resjson.respuesta === "OK"){
        $("#modalCategorias").modal('hide');
        notificacionExitosa(mensaje);
    }else{
        notificarError(resjson.respuesta);
    }

});

btnAgregarCategoria.addEventListener('click', () => {

    opcion = 1;

    tituloModal.innerText = "Creación de una nueva categoria";
    btnFormCategoria.innerText = "Guardar";
    formCategoria.reset();

});

$(document).on('click', '.btnEditar', function(){

    opcion = 2;

    if(tablaCategorias.row(this).child.isShown()){
        var data = tablaCategorias.row(this).data();
    }else{
        var data = tablaCategorias.row($(this).parents("tr")).data();
    }

    id = data['id_categoria'];

    tituloModal.innerHTML = "Modificando categoria";
    $("#descripcion").val(data['descripcion']);
    btnFormCategoria.innerText = "Guardar cambios";

    $("#modalCategorias").modal('show');
});

$(document).on('click', '.btnBorrar', async function(){

    if(tablaCategorias.row(this).child.isShown()){
        var data = tablaCategorias.row(this).data();
    }else{
        var data = tablaCategorias.row($(this).parents("tr")).data();
    }

    const result = await Swal.fire({
        title: '¿ESTA SEGURO DE ELIMINAR LA CATEGORIA?',
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
        datos.append('id', data['id_categoria']);

        let peticion = await fetch('controllers/Categoria_controller.php', {
            method : 'POST',
            body : datos
        });

        let resjson = await peticion.json();

        if(resjson.respuesta === "OK"){
            notificacionExitosa('Eliminación exitosa');
        }else{
            notificarError(resjson.respuesta);
        }
    }

});

function notificacionExitosa(mensaje){
    Swal.fire(
        mensaje,
        '',
        'success'
    ).then(r => {
        tablaCategorias.ajax.reload(null,false);
    });
}

function notificarError(mensaje){
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    })
}



