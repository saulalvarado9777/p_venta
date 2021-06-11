<?php
    require_once ('../vendor/autoload.php');
    require_once ('../modelo/pdf_venta.php');
    $id_venta=$_POST['id'];
    $html=getHtml($id_venta);
    $css=file_get_contents("../css/pdf.css");
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);//PARA ENVIAR EL CSS AL ARCHIVO PDF
    $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);//para enviar la estrctura html
    $mpdf->Output("../pdf_venta/pdf-".$id_venta.".pdf","F");

?> 