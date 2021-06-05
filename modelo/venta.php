<?php
include_once 'conexion.php'; //incluimos a la conexión
class venta
{
    var $objetos;
    public function __construct()
    {
        $db = new conexion(); //instanciamos un objeto de la clase conexión 
        $this->acceso= $db->pdo;
    }
    function crear($cliente,$vendedor,$total)
    {
        $sql="INSERT INTO ventas (fk_cliente,total,fk_usuarios)
        VALUES (:cliente,:total,:vendedor)"; 
        $query= $this->acceso->prepare($sql); 
        $query->execute(array(':cliente'=>$cliente,':total'=>$total,':vendedor'=>$vendedor));   
    }
    function ultima_venta()
    {
        $sql="SELECT MAX(id_ventas) as ultima_venta FROM ventas"; //con esta consulta seleccionamos el id de la ultima venta que se realizo 
        $query= $this->acceso->prepare($sql); 
        $query->execute();
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
    function borrar($id_venta)
    {
        $sql="DELETE FROM ventas WHERE id_ventas=:id_venta"; 
        $query= $this->acceso->prepare($sql); 
        $query->execute(array(':id_venta'=>$id_venta));   
        echo 'delete';
    }
    function buscar()
    {
        $sql="SELECT id_ventas,cliente,total, CONCAT(usuarios.nombre,' ', usuarios.apellido_pat) AS vendedor, 
        ventas.fecha  AS fecha, fk_cliente
        FROM ventas 
        JOIN usuarios ON fk_usuarios=id_usuario"; 
        $query= $this->acceso->prepare($sql); 
        $query->execute();
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
    function verificar($id_venta, $id_usuario)
    {
        $sql="SELECT * 
        FROM ventas 
        WHERE fk_usuarios=:id_usuario AND id_ventas=:id_venta"; 
        $query= $this->acceso->prepare($sql); 
        $query->execute(array(':id_usuario'=>$id_usuario,':id_venta'=>$id_venta));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    function recuperar_vendedor($id_venta)
    {
        $sql="SELECT is_admin
        FROM ventas 
        JOIN usuarios ON id_usuario=fk_usuarios
        WHERE id_ventas=:id_venta"; 
        $query= $this->acceso->prepare($sql); 
        $query->execute(array(':id_venta'=>$id_venta));
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
    function venta_dia_vendedor($id_usuario)
    {
        $sql="SELECT SUM(total) AS venta_dia_vendedor FROM ventas 
        WHERE fk_usuarios=:id_usuario 
        AND date(fecha)=date(curdate())"; //hacemos la sumatoria del del total de la ventas que hizo en el dia en curso el vendedor 
        $query= $this->acceso->prepare($sql); 
        $query->execute(array(':id_usuario'=>$id_usuario));
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
    function venta_diaria()
    {
        $sql="SELECT SUM(total) AS venta_diaria FROM ventas
         WHERE date(fecha)=date(curdate())"; //hacemos el total de la ventas de  todos los vendedores en ese dia en curso !!
        $query= $this->acceso->prepare($sql); 
        $query->execute();
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
    function venta_mensual()
    {
        $sql="SELECT SUM(total) AS venta_mensual FROM ventas
        WHERE year(fecha)=year(curdate()) 
        AND month(fecha)=month(curdate())"; //hacemos la sumatoria del del total de la ventas en un mes que hizo en el dia en curso el vendedor 
        $query= $this->acceso->prepare($sql); 
        $query->execute();
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
    function venta_anual()
    {
        $sql="SELECT SUM(total) AS venta_anual FROM ventas
        WHERE year(fecha)=year(curdate())"; //hacemos la sumatoria del del total de la ventas en un año que hizo en el dia en curso el vendedor 
        $query= $this->acceso->prepare($sql); 
        $query->execute();
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
    function buscar_id($id_venta)
    {
        $sql="SELECT id_ventas,cliente,total, CONCAT(usuarios.nombre,' ', usuarios.apellido_pat) AS vendedor, 
        ventas.fecha  AS fecha, fk_cliente
        FROM ventas 
        JOIN usuarios ON fk_usuarios=id_usuario
        AND id_ventas=:id_venta"; 
        $query= $this->acceso->prepare($sql); 
        $query->execute(array(':id_venta'=>$id_venta));
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
    function venta_mes()
    {
        $sql="SELECT SUM(total) AS cantidad, month(fecha) AS mes 
        FROM ventas 
        WHERE year(fecha) = year(curdate()) GROUP BY month(fecha)"; 
        $query= $this->acceso->prepare($sql); 
        $query->execute();
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
    function vendedor_mes()
    {
        $sql="SELECT CONCAT(usuarios.nombre,' ',usuarios.apellido_pat,' ',usuarios.apellido_mat) AS vendedor, 
        SUM(total) as cantidad FROM ventas 
        JOIN usuarios ON fk_usuarios=id_usuario 
        WHERE month(ventas.fecha)=month(curdate()) 
        AND year(ventas.fecha)=year(curdate()) 
        GROUP BY fk_usuarios ORDER BY cantidad DESC LIMIT 3"; 
        $query= $this->acceso->prepare($sql); 
        $query->execute();
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
    function cliente_mes()
    {
        $sql="SELECT CONCAT(clientes.nombre) AS cliente, 
        SUM(total) as cantidad FROM ventas 
        JOIN clientes ON fk_cliente=id_cliente 
        WHERE month(ventas.fecha)=month(curdate()) 
        AND year(ventas.fecha)=year(curdate()) 
        GROUP BY fk_cliente
        ORDER BY cantidad DESC LIMIT 3"; 
        $query= $this->acceso->prepare($sql); 
        $query->execute();
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
    function producto_mas_vendido()
    {
        $sql="SELECT nombre, SUM(cantidad) AS total FROM venta_productos
        JOIN ventas ON id_ventas=fk_ventas
        JOIN productos ON id_productos=fk_productos
        WHERE year(ventas.fecha)=year(curdate()) AND month(ventas.fecha)=month(curdate())
        GROUP BY fk_productos 
        ORDER BY `total`  DESC LIMIT 5"; 
        $query= $this->acceso->prepare($sql); 
        $query->execute();
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
    function obtener_id_venta()
    {
            $sql="SELECT LAST_INSERT_ID(id_ventas)+1 AS sig_venta 
            FROM Ventas 
            ORDER BY id_ventas DESC LIMIT 0,1"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
    }
}
?>