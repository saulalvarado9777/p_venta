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
        function listar_compras()
        {
            $sql="SELECT CONCAT(c.id_compra, '|', c.codigo) AS codigo, 
            fecha_compra, fecha_entrega,total, e.nombre AS estado, p.nombre AS proveedor 
            FROM compra AS c
            JOIN estado_pago AS e ON e.id_pago=fk_estado
            JOIN proveedor AS p ON p.id_proveedor=c.fk_proveedor"; //con esta consulta seleccionamos el id de la ultima venta que se realizo 
            $query= $this->acceso->prepare($sql); 
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
        function editar_estado($id_compra,$id_estado)
        {
            $sql="UPDATE compra SET fk_estado=:id_estado WHERE id_compra=:id_compra"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute(array(':id_estado'=>$id_estado,':id_compra'=>$id_compra));
        }
        function obtenerdatos($id)
        {
            $sql="SELECT CONCAT(c.id_compra, '|', c.codigo) AS codigo, 
            fecha_compra, fecha_entrega,total, e.nombre AS estado, p.nombre AS proveedor,
            telefono,correo, direccion
            FROM compra AS c
            JOIN estado_pago AS e ON e.id_pago=fk_estado AND c.id_compra=:id
            JOIN proveedor AS p ON p.id_proveedor=c.fk_proveedor"; //con esta consulta seleccionamos el id de la ultima venta que se realizo 
            $query= $this->acceso->prepare($sql); 
            $query->execute(array(':id'=>$id));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }
?>
