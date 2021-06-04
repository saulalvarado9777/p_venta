<?php
    include '../modelo/venta.php';
    include_once '../modelo/conexion.php';//el include se usa cuando hay mas de un modelo en el controlador
    $venta= new venta();
    session_start();
    $vendedor=$_SESSION['usuario'];
    if($_POST['funcion']=='registrar_compra'){
        $total=$_POST['total'];
        $cliente=$_POST['cliente'];
        //$dni=$_POST['dni'];
        $productos=json_decode($_POST['json']);
       //print_r ($productos)    ;
       //date_default_timezone_set('America/Mexico_City');
       //$fecha=date('Y-m-d H:i:s');
       $venta->crear($cliente,$vendedor,$total);
       $venta->ultima_venta();
       foreach ($venta->objetos as $objeto){
           $id_venta=$objeto->ultima_venta;
           echo $id_venta;
       }
       try {//si es que algo sale mal pasa al cach basta con que una sola linea este mal todo se corrompe 
        $db= new conexion();//instanciamos el modelo conexion 
        $conexion= $db->pdo;//capturamos la conexion pdo y la almacenamos en conexion
        $conexion->beginTransaction();//
        foreach ($productos as $prod) {
            $cantidad=$prod->cantidad;
            while ($cantidad!=0) {
                $sql="SELECT * FROM lote WHERE fecha= (SELECT MIN(fecha) FROM lote 
                WHERE fk_productos=:id) AND fk_productos=:id";
                $query= $conexion->prepare($sql); 
                $query->execute(array(':id'=>$prod->id));
                $lote=$query->fetchall();
                foreach ($lote as $lote) {
                    if($cantidad<$lote->stock)//si la cantidad es menor al stock de ese lote
                    {
                        $sql="INSERT INTO detalle_venta (det_cantidad, det_fecha, fk_det_lote, fk_det_prod, fk_det_prov,fk_ventas)
                        VALUES ('$cantidad','$lote->fecha','$lote->id_lote','$prod->id','$lote->fk_proveedor','$id_venta')";
                        $conexion->exec($sql);
                        $conexion->exec("UPDATE lote SET stock=stock-'$cantidad' WHERE id_lote='$lote->id_lote' ");//conexion es lo que contiene pdo
                        $cantidad=0;
                    }
                    if($cantidad==$lote->stock)//si la cantidad es igual al stock se eliminia ese lote se vuelve cero
                    {
                        $sql="INSERT INTO detalle_venta (det_cantidad, det_fecha, fk_det_lote, fk_det_prod, fk_det_prov,fk_ventas)
                        VALUES ('$cantidad','$lote->fecha','$lote->id_lote','$prod->id','$lote->fk_proveedor','$id_venta')";
                        $conexion->exec($sql);
                        $conexion->exec("DELETE FROM lote WHERE id_lote='$lote->id_lote' ");
                        $cantidad=0;
                    }
                    if($cantidad>$lote->stock)//si la cantidad es mayor ala cantidad que tiene ese lote resta la cantidad y la cantidad va tener un numero diferente de cero
                    {
                        $sql="INSERT INTO detalle_venta (det_cantidad, det_fecha, fk_det_lote, fk_det_prod, fk_det_prov,fk_ventas)
                        VALUES ('$lote->stock','$lote->fecha','$lote->id_lote','$prod->id','$lote->fk_proveedor','$id_venta')";
                        $conexion->exec($sql);
                        $conexion->exec("DELETE FROM lote WHERE id_lote='$lote->id_lote' ");
                        $cantidad=$cantidad-$lote->stock;
                    }
                }
            }
            $subtotal=$prod->cantidad*$prod->precio;
            $conexion->exec("INSERT INTO venta_productos(pre_out,cantidad,subtotal,fk_productos,fk_ventas)
            VALUES ('$prod->precio','$prod->cantidad','$subtotal','$prod->id','$id_venta')");//insertar los elementos a la tabla de venta_productos
        }
        $conexion->commit();//
       } catch (Exception $error) {//para manejar las exepciones si hay algun error
        $conexion->rollBack();//cuando algo sale mal usamos el rollaback y anula todo lo que hace en try
        $venta->borrar($id_venta);
        echo $error->getMessage();//manda un mensaje de error
       }
    }
?>