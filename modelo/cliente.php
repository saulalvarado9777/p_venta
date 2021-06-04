<?php
    include_once 'conexion.php'; //incluimos a la conexión
    class cliente
    {
        var $objetos;
        public function __construct()
        {
            $db = new conexion(); //instanciamos un objeto de la clase conexión 
            $this->acceso= $db->pdo;
        }
        function crear($nombre,$telefono,$correo) //es la funcion para crear un producto nuevo
        {
            $sql="SELECT id_cliente,is_active FROM clientes WHERE nombre=:nombre"; //verificar si es necesario si solo compruebe que tiene el mismo nombre, del provveedoo agregar los demas campos
            //con esta consulta verificamos si ya existe algun producto con alguno de los campos, si ya existe alguno con algun campo igual no lo agrega
            $query= $this->acceso->prepare($sql); 
            $query->execute(array(':nombre'=>$nombre));
            $this->objetos=$query->fetchall();
            if(!empty($this->objetos))
            {
                foreach ($this->objetos as $cli) {
                    # code...
                    $id_cliente=$cli->id_cliente;
                    $estado=$cli->is_active;
                }
                if($estado==true)
                {
                    echo 'noagregado';
                }
                else
                {
                    $sql="UPDATE clientes SET is_active=true WHERE id_cliente=:id"; 
                    $query= $this->acceso->prepare($sql); 
                    $query->execute(array(':id'=>$id_cliente));
                    echo 'agregado';
                }
            }
            else
            {
                $sql="INSERT INTO clientes(nombre,correo,telefono) VALUES (:nombre,:correo,:telefono);"; 
                $query= $this->acceso->prepare($sql); 
                $query->execute(array(':nombre'=>$nombre,':correo'=>$correo,':telefono'=>$telefono));
                echo 'agregado';
            }
        }
            function buscar()
        {
            if(!empty($_POST['consulta']))
            {
                $consulta=$_POST['consulta'];
                $sql="SELECT * FROM clientes 
                WHERE is_active=true 
                AND nombre LIKE :consulta LIMIT 25";
                $query= $this->acceso->prepare($sql); 
                $query->execute(array(':consulta'=>"%$consulta%"));
                $this->objetos=$query->fetchall();
                return $this->objetos;
            }
            else
            {
                $sql="SELECT * FROM clientes 
                WHERE is_active=true 
                AND nombre NOT LIKE '' ORDER BY nombre LIMIT 25"; 
                $query= $this->acceso->prepare($sql); 
                $query->execute();
                $this->objetos=$query->fetchall();
                return $this->objetos;
            }
        }
        function editar($id,$correo,$telefono) //es la funcion para crear un producto nuevo
        {
            $sql="SELECT id_cliente FROM clientes WHERE id_cliente=:id"; 
            //con esta consulta verificamos si ya existe algun producto con alguno de los campos, si ya existe alguno con algun campo igual no lo agrega
            $query= $this->acceso->prepare($sql); 
            $query->execute(array(':id'=>$id));
            $this->objetos=$query->fetchall();
            if(empty($this->objetos))
            {
                echo 'noeditado';
            }
            else
            {
                $sql="UPDATE clientes SET telefono=:telefono, correo=:correo WHERE id_cliente=:id"; 
                $query= $this->acceso->prepare($sql); 
                $query->execute(array(':id'=>$id,':telefono'=>$telefono,':correo'=>$correo));
                echo 'editado';
            }
        }
        function borrar($id)
        {
                $sql="UPDATE clientes SET is_active=false WHERE id_cliente=:id"; 
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
        function obtener_clientes()
        {
                $sql="SELECT * FROM clientes WHERE is_active=true ORDER BY nombre asc"; 
                $query= $this->acceso->prepare($sql); 
                $query->execute();
                $this->objetos=$query->fetchall();
                return $this->objetos;
                
        }
        function buscar_datos_cliente($id_cliente)
        {
                $sql="SELECT * FROM clientes WHERE id_cliente=:id_cliente"; 
                $query= $this->acceso->prepare($sql); 
                $query->execute(array(':id_cliente'=>$id_cliente));
                $this->objetos=$query->fetchall();
                return $this->objetos;
                
        }
    }
?>