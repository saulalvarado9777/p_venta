<?php
include_once '../modelo/venta.php';
include_once '../modelo/cliente.php';// para poder utilizar funciones de otro modelo tenemos que agregar la ruta del archivo del modelo
//include_once '../modelo/conexion.php';//el include se usa cuando hay mas de un modelo en el controlador
$cliente= new cliente();//instanciomos un objeto de la clase cliente
$venta= new venta(); // instanciamos un objeto de la clase proveedor
session_start(); //activar las sesiones de los usuarios 
$id_usuario=$_SESSION['usuario'];
if($_POST['funcion']=='listar')
{
    $venta->buscar();
    $json=array();
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
        $json['data'][]=array(
            'id_ventas'=>$objeto->id_ventas,
            'fecha'=>$objeto->fecha,
            'cliente'=>$cliente_nombre,
            'vendedor'=>$objeto->vendedor,
            'total'=>$objeto->total,
        );
    }
    $jsonstring=json_encode($json);
    echo $jsonstring;
}
if($_POST['funcion']=='mostrar_consultas')
{  
    
    $venta->venta_dia_vendedor($id_usuario);
    foreach ($venta->objetos as $objeto) {
        $venta_dia_vendedor=$objeto->venta_dia_vendedor;//lo que traemos de la consulta lo almacena en la vatriable venta dia    
    }

    $venta->venta_diaria();
    foreach ($venta->objetos as $objeto) {
        $venta_diaria=$objeto->venta_diaria;//lo que traemos de la consulta lo almacena en la vatriable venta dia vendedor    
    }
    
    $venta->venta_mensual();
    foreach ($venta->objetos as $objeto) {
        $venta_mensual=$objeto->venta_mensual;//lo que traemos de la consulta lo almacena en la vatriable venta dia    
    }
    $venta->venta_anual();
    $json=array();
    foreach ($venta->objetos as $objeto) {
        $json[]= array(
            'venta_dia_vendedor'=>$venta_dia_vendedor,
            'venta_diaria'=>$venta_diaria,
            'venta_mensual'=>$venta_mensual,
            'venta_anual'=>$objeto->venta_anual,
        );
    }
    $jsonstring=json_encode($json[0]);
    echo $jsonstring;
}   
if($_POST['funcion']=='venta_mes')
{
    $venta->venta_mes();
    $json=array();
    foreach ($venta->objetos as $objeto) {
        $json[]=$objeto;
    }
    $jsonstring=json_encode($json);
    echo $jsonstring;
}
if($_POST['funcion']=='vendedor_mes')
{
    $venta->vendedor_mes();
    $json=array();
    foreach ($venta->objetos as $objeto) {
        $json[]=$objeto;
    }
    $jsonstring=json_encode($json);
    echo $jsonstring;
}
if($_POST['funcion']=='producto_mas_vendido')
{
    $venta->producto_mas_vendido();
    $json=array();
    foreach ($venta->objetos as $objeto) {
        $json[]=$objeto;
    }
    $jsonstring=json_encode($json);
    echo $jsonstring;
}
if($_POST['funcion']=='cliente_mes')
{
    $venta->cliente_mes();
    $json=array();
    foreach ($venta->objetos as $objeto) {
        $json[]=$objeto;
    }
    $jsonstring=json_encode($json);
    echo $jsonstring;
}
if($_POST['funcion']=='obtener_id_venta')
    {
        $venta->obtener_id_venta();
        $json=array();
        foreach ($venta->objetos as $objeto)
        {
            $json[] = array(
                'id'=>$objeto->sig_venta,
            );
        }
        $jsonstring=json_encode($json);
        echo $jsonstring;
    }

?> 