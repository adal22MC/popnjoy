const guardadCambios = document.getElementById('guardarCambios');

const selectProducto = document.getElementById('selectProducto');

const guardarCambios = document.getElementById('guardarCambios');

/* Guardamos todos los insumos que ocupa un producto */
var insumos = [];

// Tabla insumos
var tablaInsumos;

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
            {"data" : "stock", "visible" : false},
            {"data" : "stock_min", "visible" : false},
            {"data" : "stock_max", "visible" : false},
            {"data" : "um"},
            {"data" : "status", "visible" : false},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnAddInsumo'><i class='fas fa-reply'></i></button></div></div>"}
        ]
    });

    $.ajax({
        "url" : "controllers/Producto_controller.php",
        "dataType" : 'json',
        "type": "POST",
        "data": {
            "select" : "OK"
        },
        success: function (data, textStatus, jqXHR) {

            for( let item of data ){
                let option = document.createElement("option");
                option.text = item.nombre;
                option.value = item.id_producto;
                selectProducto.appendChild(option);     
            }  
            
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus);
        }
    });
}

init();

selectProducto.addEventListener('change', function(){
    deleteRows();
    if(selectProducto.value != "default"){
        $.ajax({
            "url" : "controllers/Producto_Insumos_controller.php",
            "dataType" : 'json',
            "type": "POST",
            "data": {
                "selectInsumos" : "OK",
                "id" : selectProducto.value
            },
            success: function (data, textStatus, jqXHR) {
                
                for (let item of data) {
                    insumos.push({
                        insumo : item.id_insumo,
                        cantidad : item.cantidad
                    });
    
                    $('#tablaProductosInsumos').find('tbody').append(`
                        <tr>
                            <td>
                                <button class="btn btn-sm btn-danger">
                                    <i id="${item.id_insumo}" class="fas fa-trash btnEliminar"></i>
                                </button>
                            </td>
                            <td>${item.nombre}</td>
                            <td>${item.cantidad}</td>
                        </tr>
                    `);
                }
                
                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });
    }
});

$(document).on('click', '.btnEliminar', function(e){
    e.target.parentNode.parentNode.parentNode.remove();
    deleteInsumo(e.target.id);
    console.log(insumos);
});

$(document).on('click', '.btnAddInsumo', function(){

    if(tablaInsumos.row(this).child.isShown()){
        var data = tablaInsumos.row(this).data();
    }else{
        var data = tablaInsumos.row($(this).parents("tr")).data();
    }

    if(selectProducto.value === "default"){
        notificarError('Selecciona un producto');
    }else if(verificarInsumoRepetido(data['id_insumo']) == false){
        notificarError('El insumo ya se encuentra en la lista');
    }else{
        Swal.fire({
            title: 'Ingresa la cantidad que se utilizara por producto',
            input: 'number',
            inputAttributes: {
              autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
        }).then( cantidad => {
            if(cantidad.value){
                
                if(cantidad.value <= 0){
                    notificarError('Ingresa una cantidad valida')
                }else{

                    $('#tablaProductosInsumos').find('tbody').append(`
                        <tr>
                            <td>
                                <button class="btn btn-sm btn-danger">
                                    <i id="${data['id_insumo']}" class="fas fa-trash btnEliminar"></i>
                                </button>
                            </td>
                            <td>${data['nombre']}</td>
                            <td>${cantidad.value}</td>
                        </tr>
                    `);

                    // Agregamos el insumo a nuestro objeto
                    insumos.push({
                        insumo : data['id_insumo'],
                        cantidad : cantidad.value
                    });

                    console.log(insumos);

                }
            }
        });
    }
    


})

guardarCambios.addEventListener('click', function(){
    if(selectProducto.value == "default"){
        notificarError('Selecciona un producto')
    }else{
        limpiarInsumos();
        console.log(insumos)
        $.ajax({
            url : "controllers/Producto_Insumos_controller.php",
            type : "POST",
            data : {
                "insumos" : insumos
            },
            dataType : 'json',
            success : function(respuesta){
                
                if(respuesta.respuesta == "OK"){
                    notificacionExitosa('Modificación exitosa!');
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
    }
    
});

function limpiarInsumos(){
    let insumosTemporal = [];
    for(let item of insumos){
        if(item != undefined){
            insumosTemporal.push({
                insumo : item.insumo,
                cantidad : item.cantidad
            });
        }
    }

    insumos = insumosTemporal;
    insumos.unshift({
        producto : selectProducto.value
    });

}

function verificarInsumoRepetido(id){
    for(let item of insumos){
        if(item != undefined){
            if(parseInt(item.insumo) === parseInt(id)){
                return false;
            }
        }
    }
    return true;
}

function deleteInsumo(id){

    let pos = 0;
    for(let item of insumos){
        if(item != undefined){
            if(parseInt(item.insumo) === parseInt(id)){
                delete insumos[pos];
            }
        }
        pos++;
    }

}

function deleteRows() {
    $("#tablaProductosInsumos tbody").children().remove();
    insumos = [];
}

function notificarError(mensaje){
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
        selectProducto.value = "default";
        insumos = [];
        deleteRows();
    });
}