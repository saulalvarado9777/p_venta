<?php
include_once 'conexion.php'; //incluimos a la conexión
class producto
{
    var $objetos;
    public function __construct()
    {
        $db = new conexion(); //instanciamos un objeto de la clase conexión 
        $this->acceso= $db->pdo;
    }
    function crear($codigo,$nombre,$inventario_min,$precio_in,$precio_out,$presentacion,$unidad,$categoria) //es la funcion para crear un producto nuevo
    {
        $sql="SELECT id_productos, is_active FROM productos WHERE nombre=:nombre"; 
        //con esta consulta verificamos si ya existe algun producto con alguno de los campos, si ya existe alguno con algun campo igual no lo agrega
        $query= $this->acceso->prepare($sql); 
        $query->execute(array(':nombre'=>$nombre));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos))
        {
            foreach ($this->objetos as $prod) {
                # code...
                $id_productos=$prod->id_productos;
                $estado=$prod->is_active;
            }
            if($estado==true)
            {
                echo 'noagregado';
            }
            else
            {
                $sql="UPDATE productos SET is_active=true WHERE id_productos=:id"; 
                $query= $this->acceso->prepare($sql); 
                $query->execute(array(':id'=>$id_productos));
                echo 'agregado';
            }
        }
        else
        {
            $sql="INSERT INTO productos(codigo,nombre,inv_min,pre_in,pre_out,presentacion,unidad,fk_categoria) VALUES (:codigo,:nombre,:inventario_min,:precio_in,:precio_out,:presentacion,:unidad,:categoria);"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute(array(':codigo'=>$codigo,':nombre'=>$nombre,':inventario_min'=>$inventario_min,':precio_in'=>$precio_in,':precio_out'=>$precio_out,':presentacion'=>$presentacion,':unidad'=>$unidad,':categoria'=>$categoria));
            echo 'agregado';
        }
    }
    function buscar()
    {
         if(!empty($_POST['consulta']))
         {
            $consulta=$_POST['consulta'];
            $sql="SELECT 
            id_productos,codigo,productos.nombre as nombre, 
            inv_min, pre_in, pre_out, presentacion, unidad, 
            categoria.nombre as categoria, fk_categoria
            FROM productos JOIN categoria ON id_categoria=fk_categoria 
            WHERE productos.is_active=true 
            AND productos.nombre LIKE :consulta LIMIT 25"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
         }
         else
         {
            $sql="SELECT 
            id_productos, codigo, productos.nombre as nombre,
            inv_min, pre_in, pre_out, presentacion, unidad, 
            categoria.nombre as categoria, fk_categoria 
            FROM productos JOIN categoria ON id_categoria=fk_categoria
            WHERE productos.is_active=true 
            AND productos.nombre NOT LIKE ' ' ORDER BY productos.nombre LIMIT 25"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
         }
    }
    function editar($id_productos,$codigo,$nombre,$inventario_min,$precio_in,$precio_out,$presentacion,$unidad,$id_categoria) //es la funcion para crear un producto nuevo
    {
        $sql="SELECT id_productos FROM productos WHERE id_productos!=:id_productos AND nombre=:nombre AND fk_categoria=:id_categoria"; 
        //con esta consulta verificamos si ya existe algun producto con alguno de los campos, si ya existe alguno con algun campo igual no lo agrega
        $query= $this->acceso->prepare($sql); 
        $query->execute(array(':id_productos'=>$id_productos,':nombre'=>$nombre,':id_categoria'=>$id_categoria));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos))
        {
            echo 'noeditado';
        }
        else
        {
            $sql="UPDATE productos SET codigo=:codigo, nombre=:nombre, inv_min=:inventario_min, pre_in=:precio_in, pre_out=:precio_out, presentacion=:presentacion, unidad=:unidad, fk_categoria=:id_categoria WHERE id_productos=:id_productos"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute(array(':id_productos'=>$id_productos,':codigo'=>$codigo,':nombre'=>$nombre,':inventario_min'=>$inventario_min,':precio_in'=>$precio_in,':precio_out'=>$precio_out,':presentacion'=>$presentacion,':unidad'=>$unidad,':id_categoria'=>$id_categoria));
            echo 'editado';
        }
    }
    function borrar($id)
    {
        $sql="SELECT * FROM lote WHERE fk_productos=:id"; 
        $query= $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id));
        $lote=$query->fetchall();
        if(!empty($lote))
        {
            echo 'noborrado';
        }
        else
        {
            $sql="UPDATE productos SET is_active=false WHERE id_productos=:id"; 
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
    function obtener_stock($id)
    {
        $sql="SELECT SUM(cantidad_lote) AS total 
        FROM lote WHERE fk_producto=:id AND is_active=1"; 
        $query= $this->acceso->prepare($sql); 
        $query->execute(array(':id'=>$id));
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }

    function buscar_id($id)
    {
        $sql="SELECT id_productos, productos.nombre as nombre,inv_min, pre_in, pre_out,categoria.nombre as categoria, 
                presentacion, unidad, fk_categoria 
                FROM productos 
                JOIN categoria on fk_categoria=id_categoria
                WHERE id_productos=:id "; 
            $query= $this->acceso->prepare($sql); 
            $query->execute(array(':id'=>$id));
            $this->objetos=$query->fetchall();
            return $this->objetos;
    }
    function reporte_productos()
    {
        
            $sql="SELECT 
            id_productos, productos.nombre as nombre,
            inv_min, pre_in, pre_out, presentacion, unidad, 
            categoria.nombre as categoria, fk_categoria 
            FROM productos JOIN categoria ON id_categoria=fk_categoria 
            AND productos.nombre NOT LIKE ' ' ORDER BY productos.nombre"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
    }
    function obtener_productos()
    {
            $sql="SELECT 
            id_productos, productos.nombre as nombre,
            inv_min, pre_in, pre_out, presentacion, unidad, 
            categoria.nombre as categoria, fk_categoria 
            FROM productos JOIN categoria ON id_categoria=fk_categoria
            ORDER BY nombre ASC"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
            
    }
}
?>