<?php
include_once '../modelo/catalogo.php';//incluimos la clase cata$catalogo
$catalogo= new catalogo(); //instanciamos un objeto de la clase cata$catalogo


if($_POST['funcion']=='buscar')
{
    $catalogo->buscar(); //instaniamos productos y llamamos a la funcion buscar
    $json=array();
    foreach($catalogo->objetos as $objeto)
    {
        
        $catalogo->obtener_stock($objeto->id_productos);
        foreach($catalogo->objetos as $obj)
        {
            $total = $obj->total; 
        }

        $json[]=array(
            'id'=>$objeto->id_productos,
            'nombre'=>$objeto->nombre,
            'inventario_min'=>$objeto->inv_min,
            'precio_in'=>$objeto->pre_in,
            'precio_out'=>$objeto->pre_out,
            'stock'=>$total,
            'presentacion'=>$objeto->presentacion,
            'unidad'=>$objeto->unidad,
            'categoria'=>$objeto->categoria,
            'categoria_id'=>$objeto->fk_categoria,
       );
        
    }
    $jsonstring=json_encode($json);
    echo $jsonstring;
}

?>