<?php
include_once '../modelo/categoria.php';//incluimos la clase laboratorio
$categoria= new categoria(); //instanciamos un objeto de la clase laboratorio
if($_POST['funcion']=='crear')
{
        $nombre = $_POST['nombre_categoria'];/*estos debes de ser igualal documento js */
        $categoria->crear($nombre);
}
if($_POST['funcion']=='buscar')
{
        $categoria->buscar();
        $json=array();
        foreach ($categoria->objetos as $objeto)
        {
            $json[] = array(
                'id'=>$objeto->id_categoria,
                'nombre'=>$objeto->nombre,              
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
}
if($_POST['funcion']=='borrar')
{
    $id=$_POST['id'];
    $categoria->borrar($id);
}
if($_POST['funcion']=='editar')
{
        $nombre = $_POST['nombre_categoria'];
        $id_editado =$_POST['id_editado'];
        $categoria->editar($nombre,$id_editado);
}

if($_POST['funcion']=='llenar_categorias')
{
    $categoria->llenar_categorias();
    $json=array();
    foreach ($categoria->objetos as $objeto)
    {
        $json[] = array(
            'id'=>$objeto->id_categoria,
            'nombre'=>$objeto->nombre,
            
        );
    }
    $jsonstring=json_encode($json);
    echo $jsonstring;
}
?>
