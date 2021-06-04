<?php
include_once 'conexion.php';
class usuario{
    var $objetos;
    public function __construct(){
        $db= new conexion();
        $this->acceso= $db->pdo; 
    }
    function Loguearse($user,$pass){
        $sql="SELECT * FROM usuarios WHERE nombre_usuario=:user";/*a la izquierda elementos de lbd y a la derecha donde se va a lojar * */
        $query= $this->acceso->prepare($sql);
        $query->execute(array(':user'=>$user));
        $objetos=$query->fetchall();
        foreach ($objetos as $objeto) {
            $contraseña_actual=$objeto->password;
        }
        if(strpos($contraseña_actual,'$2y$10$')===0)//si la contraseña esta encriptada devuelve la posicion 0 por que estan al inicio de una contraseña  
        {
            if(password_verify($pass,$contraseña_actual))//si la contraseña es igual y la correcta hace el cambio
            {
                return "logueado";
            }
        }
        else
        {
            if($pass==$contraseña_actual)
            {
                return "logueado";
            }
        }
    }
    function obtener_dato($nombre_usuario){
        $sql="SELECT * FROM usuarios WHERE nombre_usuario=:nombre_usuario";
        $query= $this->acceso->prepare($sql);
        $query->execute(array(':nombre_usuario'=>$nombre_usuario));
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
    function obtener_datos($id){
        $sql="SELECT * FROM usuarios WHERE id_usuario=:id";
        $query= $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id));
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
    function editar($id_usuario,$correo){
        $sql="UPDATE usuarios SET email=:correo where id_usuario=:id";
        $query= $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id_usuario,':correo'=>$correo));
        echo 'editado';
        
    }
    function cambiar_contra($id_usuario,$oldpass,$newpass)
    {
        $sql="SELECT * FROM usuarios WHERE id_usuario=:id";
        $query= $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id_usuario));
        $this->objetos=$query->fetchall();//almacena los resultados y los obtiene objetos
        foreach ($this->objetos as $objeto) {
            $contraseña_actual=$objeto->password;
        }
        if(strpos($contraseña_actual,'$2y$10$')===0)//si la contraseña esta encriptada devuelve la posicion 0 por que estan al inicio de una contraseña  
        {
            if(password_verify($oldpass,$contraseña_actual))//si la contraseña es igual y la correcta hace el cambio
            {
                $pass=password_hash($newpass,PASSWORD_BCRYPT,['cost'=>10]);
                $sql="UPDATE usuarios SET password=:newpass WHERE id_usuario=:id";
                $query= $this->acceso->prepare($sql);
                $query->execute(array(':id'=>$id_usuario,':newpass'=>$pass));
                echo 'update';
            }
            else
            {
                echo 'noupdate';
            }
        }
        else
        {
            if($oldpass==$contraseña_actual)
            {
                $pass=password_hash($newpass,PASSWORD_BCRYPT,['cost'=>10]);
                $sql="UPDATE usuarios SET password=:newpass WHERE id_usuario=:id";
                $query= $this->acceso->prepare($sql);
                $query->execute(array(':id'=>$id_usuario,':newpass'=>$pass));
                echo 'update';
            }
            else
            {
                echo 'noupdate';
            }
        }
                
    }
    function buscar()
    {
         if(!empty($_POST['consulta'])) 
         {
            $consulta=$_POST['consulta'];
            $sql="SELECT * FROM usuarios WHERE nombre LIKE :consulta"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
         }
         else
         {
            $sql="SELECT * FROM usuarios WHERE nombre NOT LIKE '' ORDER BY id_usuario LIMIT 25 "; 
            $query= $this->acceso->prepare($sql); 
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
         }
    }
    function crear($nombre,$apellido_pat,$apellido_mat,$email,$nombre_usuario,$pass,$tipo_usuario)
    {
        $sql="SELECT id_usuario FROM usuarios WHERE nombre_usuario=:nombre_usuario"; 
        $query= $this->acceso->prepare($sql); 
        $query->execute(array(':nombre_usuario'=>$nombre_usuario));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos))
        {
            echo 'noagregado';
        }
        else
        {
            $sql="INSERT INTO usuarios(nombre, apellido_pat, apellido_mat, email, nombre_usuario, password, is_admin) 
            VALUES (:nombre,:apellido_pat,:apellido_mat,:email,:nombre_usuario,:pass,:tipo_usuario);"; 
            $query= $this->acceso->prepare($sql); 
            $query->execute(array(':nombre'=>$nombre,':apellido_pat'=>$apellido_pat,':apellido_mat'=>$apellido_mat,':email'=>$email,':nombre_usuario'=>$nombre_usuario,':pass'=>$pass,':tipo_usuario'=>$tipo_usuario));
            echo 'agregado';
        }
    }
    function borrar($pass,$id_borrado,$id_usuario)
    {
        $sql="SELECT password FROM usuarios WHERE id_usuario=:id_usuario"; 
        $query= $this->acceso->prepare($sql); 
        $query->execute(array(':id_usuario'=>$id_usuario));
        $this->objetos=$query->fetchall();
        foreach ($this->objetos as $objeto) {
            $contraseña_actual=$objeto->password;
        }
        if(strpos($contraseña_actual,'$2y$10$')===0)//si la contraseña esta encriptada devuelve la posicion 0 por que estan al inicio de una contraseña  
        {
            if(password_verify($pass,$contraseña_actual))//si la contraseña es igual y la correcta hace el cambio
            {
                $sql="DELETE FROM usuarios WHERE id_usuario=:id"; 
                $query= $this->acceso->prepare($sql); 
                $query->execute(array(':id'=>$id_borrado));
                echo 'borrado';
            }
            else
            {
                echo 'noborrado';
            }
        }
        else
        {
            if($pass==$contraseña_actual)
            {
                $sql="DELETE FROM usuarios WHERE id_usuario=:id"; 
                $query= $this->acceso->prepare($sql); 
                $query->execute(array(':id'=>$id_borrado));
                echo 'borrado';
            }
            else
            {
                echo 'noborrado';
            }
        }
        
    }
}
?>