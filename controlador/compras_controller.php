<?php
include_once '../modelo/compras.php';//incluimos la clase cata$catalogo
include_once '../modelo/stock.php';//incluimos la clase cata$catalogo
require_once ('../vendor/autoload.php');

$lote=new lote();
$compras= new compras(); //instanciamos un objeto de la clase cata$catalogo

if($_POST['funcion']=='registrar_compra')
{
    $descripcion= json_decode($_POST['descripcion_String']);
    $productos= json_decode($_POST['productos_String']);
    $compras->crear($descripcion->codigo,$descripcion->fecha_compra,$descripcion->fecha_entrega,$descripcion->total,$descripcion->estado,$descripcion->proveedor);
    $compras->ultima_compra();
    foreach ($compras->objetos as $objeto) {
        $id_compra=$objeto->ultima_compra;
    }
    foreach ($productos as $prod) {
        # code...
        $lote->crear_lote($prod->codigo,$prod->cantidad,$prod->precio_compra,$id_compra,$prod->id);
    }
    //echo 'add';
}
if($_POST['funcion']=='listar_compras')
{
    $compras->listar_compras();
    $contador=0;
    foreach ($compras->objetos as $objeto) {
        # code...
        $contador++;
        $json[]=array(
            'numeracion'=>$contador,
            'codigo'=>$objeto->codigo,
            'fecha_compra'=>$objeto->fecha_compra,
            'fecha_entrega'=>$objeto->fecha_entrega,
            'total'=>$objeto->total,
            'estado'=>$objeto->estado,
            'proveedor'=>$objeto->proveedor,
        );
    }
    $jsonstring= json_encode($json);
    echo $jsonstring;
}
if($_POST['funcion']=='editar_estado')
{    $id_compra=$_POST['id_compra'];
    $id_estado=$_POST['id_estado'];
    $compras->editar_estado($id_compra,$id_estado);
    echo 'edit';
}
if($_POST['funcion']=='imprimir')
{ 
    $contador=0;
    $id_compra=$_POST['id'];
    $compras->obtenerdatos($id_compra);
    foreach ($compras->objetos as $objeto) {
            $codigo=$objeto->codigo;
            $fecha_compra=$objeto->fecha_compra;
            $fecha_entrega=$objeto->fecha_entrega;
            $total=$objeto->total;
            $estado=$objeto->estado;
            $proveedor=$objeto->proveedor;
            $telefono=$objeto->telefono;
            $correo=$objeto->correo;
            $direccion=$objeto->direccion;
    }
    $lote->ver($id_compra);
    $plantilla='
    <body>
        <header class="clearfix">
            <div id="logo">
                <img src="../img/logo.jpeg" width="60" height="60">
            </div>
            <h1>COMPRA</h1>
            <div id="company" class="clearfix">
                <div>Proveedor:'.$proveedor.'</div>
                <div>Tel:'.$telefono.'</div>
                <div>Correo:'.$correo.'</div>
                <div>Dirección:'.$direccion.'</div>
            </div>';
            $plantilla.='
            <div id="project">
                <div><span>Codigo de compra: </span>'.$codigo.'</div>
                <div><span>fecha_compra: </span>'.$fecha_compra.'</div>
                <div><span>Fecha_entrega: </span>'.$fecha_entrega.'</div>
                <div><span>Estado: </span>'.$estado.'</div>
            </div>';
            $plantilla.='
        </header>
        <main>
            <table>
                <thead>
                <tr>
                    <th class="service">#</th>
                    <th class="service">Código</th>
                    <th class="service">Categoria</th>
                    <th class="service">Producto</th>
                    <th class="service">Cantidad</th>
                    <th class="service">Precio_compra</th>
                </tr>
                </thead>
                <tbody>';
                foreach ($lote->objetos as $objeto) {
                    $contador++;
                $plantilla.='
                <tr>    
                    <td class="servic_producto">'.$contador.'</td>
                    <td class="servic_producto">'.$objeto->codigo.'</td>
                    <td class="servic">'.$objeto->categoria.'</td>
                    <td class="servic">'.$objeto->producto.'</td>
                    <td class="servic">'.$objeto->cantidad.'</td>
                    <td class="servic">$'.$objeto->precio_compra.'</td>
                </tr>';
                }
                $iva=$total*0.16;
                $sub=$total-$iva;
                $plantilla.='
                <tr>
                    <td colspan="8" class="grand total">SUBTOTAL</td>
                    <td class="grand total">$'.$sub.'</td>
                </tr>
                <tr>
                    <td colspan="8" class="grand total">IVA(16%)</td>
                    <td class="grand total">$'.$iva.'</td>
                </tr>
                <tr>
                    <td colspan="8" class="grand total">TOTAL</td>
                    <td class="grand total">$'.$total.'</td>
                </tr>';
            $plantilla.='
                </tbody>
            </table>
        </main>
        <div id="notices">
            <div class="notice">FORMA DE PAGO: EFECTIVO</div>
            <div class="notice">Salida la mercancia no se aceptan devoluciones</div>
            <div class="notice">NOTA: TODA ENTREGA DE MERCANCIA SE REALIZARÁ A PIE DE VEHICULO, LIBRE DE MANIOBRAS</div>
            <div class="notice">Por favor de realizar su deposito a nombre de: jussel Alvarado Castañeda Banamex Suc. 7009  Cta. 1874189  Cta. Int. 00 24 38 70 09 18 74 18 97</div>
            <div class="notice">Si el producto esta dañado o abierto, la devolucion no procedera.</div>
            <div class="notice">Revise su cambio antes de salir del establecimiento.</div>
        </div>
        <footer>
            Av. Del departamento del distrito federal s/n, Sta.Maria Atarasquillo, Lerma, Estado México.
        </footer>
    </body>';
    
    $css=file_get_contents("../css/pdf.css");
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);//PARA ENVIAR EL CSS AL ARCHIVO PDF
    $mpdf->WriteHTML($plantilla, \Mpdf\HTMLParserMode::HTML_BODY);//para enviar la estrctura html
    $mpdf->Output("../pdf_compra/pdf-compra-".$id_compra.".pdf","F");
    
}

?>