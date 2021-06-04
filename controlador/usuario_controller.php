<?php
    include_once '../modelo/usuario.php';
    $usuario= new  usuario(); //instanciamos un objeto de la clase usuario
    session_start();
    $id_usuario= $_SESSION['usuario'];
    $tipo_usuario=$_SESSION['us_tipo'];
    if($_POST['funcion']=='buscar_usuario')
    {
        $json=array();
        $usuario->obtener_datos($_POST['dato']);/*obtener todos los datos del usuario */
        foreach ($usuario->objetos as $objeto )
        {
            $json[]=array/*con este json traemos los datos de la base de datos atrevs de la consulta  */
            (
                'nombre'=>$objeto->nombre,
                'apellido_pat'=>$objeto->apellido_pat,
                'apellido_mat'=>$objeto->apellido_mat,
                'email'=>$objeto->email,
                'nombre_usuario'=>$objeto->nombre_usuario,
            );
        }
        $jsonstring = json_encode ($json[0]); /*creamos la variable json, y pasamos el json en el indice 0 */
        echo $jsonstring;/*nos devuelve un json decodfificado en un string */
    }
    if($_POST['funcion']=='capturar_datos')
    {
        $json=array();
        $id_usuario=$_POST['id_usuario'];
        $usuario->obtener_datos($id_usuario);
        foreach ($usuario->objetos as $objeto )
        {
            $json[]=array
            (
                'correo'=>$objeto->email,
            );
        }
        $jsonstring=json_encode($json[0]);
        echo $jsonstring;
        
    }
    if($_POST['funcion']=='editar_usuario')
    {
        $id_usuario=$_POST['id_usuario'];
        $correo=$_POST['correo'];
        $usuario->editar($id_usuario,$correo);
    }
    if($_POST['funcion']=='cambiar_contra')
    {
        $id_usuario=$_POST['id_usuario'];
        $oldpass=$_POST['oldpass'];
        $newpass=$_POST['newpass'];
        $usuario->cambiar_contra($id_usuario,$oldpass,$newpass);    
    }
    if($_POST['funcion']=='buscar_usuarios_adm')
    {
        $json=array();
        $usuario->buscar();
        foreach ($usuario->objetos as $objeto )
        {
            $json[]=array
            (
                'id'=>$objeto->id_usuario,
                'nombre'=>$objeto->nombre,
                'apellido_pat'=>$objeto->apellido_pat,
                'apellido_mat'=>$objeto->apellido_mat,
                'nombre_usuario'=>$objeto->nombre_usuario,
                'correo'=>$objeto->email,
                'tipo_usuario'=>$objeto->is_admin
            );
        }
        $jsonstring=json_encode($json);
        echo $jsonstring;

    }
    if($_POST['funcion']=='crear_usuario')
    {
        $nombre = $_POST['nombre'];
        $apellido_pat = $_POST['apellido_pat'];
        $apellido_mat = $_POST['apellido_mat'];
        $email = $_POST['email'];
        $nombre_usuario = $_POST['nombre_usuario'];
        $pass = $_POST['pass'];
        $tipo_usuario=2;
        $usuario->crear($nombre,$apellido_pat,$apellido_mat,$email,$nombre_usuario,$pass,$tipo_usuario);
    }
    if($_POST['funcion']=='borrar_usuario')
    {
        $pass = $_POST['pass'];
        $id_borrado =$_POST['id_usuario'];
        $usuario->borrar($pass,$id_borrado,$id_usuario);
    }
    if($_POST['funcion']=='tipo_usuario')
    {
        echo $tipo_usuario;
    }

?>