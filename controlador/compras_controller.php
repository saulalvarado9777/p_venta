<?php
include_once '../modelo/compras.php';//incluimos la clase cata$catalogo
include_once '../modelo/stock.php';//incluimos la clase cata$catalogo

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

?>