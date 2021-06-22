<?php
    include_once 'conexion.php'; //incluimos a la conexión
    class compras
    {
        var $objetos;
        public function __construct()
        {
            $db = new conexion(); //instanciamos un objeto de la clase conexión 
            $this->acceso= $db->pdo;
        }
        function crear($codigo,$fecha_compra,$fecha_entrega,$total,$fk_estado,$fk_proveedor) //es la funcion para crear un producto nuevo
        {
            $sql="INSERT INTO compra(codigo,fecha_compra,fecha_entrega,total,fk_estado,fk_proveedor) 
            VALUES (:codigo,:fecha_compra,:fecha_entrega,:total,:fk_estado,:fk_proveedor);"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute(array(':codigo'=>$codigo,':fecha_compra'=>$fecha_compra,':fecha_entrega'=>$fecha_entrega,':total'=>$total,':fk_estado'=>$fk_estado,':fk_proveedor'=>$fk_proveedor));
            //echo 'compras';
        }
        function ultima_compra()
        {
            $sql="SELECT MAX(id_compra) as ultima_compra FROM compra"; //con esta consulta seleccionamos el id de la ultima venta que se realizo 
            $query= $this->acceso->prepare($sql); 
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }
?>