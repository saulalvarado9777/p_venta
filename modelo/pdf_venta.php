<?php
include_once 'venta.php';
include_once 'ventaproducto.php';
include_once 'cliente.php';
function getHtml($id_venta)
{
    $venta= new venta();//intancia del modelo venta
    $venta_producto = new ventaProducto();//intancia dle modelo venta producto
    $cliente= new cliente();
    $venta->buscar_id($id_venta);
    $venta_producto->ver($id_venta);
    $plantilla='
    <body>
        <header class="clearfix">
            <div id="logo">
                <img src="../img/logo.jpeg" width="60" height="60">
            </div>
            <h1>COMPROBANTE DE PAGO</h1>
            <div id="company" class="clearfix">
                <div id="negocio">Venta e instalacón de tablaroca</div>
                <div>Tel:(728) 281-2785</div>
                <div><a href="#">Correo:jusseldm@gmail.com</a></div>
            </div>';
            foreach ($venta->objetos as $objeto) {
                if(empty($objeto->fk_cliente))//si el campo fk:cliente esta vacio
                {
                    $cliente_nombre=$objeto->cliente;//colocamos el nombre del cliente almacenado en la tabla de ventas
                }
                else
                {
                    $cliente->buscar_datos_cliente($objeto->fk_cliente);
                    foreach ($cliente->objetos as $cli) {
                        $cliente_nombre=$cli->nombre;
                    }
                
                }
            $plantilla.='
            
            <div id="project">
                <div><span>Codigo de Venta: </span>'.$objeto->id_ventas.'</div>
                <div><span>Cliente: </span>'.$cliente_nombre.'</div>
                <div><span>Fecha y Hora: </span>'.$objeto->fecha.'</div>
                <div><span>Vendedor: </span>'.$objeto->vendedor.'</div>
            </div>';
            }
            $plantilla.='
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
                <tbody>';
                foreach ($venta_producto->objetos as $objeto) {
                
                $plantilla.='
                <tr>    
                    <td class="servic_producto">'.$objeto->producto.'</td>
                    <td class="servic">'.$objeto->unidad.'</td>
                    <td class="servic">'.$objeto->categoria.'</td>
                    <td class="servic">'.$objeto->cantidad.'</td>
                    <td class="servic">$'.$objeto->pre_out.'</td>
                    <td class="servic">$'.$objeto->subtotal.'</td>
                </tr>';
                }
                $calculos= new venta();
                $calculos->buscar_id($id_venta);
                foreach ($calculos->objetos as $objeto) {
                $igv=$objeto->total*0.18;
                $sub=$objeto->total-$igv;
                
                $plantilla.='
                <tr>
                    <td colspan="8" class="grand total">SUBTOTAL</td>
                    <td class="grand total">$'.$sub.'</td>
                </tr>
                <tr>
                    <td colspan="8" class="grand total">IVA(16%)</td>
                    <td class="grand total">$'.$igv.'</td>
                </tr>
                <tr>
                    <td colspan="8" class="grand total">TOTAL</td>
                    <td class="grand total">$'.$objeto->total.'</td>
                </tr>';

                }
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
    return $plantilla;
}
?>