<?php
include_once 'conexion.php'; //incluimos a la conexión
class lote
{
    var $objetos;
    public function __construct()
    {
        $db = new conexion(); //instanciamos un objeto de la clase conexión 
        $this->acceso= $db->pdo;
    }
    function crear($id_producto,$proveedor,$stock) //es la funcion para crear un producto nuevo
    {
            $sql="INSERT INTO lote(stock,fk_productos,fk_proveedor) VALUES (:stock,:id_producto,:id_proveedor)"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute(array(':stock'=>$stock,':id_producto'=>$id_producto,':id_proveedor'=>$proveedor));
            echo 'agregado';
    }
    function buscar()
    {
         if(!empty($_POST['consulta']))
         {
            $consulta=$_POST['consulta'];
            $sql="SELECT id_lote, stock, lote.fecha AS fecha, productos.nombre AS prod_nombre,
            categoria.nombre AS cat_nombre,
            proveedor.nombre AS prov_nombre FROM lote 
            JOIN proveedor on fk_proveedor=id_proveedor
            JOIN productos on fk_productos=id_productos
            JOIN categoria on fk_categoria=id_categoria
            AND productos.nombre  LIKE :consulta ORDER BY  lote.fecha DESC LIMIT 25;"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
         }
         else
         {
            $sql="SELECT id_lote, stock, lote.fecha AS fecha, productos.nombre AS prod_nombre,
            categoria.nombre AS cat_nombre,
            proveedor.nombre AS prov_nombre FROM lote 
            JOIN proveedor on fk_proveedor=id_proveedor
            JOIN productos on fk_productos=id_productos
            JOIN categoria on fk_categoria=id_categoria
            AND productos.nombre NOT LIKE '' ORDER BY  lote.fecha DESC LIMIT 25;"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
         }
    }
    function editar($id,$stock) //es la funcion para crear un producto nuevo
    {
            $sql="UPDATE lote SET stock=:stock WHERE id_lote=:id"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute(array(':id'=>$id,':stock'=>$stock));
            echo 'editar';
 
    }
    function borrar($id)
    {
        $sql="DELETE FROM lote WHERE id_lote=:id"; 
        $query= $this->acceso->prepare($sql); 
        $query->execute(array(':id'=>$id));
        if(!empty($query->execute(array(':id'=>$id))))
        {
            echo 'borrado';
        }
        else
        {
            echo 'noborrado';
        }
    }
    function devolver($fk_det_lote,$det_cantidad,$det_fecha,$fk_det_prod,$fk_det_prov)
    {
        $sql="SELECT *
        FROM lote 
        WHERE id_lote=:fk_det_lote"; //si es que hay un lote en stock que es el mismo al regostro que se esta eliminando
        $query= $this->acceso->prepare($sql); //solamente lo va a sumar
        $query->execute(array(':fk_det_lote'=>$fk_det_lote));
        $lote=$query->fetchall();
        if(!empty($lote))
        {   
            $sql="UPDATE lote SET stock=stock+:cantidad
            WHERE id_lote=:fk_det_lote"; 
            $query= $this->acceso->prepare($sql); //como ya encontro un lote que esta en stock el cual pertenece a ese regostro y la estamo sumando que esta regresando
            $query->execute(array(':cantidad'=>$det_cantidad,':fk_det_lote'=>$fk_det_lote));
            echo 'editar';
        }
        else//cuando no existe un lote a donde vuelva ese producto
        {
            $sql="SELECT *
            FROM lote 
            WHERE fecha=:det_fecha AND fk_productos=:fk_det_prod
            AND fk_proveedor=:fk_det_prov"; //si es que hay un lote en stock que es el mismo al regostro que se esta eliminando
            $query= $this->acceso->prepare($sql); 
            $query->execute(array(':det_fecha'=>$det_fecha,':fk_det_prod'=>$fk_det_prod,':fk_det_prov'=>$fk_det_prov));
            $lote_nuevo=$query->fetchall();
            foreach ($lote_nuevo as $objeto) {
                $id_lote_nuevo=$objeto->id_lote;
            }
            if(!empty($lote_nuevo))//si ya encontro un lote a donde regresar
            {
                $sql="UPDATE lote 
                SET stock=stock+:cantidad
                WHERE id_lote=:fk_det_lote"; 
                $query= $this->acceso->prepare($sql); //como ya encontro un lote que esta en stock el cual pertenece a ese regostro y la estamo sumando que esta regresando
                $query->execute(array(':cantidad'=>$det_cantidad,':fk_det_lote'=>$id_lote_nuevo));
                echo 'editar';
            }
            else
            {
                $sql="INSERT INTO lote 
                (id_lote, stock, fk_productos, fk_proveedor) 
                VALUES (:id_lote,:stock,:fk_producto,:fk_proveedor)"; 
                $query= $this->acceso->prepare($sql); //como ya encontro un lote que esta en stock el cual pertenece a ese regostro y la estamo sumando que esta regresando
                $query->execute(array(':id_lote'=>$fk_det_lote ,':stock'=>$det_cantidad,':fk_producto'=>$fk_det_prod,':fk_proveedor'=>$fk_det_prov));
            }
        }
    }

}
?>