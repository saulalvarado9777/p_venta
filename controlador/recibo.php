<?php
    require_once ('../vendor/autoload.php');
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML('<p>Your first taste of creating PDF from HTML</p>');
    $mpdf->Output();
?>