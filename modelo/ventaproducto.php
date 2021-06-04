<?php
include_once 'conexion.php'; //incluimos a la conexión
class ventaProducto
{
    var $objetos;
    public function __construct()
    {
        $db = new conexion(); //instanciamos un objeto de la clase conexión 
        $this->acceso= $db->pdo;
    }
    function ver($id)
    {
        $sql="SELECT  venta_productos.pre_out AS pre_out,cantidad,productos.nombre AS producto, presentacion,unidad, 
        productos.fk_categoria AS categoria, subtotal 
        FROM venta_productos 
        JOIN productos ON fk_productos = id_productos AND fk_ventas=:id
        JOIN categoria ON fk_categoria=id_categoria"; 
        $query= $this->acceso->prepare($sql); 
        $query->execute(array(':id'=>$id));
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
    function borrar($id_venta)
    {
        $sql="DELETE FROM venta_productos WHERE fk_ventas=:id_venta"; 
        $query= $this->acceso->prepare($sql); 
        $query->execute(array(':id_venta'=>$id_venta)); 
    }
}
?>