var tablaCierres;

function init(){
    tablaCierres = $("#tablaCierres").DataTable({
        "responsive": true,
        "autoWidth" : false,
        "ajax" : {
            "url" : "controllers/Cierre_controller.php",
            "type": "POST",
            "data": {
                "select" : "OK"
            },
            "dataSrc":""
        },
        "columns" :[
            {"data" : "id_cd"},
            {"data" : "fecha"},
            {"data" : "hora"},
            {"data" : "total_vendido"},
            {"data" : "total_costo"},
            {"data" : "ganancia"},
            {"data" : "estado", "visible" : false},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-danger btn-sm btnBorrar'><i class='fas fa-file-pdf'></i></button></div></div>"}
        ]
    });

}

init();