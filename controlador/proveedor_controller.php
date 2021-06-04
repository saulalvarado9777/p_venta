<?php
include_once '../modelo/proveedor.php';
$proveedor= new proveedor(); // instanciamos un objeto de la clase proveedor
if($_POST['funcion']=='crear')
{
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $proveedor->crear($nombre,$telefono,$correo,$direccion);
}
if($_POST['funcion']=='buscar')
{
    $proveedor->buscar();
    $json=array();
    foreach($proveedor->objetos as $objeto)
    {
        $json[]=array(
            'id'=>$objeto->id_proveedor,
            'nombre'=>$objeto->nombre,
            'telefono'=>$objeto->telefono,
            'correo'=>$objeto->correo,
            'direccion'=>$objeto->direccion,
        );
    }
    $jsonstring=json_encode($json);
    echo $jsonstring;
}

if($_POST['funcion']=='borrar')
{
    $id=$_POST['id'];
    $proveedor->borrar($id);
}
if($_POST['funcion']=='editar')
{   
        $id =$_POST['id'];
        $nombre = $_POST['nombre'];//hace el post hacia el archivo productos js la variables del post deben de ser iguales 
        $telefono = $_POST['telefono'];//a la del archivo js
        $correo = $_POST['correo'];
        $direccion = $_POST['direccion'];
        $proveedor->editar($id,$nombre,$telefono,$correo,$direccion);//hacemos la llamada a la funcion crear con lo parametrod del post
}
if($_POST['funcion']=='llenar_proveedores')
{
    $proveedor->llenar_proveedores();
    $json=array();
    foreach ($proveedor->objetos as $objeto)
    {
        $json[] = array(
            'id'=>$objeto->id_proveedor,
            'nombre'=>$objeto->nombre,
            
        );
    }
    $jsonstring=json_encode($json);
    echo $jsonstring;
}
?>