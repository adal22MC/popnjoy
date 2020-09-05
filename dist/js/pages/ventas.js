const procesarVenta = document.getElementById('procesarVenta');
const generarVenta = document.getElementById('formSeleccionarCliente');
const labelPagar = document.getElementById('labelTotal');

/* Guardamos los datos de los productos que se van a vender */
var productos = [];
var totalAPagar = 0;

var selectCliente = document.getElementById('selectCliente');

var tablaProductos;

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
            {"data" : "id_producto"},
            {"data" : "nombre"},
            {"data" : "categoria", "visible" : false},
            {"data" : "stock"},
            {"data" : "stock_min", "visible" : false},
            {"data" : "stock_max", "visible" : false},
            {"data" : "precio_venta"},
            {"data" : "observaciones", "visible" : false},
            {"data" : "status", "visible" : false},
            {"data" : "descripcion", "visible" : false},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnComprar'><i class='fas fa-reply'></i></button></div></div>"}
        ]
    });

    $.ajax({
        "url" : "controllers/Cliente_controller.php",
        "dataType" : 'json',
        "type": "POST",
        "data": {
            "select" : "OK"
        },
        success: function (data, textStatus, jqXHR) {
            
            for( let item of data ){
                let option = document.createElement("option");
                option.text = item.nombre;
                option.value = item.id;
                selectCliente.appendChild(option);     
            }  
            
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus);
        }
    });
}

init();

$(document).on('click', '.btnComprar', function(){

    if(tablaProductos.row(this).child.isShown()){
        var data = tablaProductos.row(this).data();
    }else{
        var data = tablaProductos.row($(this).parents("tr")).data();
    }

    if( validarProductoRepetido(data['id_producto']) == false ){
        notificarError('Este producto ya se encuentra en la lista');
    }else{

        Swal.fire({
            title: 'Cantidad',
            input: 'number',
            inputAttributes: {
            autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
        }).then( cantidad => {
            if(cantidad.value){
                
                if(cantidad.value <= 0){
                    notificarError('Ingresa una cantidad valida');
                }else if(cantidad.value > data['stock']){
                    notificarError('No hay suficiente stock');
                }else {
                    let total = cantidad.value * parseFloat(data['precio_venta']);
                    
                    $('#tableListaProductos').find('tbody').append(`
                        <tr>
                            <td>
                                <button class="btn btn-sm btn-danger">
                                    <i id="${data['id_producto']}" class="fas fa-trash btnEliminar"></i>
                                </button>
                            </td>
                            <td>${data['nombre']}</td>
                            <td>${cantidad.value}</td>
                            <td>${total}</td>
                        </tr>
                    `);

                    // Agregamos el producto a nuestro objeto productos
                    productos.push({
                        producto : data['id_producto'],
                        cantidad : cantidad.value,
                        total 
                    });

                    totalAPagar = totalAPagar + total;
                    labelPagar.innerText = "Total a pagar : " + totalAPagar;

                }
            }
        });
    }

});

$(document).on('click', '.btnEliminar', function(e){
    e.target.parentNode.parentNode.parentNode.remove();
    deleteProducto(e.target.id);
});

procesarVenta.addEventListener('click', function(){
    let ban = validarListaVacia();
    if(ban > 0){
        limpiarLista();
        $("#modalSeleccionarCliente").modal('show');
    }
});

generarVenta.addEventListener('submit', (e)=>{
    e.preventDefault();
    if(selectCliente.value != "default"){
        productos.unshift({
            cliente : selectCliente.value
        });

        $.ajax({
            "url" : "controllers/Venta_controller.php",
            "dataType" : 'json',
            "type": "POST",
            "data": {
                "generarVenta" : productos
            },
            success: function (data, textStatus, jqXHR) {
                
                if(data.respuesta == "OK"){
                    tablaProductos.ajax.reload(null,false);
                    notificacionExitosa('Venta generada');
                }else{
                    notificarError(data.respuesta);
                }
                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });
    }else{
        notificarError('Selecciona un cliente');
    }
})

function limpiarLista(){
    let productosTemporal = [];
    for(let item of productos){
        if(item != undefined){
            productosTemporal.push({
                producto : item.producto,
                cantidad : item.cantidad,
                total : item.total
            });
        }
    }

    productos = productosTemporal;
    console.log(productos);
}

function validarListaVacia(){
    let contador = 0;
    for(let item of productos){
        if(item != undefined){
            contador++;
        }
    }
    return contador;
}

function deleteProducto(id){
    let pos = 0;
    for(let item of productos){
        if(item != undefined){
            if(parseInt(item.producto) == parseInt(id) ){
                delete productos[pos];
                totalAPagar = totalAPagar - item.total;
                labelPagar.innerText = "Total a pagar : " + totalAPagar;
                return 0;
            }
        }
        pos++;
    }
}

function validarProductoRepetido(id){
    for(let item of productos){
        if(item != undefined){
            if(parseInt(item.producto) == parseInt(id) ){
                return false;
            }
        }
    }
    return true;
}

function deleteRows() {
    $("#tableListaProductos tbody").children().remove();
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
        $("#modalSeleccionarCliente").modal('hide');
        productos = [];
        deleteRows();
        totalAPagar = 0;
        labelPagar.innerText = "Total a pagar : " + totalAPagar;
    });
}

