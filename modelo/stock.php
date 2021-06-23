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
            $sql="SELECT id_lote,  CONCAT(id_lote,'|',lote.codigo) AS codigo, 
            cantidad_lote, productos.nombre AS prod_nombre,
            proveedor.nombre AS prov_nombre FROM lote
            JOIN compra ON lote.fk_compra = compra.id_compra AND lote.is_active=1
            JOIN proveedor on proveedor.id_proveedor=compra.fk_proveedor
            JOIN productos on productos.id_productos=lote.fk_producto
            AND productos.nombre  LIKE :consulta ORDER BY  lote.fecha DESC LIMIT 25;"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
        else
        {
            $sql="SELECT id_lote, CONCAT(id_lote,'|',lote.codigo) AS codigo, 
            cantidad_lote, productos.nombre AS prod_nombre,
            proveedor.nombre AS prov_nombre FROM lote
            JOIN compra ON lote.fk_compra = compra.id_compra AND lote.is_active=1
            JOIN proveedor on proveedor.id_proveedor=compra.fk_proveedor
            JOIN productos on productos.id_productos=lote.fk_producto
            AND productos.nombre NOT LIKE '' ORDER BY   productos.nombre DESC LIMIT 25;"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }
    function editar($id,$stock) //es la funcion para crear un producto nuevo
    {
            $sql="UPDATE lote SET cantidad_lote=:stock WHERE id_lote=:id"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute(array(':id'=>$id,':stock'=>$stock));
            echo 'editar_stock';
 
    }
    function borrar($id)
    {
        $sql="UPDATE lote SET is_active=0 WHERE id_lote=:id"; 
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
            $sql="UPDATE lote SET cantidad_lote=cantidad_lote+:cantidad, is_active=1
            WHERE id_lote=:fk_det_lote"; 
            $query= $this->acceso->prepare($sql); //como ya encontro un lote que esta en stock el cual pertenece a ese regostro y la estamo sumando que esta regresando
            $query->execute(array(':cantidad'=>$det_cantidad,':fk_det_lote'=>$fk_det_lote));
            //echo 'editar';
    }
/////////////////////////////////////////////nuevas consultas
    function crear_lote($codigo,$cantidad,$precio_compra,$fk_compra,$fk_producto) //es la funcion para crear un producto nuevo
    {
            $sql="INSERT INTO lote(codigo,cantidad,cantidad_lote,precio_compra,fk_compra,fk_producto) 
            VALUES (:codigo,:cantidad,:cantidad_lote,:precio_compra,:fk_compra,:fk_producto)"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute(array(':codigo'=>$codigo,':cantidad'=>$cantidad,':cantidad_lote'=>$cantidad,':precio_compra'=>$precio_compra,':fk_compra'=>$fk_compra,':fk_producto'=>$fk_producto));
            echo 'agregado';
    }
    function ver($id) //es la funcion para crear un producto nuevo
    {
        $sql="SELECT l.codigo AS codigo, l.cantidad AS cantidad, precio_compra, p.nombre AS producto,
        cat.nombre AS categoria
        FROM lote AS l
        JOIN productos AS p on fk_producto=id_productos AND fk_compra=:id
        JOIN categoria AS cat on fk_categoria=id_categoria
        ";
        $query= $this->acceso->prepare($sql); 
        $query->execute(array(':id'=>$id));
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
}
?>