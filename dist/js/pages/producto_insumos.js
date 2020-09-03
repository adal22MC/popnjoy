const guardadCambios = document.getElementById('guardarCambios');

const selectProducto = document.getElementById('selectProducto');

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
                console.log(data)
                
                for (let item of data) {
                    insumos.push({
                        producto: item.producto,
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