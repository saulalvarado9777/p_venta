<?php
include_once 'conexion.php'; //incluimos a la conexión
class categoria
{
    var $objetos;
    public function __construct()
    {
        $db = new conexion(); //instanciamos un objeto de la clase conexión 
        $this->acceso= $db->pdo;
    }
    function crear($nombre)
    {
        $sql="SELECT id_categoria, is_active FROM categoria WHERE nombre=:nombre"; 
        $query= $this->acceso->prepare($sql); 
        $query->execute(array(':nombre'=>$nombre));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos))
        {
            foreach ($this->objetos as $cat) {
                # code...
                $id_categoria=$cat->id_categoria;
                $estado=$cat->is_active;
            }
            if($estado==true)
            {
                echo 'noagregado';
            }
            else
            {
                $sql="UPDATE categoria SET is_active=true WHERE id_categoria=:id"; 
                $query= $this->acceso->prepare($sql); 
                $query->execute(array(':id'=>$id_categoria));
                echo 'agregado';
            }
        }
        else
        {
            $sql="INSERT INTO categoria(nombre) VALUES (:nombre);"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute(array(':nombre'=>$nombre));
            echo 'agregado';
        }
    }
    function buscar()
    {
         if(!empty($_POST['consulta']))
         {
            $consulta=$_POST['consulta'];
            $sql="SELECT * FROM categoria 
            WHERE is_active=true AND nombre 
            LIKE :consulta"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
         }
         else
         {
            $sql="SELECT * FROM categoria 
            WHERE is_active=true AND nombre 
            NOT LIKE '' ORDER BY id_categoria LIMIT 25 "; 
            $query= $this->acceso->prepare($sql); 
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
         }
    }
    function borrar($id)
    {
        $sql="SELECT * FROM productos WHERE fk_categoria=:id"; 
        $query= $this->acceso->prepare($sql); 
        $query->execute(array(':id'=>$id));
        $prod=$query->fetchall();
        if(!empty($prod))
        {
            echo 'noborrado';
        }
        else
        {
            $sql="UPDATE categoria SET is_active=false WHERE id_categoria=:id"; 
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
    function editar($nombre,$id_editado)
    {
        $sql="UPDATE categoria SET nombre=:nombre WHERE id_categoria=:id"; 
        $query= $this->acceso->prepare($sql); 
        $query->execute(array(':id'=>$id_editado,':nombre'=>$nombre));
        echo 'edit';
    }
    function llenar_categorias()
    {
        $sql="SELECT * FROM categoria ORDER BY nombre asc"; 
        $query= $this->acceso->prepare($sql); 
        $query->execute();
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
}
?>