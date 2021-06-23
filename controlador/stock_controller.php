<?php
include_once '../modelo/stock.php';
$lote= new lote(); // instanciamos un objeto de la clase proveedor
if($_POST['funcion']=='crear')
{
    $id_producto= $_POST['id_producto'];
    $proveedor = $_POST['proveedor'];
    $stock = $_POST['stock'];
    $lote->crear($id_producto,$proveedor,$stock);
}
  
/////////////////////////////////////////////actualizaciones/////////////////////////////////////////////////////////////////////////////
if($_POST['funcion']=='ver')
{
    $id = $_POST['id'];
    $lote->ver($id);
    $contador=0;
    $json=array();
    foreach ($lote->objetos as $objeto) {
        # code...
        $contador++;
        $json[]=array(
            'numeracion'=>$contador,
            'codigo'=>$objeto->codigo,
            'cantidad'=>$objeto->cantidad,
            'precio_compra'=>$objeto->precio_compra,
            'producto'=>$objeto->producto,
            'categoria'=>$objeto->categoria,
        );
    }
    $jsonstring= json_encode($json);
    echo $jsonstring;
}
if($_POST['funcion']=='buscar')
{
    $lote->buscar();
    $json=array();
    foreach($lote->objetos as $objeto)
    {
        $json[]=array(
            'id'=>$objeto->id_lote,
            'codigo'=>$objeto->codigo,
            'nombre'=>$objeto->prod_nombre,
            'proveedor'=>$objeto->prov_nombre,
            'stock'=>$objeto->cantidad_lote,
            /*'categoria'=>$objeto->cat_nombre,
            'fecha'=>$objeto->fecha,*/
            
        );
    }
    $jsonstring=json_encode($json);
    echo $jsonstring;
}
if($_POST['funcion']=='editar')
{
    $id_lote= $_POST['id'];
    $stock = $_POST['stock'];
    $lote->editar($id_lote,$stock);
} 
if($_POST['funcion']=='borrar')
{
    $id = $_POST['id'];
    $lote->borrar($id);
}
?> 