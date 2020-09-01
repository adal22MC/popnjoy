$('.tableHistorialClientes').on('click', '.btnPDF', (e) => {
    window.location = "plantilla_pdf.php?idVenta="+e.target.id;
})