<?php
    include '../modelo/cliente.php';
    $cliente = new cliente ();
    if($_POST['funcion']=='crear')
    {
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $cliente->crear($nombre,$telefono,$correo);
    }
    if($_POST['funcion']=='buscar')
    {
        $cliente->buscar(); 
        $json=array();
        foreach($cliente->objetos as $objeto)
        {
            $json[]=array(
                'id'=>$objeto->id_cliente,
                'nombre'=>$objeto->nombre,
                'correo'=>$objeto->correo,
                'telefono'=>$objeto->telefono,
                //'direccion'=>$objeto->is_active,
            );
        }
        $jsonstring=json_encode($json);
        echo $jsonstring;
    }
    if($_POST['funcion']=='editar')
    {
        $id = $_POST['id'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $cliente->editar($id,$correo,$telefono);
    }
    if($_POST['funcion']=='borrar')
    {
        $id=$_POST['id'];
        $cliente->borrar($id);
    }
    if($_POST['funcion']=='obtener_clientes')
    {
        $cliente->obtener_clientes();
        $json=array();
        foreach ($cliente->objetos as $objeto)
        {
            $json[] = array(
                'id'=>$objeto->id_cliente,
                'nombre'=>$objeto->nombre,
            );
        }
        $jsonstring=json_encode($json);
        echo $jsonstring;
    }
?>