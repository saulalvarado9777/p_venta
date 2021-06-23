<?php
    include_once '../modelo/ventaproducto.php';
    include_once '../modelo/detalleventa.php';
    include_once '../modelo/venta.php';
    include_once '../modelo/stock.php';
    $stock = new lote();
    $detalle_venta = new DetalleVenta();
    $venta_producto = new ventaProducto();
    $venta = new venta();
    session_start();
    $id_usuario=$_SESSION['usuario'];
    $tipo_usuario=$_SESSION['us_tipo'];

    if($_POST['funcion']=='borrar_venta')
        {
            $id_venta=$_POST['id'];
            if($venta->verificar($id_venta,$id_usuario)==1)//el metodo verificar corresponde al modelo venta
            {//si la venta te pertenece al que la creo la puede eliminar
                $venta_producto->borrar($id_venta);//el metodo corresponde al modelo ventaProducto
                $detalle_venta->recuperar($id_venta);//el metodo correspon al modelo detalleventa
                foreach ($detalle_venta->objetos as $det) {
                    $stock->devolver($det->fk_det_lote,$det->det_cantidad,$det->det_fecha,$det->fk_det_prod,$det->fk_det_prov);
                    $detalle_venta->borrar($det->id_detalle_venta);//corresponde al modelo detalleventa
                }
                $venta->borrar($id_venta);// corresponde al modelo venta
            }
            else
            {
                if($tipo_usuario==1)//si el usuario es administrador puede eliminar todas la ventas 
                {
                    $venta_producto->borrar($id_venta);//el metodo corresponde al modelo ventaProducto
                    $detalle_venta->recuperar($id_venta);//el metodo correspon al modelo detalleventa
                    foreach ($detalle_venta->objetos as $det) {
                    $stock->devolver($det->fk_det_lote,$det->det_cantidad,$det->det_fecha,$det->fk_det_prod,$det->fk_det_prov);
                    $detalle_venta->borrar($det->id_detalle_venta);//corresponde al modelo detalleventa
                    }
                    $venta->borrar($id_venta);// corresponde al modelo venta
                }
                else if($tipo_usuario==1)
                {
                    $venta->recuperar_vendedor($id_venta);//corresponde al modelo venta
                    foreach ($venta->objetos as $objeto) {
                        if($objeto->is_admin==2)//si el is_admin es al de los vendedores 
                        {
                            $venta_producto->borrar($id_venta);//el metodo corresponde al modelo ventaProducto
                            $detalle_venta->recuperar($id_venta);//el metodo correspon al modelo detalleventa
                            foreach ($detalle_venta->objetos as $det) {
                            $stock->devolver($det->fk_det_lote,$det->det_cantidad,$det->det_fecha,$det->fk_det_prod,$det->fk_det_prov);
                            $detalle_venta->borrar($det->id_detalle_venta);//corresponde al modelo detalleventa
                            }
                            $venta->borrar($id_venta);// corresponde al modelo venta
                        }
                        else//si es administrado no elimina las ventas
                        {
                            echo 'no delete';
                        }
                    }
                }
                else
                {
                    echo 'nodelete';
                }
            }
        }
?>