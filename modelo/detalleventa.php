<?php
include_once 'conexion.php'; //incluimos a la conexión
class DetalleVenta
{
    var $objetos;
    public function __construct()
    {
        $db = new conexion(); //instanciamos un objeto de la clase conexión 
        $this->acceso= $db->pdo;
    }
    function recuperar($id_venta)
    {
        $sql="SELECT * 
        FROM detalle_venta
        WHERE fk_ventas=:id_venta"; 
        $query= $this->acceso->prepare($sql); 
        $query->execute(array(':id_venta'=>$id_venta));
        $this->objetos=$query->fetchall();
        return $this->objetos; //varieble que se ocupa en l foreach
    }
    function borrar($id_detalle_venta)
    {
        $sql="DELETE FROM detalle_venta WHERE id_detalle_venta=:id_detalle_venta"; //verificar por que aqui es id_detalle_venta
        $query= $this->acceso->prepare($sql); //y no fk_ventas soolo es eso 
        $query->execute(array(':id_detalle_venta'=>$id_detalle_venta)); 
    }
}
?>