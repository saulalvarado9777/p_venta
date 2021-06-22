<?php
include_once '../modelo/estado.php';//incluimos la clase producto
$estado = new estado();
if($_POST['funcion']=='obtener_estado')
    {
        $estado->obtener_estado();
        $json=array();
        foreach ($estado->objetos as $objeto)
        {
            $json[] = array(
                'id'=>$objeto->id_pago,
                'nombre'=>$objeto->nombre,
            );
        }
        $jsonstring=json_encode($json);
        echo $jsonstring;
    }
?>