<?php
include_once 'conexion.php'; //incluimos a la conexión
class proveedor
{
    var $objetos;
    public function __construct()
    {
        $db = new conexion(); //instanciamos un objeto de la clase conexión 
        $this->acceso= $db->pdo;
    }
    function crear($nombre,$telefono,$correo,$direccion) //es la funcion para crear un producto nuevo
    {
        $sql="SELECT id_proveedor,is_active FROM proveedor WHERE nombre=:nombre"; //verificar si es necesario si solo compruebe que tiene el mismo nombre, del provveedoo agregar los demas campos
        //con esta consulta verificamos si ya existe algun producto con alguno de los campos, si ya existe alguno con algun campo igual no lo agrega
        $query= $this->acceso->prepare($sql); 
        $query->execute(array(':nombre'=>$nombre));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos))
        {
            foreach ($this->objetos as $prov) {
                # code...
                $id_proveedor=$prov->id_proveedor;
                $estado=$prov->is_active;
            }
            if($estado==true)
            {
                echo 'noagregado';
            }
            else
            {
                $sql="UPDATE proveedor SET is_active=true WHERE id_proveedor=:id"; 
                $query= $this->acceso->prepare($sql); 
                $query->execute(array(':id'=>$id_proveedor));
                echo 'agregado';
            }
        }
        else
        {
            $sql="INSERT INTO proveedor(nombre,telefono,correo,direccion) VALUES (:nombre,:telefono,:correo,:direccion);"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute(array(':nombre'=>$nombre,':telefono'=>$telefono,':correo'=>$correo,':direccion'=>$direccion));
            echo 'agregado';
        }
    }
    function buscar()
    {
         if(!empty($_POST['consulta']))
         {
            $consulta=$_POST['consulta'];
            $sql="SELECT * FROM proveedor 
            WHERE is_active=true 
            AND nombre LIKE :consulta LIMIT 25";
            $query= $this->acceso->prepare($sql); 
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
         }
         else
         {
            $sql="SELECT * FROM proveedor 
            WHERE is_active=true 
            AND nombre NOT LIKE '' ORDER BY nombre LIMIT 25"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
         }
    }
    function editar($id,$nombre,$telefono,$correo,$direccion) //es la funcion para crear un producto nuevo
    {
        $sql="SELECT id_proveedor FROM proveedor WHERE id_proveedor!=:id AND nombre=:nombre"; 
        //con esta consulta verificamos si ya existe algun producto con alguno de los campos, si ya existe alguno con algun campo igual no lo agrega
        $query= $this->acceso->prepare($sql); 
        $query->execute(array(':id'=>$id,':nombre'=>$nombre));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos))
        {
            echo 'noeditado';
        }
        else
        {
            $sql="UPDATE proveedor SET nombre=:nombre, telefono=:telefono, correo=:correo, direccion=:direccion WHERE id_proveedor=:id"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute(array(':id'=>$id,':nombre'=>$nombre,':telefono'=>$telefono,':correo'=>$correo,':direccion'=>$direccion));
            echo 'editado';
        }
    }
    function borrar($id)
    {
        $sql="SELECT * FROM lote WHERE fk_proveedor=:id"; 
        $query= $this->acceso->prepare($sql); 
        $query->execute(array(':id'=>$id));
        $lote=$query->fetchall();
        if(!empty($lote))
        {
            echo 'noborrado';
        }
        else
        {
            $sql="UPDATE proveedor SET is_active=false WHERE id_proveedor=:id"; 
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
    }
    function llenar_proveedores()
    {
        $sql="SELECT * FROM proveedor ORDER BY nombre asc"; 
        $query= $this->acceso->prepare($sql); 
        $query->execute();
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
}
?>