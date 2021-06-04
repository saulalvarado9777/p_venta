<?php
require_once ('../vendor/autoload.php');
$html='<p>hola quetal como estas</p>
';
$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);//para enviar la estrctura html
$mpdf->Output("../pdf/pdf-5.pdf","F");
?>