var tablaVentas;

function init(){
    tablaVentas = $("#tablaVentas").DataTable({
        "responsive": true,
        "autoWidth" : false,
        "ajax" : {
            "url" : "controllers/Venta_controller.php",
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
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='fas fa-trash-alt'></i></button><button class='btn btn-success btn-sm btnAgregarStock'><i class='fas fa-arrow-alt-circle-up'></i></button><button class='btn btn-danger btn-sm btnBajarStock'><i class='fas fa-arrow-alt-circle-down'></i></button></div></div>"}
        ]
    });
}


$('.tableHistorialClientes').on('click', '.btnPDF', (e) => {
    //window.location = "plantilla_pdf.php?idVenta="+e.target.id;
})