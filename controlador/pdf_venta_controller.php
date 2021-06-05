<?php
require_once ('../vendor/autoload.php');
include_once '../modelo/venta.php';
include_once '../modelo/producto.php';//incluimos la clase producto
$producto= new producto(); //instanciamos un objeto de la clase producto
/*$productos=json_decode($_POST['productos']);//lista de productos
foreach ($productos as $resultado) {
    $producto->buscar_id($resultado->id);
    foreach ($producto->objetos as $objeto) {
        $html='<body>
        <header class="clearfix">
            <div id="logo">
                <img src="../img/logo.jpeg" width="60" height="60">
            </div>
            <h1>COMPROBANTE DE PAGO</h1>
            <div id="company" class="clearfix">
                <div id="negocio">Venta e instalacón de tablaroca</div>
                <div>Tel:(728) 281-2785</div>
                <div><a href="#">Correo:jusseldm@gmail.com</a></div>
            </div>
            <div id="project">
                <div><span>Codigo de Venta:</span></div>
                <div><span>Cliente: </span></div>
                <div><span>Fecha y Hora: </span></div>
                <div><span>Vendedor: </span></div>
            </div>
        </header>
        <main>
            <table>
                <thead>
                <tr>
                    <th class="service">Producto</th>
                    <th class="service">Unidad</th>
                    <th class="service">Categoria</th>
                    <th class="service">Cantidad</th>
                    <th class="service">Precio</th>
                    <th class="service">Subtotal</th>
                </tr>
                </thead>
                <tbody>
                    <tr>    
                        <td class="servic_producto">'.$objeto->nombre.'</td>
                        <td class="servic">'.$objeto->unidad.'</td>
                        <td class="servic">'.$objeto->categoria.'</td>
                        <td class="servic">'.$resultado->cantidad.'</td>
                        <td class="servic">$'.$resultado->precio.'</td>
                        <td class="servic">$</td>
                    </tr>
                    <tr>
                        <td colspan="8" class="grand total">SUBTOTAL</td>
                        <td class="grand total">$</td>
                    </tr>
                    <tr>
                        <td colspan="8" class="grand total">IVA(16%)</td>
                        <td class="grand total">$</td>
                    </tr>
                    <tr>
                        <td colspan="8" class="grand total">TOTAL</td>
                        <td class="grand total">$</td>
                    </tr>
                </tbody>
            </table>
            <div id="notices">
                <div>NOTICE:</div>
                <div class="notice">*Presentar este comprobante de pago para cualquier reclamo o devolucion.</div>
                <div class="notice">*El reclamo procedera dentro de las 24 horas de haber hecho la compra.</div>
                <div class="notice">*Si el producto esta dañado o abierto, la devolucion no procedera.</div>
                <div class="notice">*Revise su cambio antes de salir del establecimiento.</div>
            </div>
        </main>
        <footer>
            Av. Del departamento del distrito federal s/n, Sta.Maria Atarasquillo, Lerma, Estado México.
        </footer>
    </body>
        ';
    }
}*/
$productos=json_decode($_POST['productos']);//lista de prodiuctos
print_r($productos);
/*foreach ($productos as $resultado) {
    $producto->buscar_id($resultado->id);
    foreach ($producto->objetos as $objeto) {
        print_r($producto);
        $html='<h2>'.$objeto->nombre.'</h2>';
        //$html="<h2>'.$objeto->nombre.'</h2>";

    }
}*/
/*$css=file_get_contents("../css/pdf.css");
$id_venta=1;
$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);//PARA ENVIAR EL CSS AL ARCHIVO PDF
$mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);//para enviar la estrctura html
$mpdf->Output("../pdf_venta/pdf-".$id_venta.".pdf","F");*/

?> 