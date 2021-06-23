<?php
    include_once 'conexion.php'; //incluimos a la conexión
    class estado
    {
        var $objetos;
        public function __construct()
        {
            $db = new conexion(); //instanciamos un objeto de la clase conexión 
            $this->acceso= $db->pdo;
        }
        function obtener_estado()
        {
                $sql="SELECT * FROM estado_pago"; 
                $query= $this->acceso->prepare($sql); 
                $query->execute();
                $this->objetos=$query->fetchall();
                return $this->objetos;
                
        }
        function obtener_id($nombre)
        {
                $sql="SELECT * FROM estado_pago WHERE nombre=:nombre"; 
                $query= $this->acceso->prepare($sql); 
                $query->execute(array(':nombre'=>$nombre));
                $this->objetos=$query->fetchall();
                return $this->objetos;
                
        }
    }
?>