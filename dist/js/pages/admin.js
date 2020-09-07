$(document).on('click', '.btnfechas', function(){
    var fecha = $('#Date').val();
    var fecha2 = $('#Date2').val();

    window.location = "pdf_venta.php?fechaInicial="+fecha+"&fechaFinal="+fecha2;
});