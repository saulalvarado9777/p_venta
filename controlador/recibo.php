<?php
    require_once ('../vendor/autoload.php');
    $mpdf = new \Mpdf\Mpdf([

    ]);
    $mpdf->writeHTML("Hola mundo", \Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output();//genera el pdf
?>