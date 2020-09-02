// Tabla de los productos
var tablaProductos;

// Select de categoria
var selectCategoria = document.getElementById('selectCategoria');

// Boton form del modal de productos
var formProducto = document.getElementById('formProducto');

// Boton agregar producto
var btnAgregarProducto = document.getElementById('btnAgregarProducto');

// Titulo del modal
var tituloModal = document.getElementById('tituloModal');

// Boton form del modal
var btnFormProducto = document.getElementById('btnFormProducto');

// Variable opcion, insert => 1, update 2
var opcion;

// Id del producto
var id;

function init(){
    tablaProductos = $("#tablaProductos").DataTable({
        "responsive": true,
        "autoWidth" : false,
        "ajax" : {
            "url" : "controllers/Producto_controller.php",
            "type": "POST",
            "data": {
                "select" : "OK"
            },
            "dataSrc":""
        },
        "columns" :[
            {"data" : "id_producto", "visible" : false},
            {"data" : "nombre"},
            {"data" : "categoria", "visible" : false},
            {"data" : "stock"},
            {"data" : "stock_min"},
            {"data" : "stock_max"},
            {"data" : "precio_venta"},
            {"data" : "observaciones"},
            {"data" : "status", "visible" : false},
            {"data" : "descripcion"},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='fas fa-trash-alt'></i></button></div></div>"}
        ]
    });

    $.ajax({
        "url" : "controllers/Categoria_controller.php",
        "dataType" : 'json',
        "type": "POST",
        "data": {
            "select" : "OK"
        },
        success: function (data, textStatus, jqXHR) {
            
            for( let item of data ){
                let option = document.createElement("option");
                option.text = item.descripcion;
                option.value = item.id_categoria;
                selectCategoria.appendChild(option);     
            }  
            
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus);
        }
    });
}

init();

formProducto.addEventListener('submit', async (e) => {
    e.preventDefault();

    // Filtro para verificar que selecciono una categoria
    if(selectCategoria.value == "default"){
        notifacionError("Selecciona una cateogoria!");
    }else{

        let mensaje = "";

        // Preparemos los datos
        let datosProducto = new FormData(formProducto);
        if(opcion == 1){
            datosProducto.append('insert', 'OK');
            mensaje = "Registro de producto exitoso!";
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
                let peticion = await fetch('controllers/Producto_controller.php',{
                    method : 'POST',
                    body : datosProducto
                });

                let resjson = await peticion.json();

                if(resjson.respuesta === "OK"){
                    $("#modalProductos").modal('hide');
                    notificacionExitosa(mensaje);
                    tablaProductos.ajax.reload(null,false);
                }else{
                    notifacionError(resjson.respuesta);
                }

            } catch (error) {
                console.log(error);
            }
        }
    }
})

btnAgregarProducto.addEventListener('click', ()=>{
    formProducto.reset();
    opcion = 1;
    tituloModal.innerHTML = "Alta de Producto";
    btnFormProducto.innerText = "Guardar";
});

$(document).on('click', '.btnEditar', function(){
    opcion = 2;

    if(tablaProductos.row(this).child.isShown()){
        var data = tablaProductos.row(this).data();
    }else{
        var data = tablaProductos.row($(this).parents("tr")).data();
    }

    id = data['id_producto'];

    tituloModal.innerHTML = "Modificando Producto";
    btnFormProducto.innerText = "Guardar cambios";

    selectCategoria.value = data['categoria'];
    $("#nombre").val(data['nombre']);
    $("#stock").val(data['stock']);
    $("#stock_min").val(data['stock_min']);
    $("#stock_max").val(data['stock_max']);
    $("#precio_venta").val(data['precio_venta']);
    $("#observaciones").val(data['observaciones']);

    $("#modalProductos").modal('show');
});

$(document).on('click', '.btnBorrar', async function(){

    if(tablaProductos.row(this).child.isShown()){
        var data = tablaProductos.row(this).data();
    }else{
        var data = tablaProductos.row($(this).parents("tr")).data();
    }

    const result = await Swal.fire({
        title: '¿ESTA SEGURO DE ELIMINAR ESTE PRODUCTO?',
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
        datos.append('id', data['id_producto']);

        let peticion = await fetch('controllers/Producto_controller.php', {
            method : 'POST',
            body : datos
        });

        let resjson = await peticion.json();

        if(resjson.respuesta === "OK"){
            notificacionExitosa('Eliminación exitosa');
            tablaProductos.ajax.reload(null,false);
        }else{
            notificarError(resjson.respuesta);
        }
    }

});

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
        
    });
}