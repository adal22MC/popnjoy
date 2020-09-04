// Tabla de los productos
var tablaProductos;

// Select de categoria
var selectCategoria = document.getElementById('selectCategoria');

// Form del modal de productos
var formProducto = document.getElementById('formProducto');

// Form del modal agregar stock
var formStock = document.getElementById('formStock');

// Boton agregar producto
var btnAgregarProducto = document.getElementById('btnAgregarProducto');

// Titulo del modal
var tituloModal = document.getElementById('tituloModal');

// Titulo modal Stock
var tituloModalStock = document.getElementById('tituloModalStock');

// Texto del botont form modal stock
var btnFormStock = document.getElementById('btnFormStock');

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
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='fas fa-trash-alt'></i></button><button class='btn btn-success btn-sm btnAgregarStock'><i class='fas fa-arrow-alt-circle-up'></i></button><button class='btn btn-danger btn-sm btnBajarStock'><i class='fas fa-arrow-alt-circle-down'></i></button></div></div>"}
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
    tituloModal.innerHTML = "Creación de Producto";
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

$(document).on('click', '.btnAgregarStock', function(){

    opcion = 1;

    if(tablaProductos.row(this).child.isShown()){
        var data = tablaProductos.row(this).data();
    }else{
        var data = tablaProductos.row($(this).parents("tr")).data();
    }

    let razon_descuento = document.getElementById('entrada_razon_descuento');
    razon_descuento.setAttribute('style','display :none;');
    document.getElementById('razon').removeAttribute('required');

    let precio_compra = document.getElementById('entrada_precio_compra');
    precio_compra.removeAttribute('style');
    precio_compra.setAttribute('required', true);

    tituloModalStock.innerText = "Aumentando Stock";
    btnFormStock.innerText = "Aumentar Stock";

    id = data['id_producto'];
    formStock.reset();
    $("#modalStock").modal('show');
});

$(document).on('click', '.btnBajarStock', function(){

    opcion = 2;

    if(tablaProductos.row(this).child.isShown()){
        var data = tablaProductos.row(this).data();
    }else{
        var data = tablaProductos.row($(this).parents("tr")).data();
    }

    let razon_descuento = document.getElementById('entrada_razon_descuento');
    razon_descuento.removeAttribute('style');
    

    let precio_compra = document.getElementById('entrada_precio_compra');
    precio_compra.setAttribute('style', 'display : none;');
    document.getElementById('precio_compra').removeAttribute('required');

    tituloModalStock.innerText = "Descontando Stock";
    btnFormStock.innerText = "Descontar";

    id = data['id_producto'];
    formStock.reset();
    $("#modalStock").modal('show');
});


formStock.addEventListener('submit', async (e) => {
    e.preventDefault();
    try {

        // Preparemos los datos
        let datosProducto = new FormData(formStock);
        datosProducto.append('id', id);

        let mensaje = "";
        if(opcion == 1){
            datosProducto.append('addStock', 'OK');
            mensaje = "Operación exitosa, su stock a aumentado!"
        }else if(opcion == 2){
            datosProducto.append('subtractStock', 'OK');
            mensaje = "Operación exitosa, su stock a disminuido!"
        }
        

        let peticion = await fetch('controllers/Producto_controller.php',{
            method : 'POST',
            body : datosProducto
        });

        let resjson = await peticion.json();

        if(resjson.respuesta === "OK"){
            $("#modalStock").modal('hide');
            notificacionExitosa(mensaje);
            tablaProductos.ajax.reload(null,false);
        }else{
            notifacionError(resjson.respuesta);
        }

    } catch (error) {
        console.log(error);
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