<?php

    require_once "models/Venta_model.php";
    require_once "models/Empresa_model.php";
    require_once "models/Cliente_model.php";
    require_once "vendor/autoload.php"; // Requirir DOM PDF
    session_start();

    if (!isset($_SESSION['usuario'])) {
        header("Location: ventas.php");
    }
   
    $Id;
    if (isset($_GET['id_venta'])) {
        $Id[0] = array("id" => $_GET['id_venta']);
    }else if(isset($_GET['fechaInicial'])){
        $Id = Venta_model::obtenerIdVentasFecha($_GET['fechaInicial'],$_GET['fechaFinal']);
    }

    use Dompdf\Dompdf;

    ob_start();
    include "pdf_maq_venta.php";
    $html = ob_get_clean();

    $pdf = new Dompdf();
    $pdf->load_html($html);

    $pdf->setPaper("A4");
    $pdf->render();

    $pdf->stream("Reporte Venta ");
