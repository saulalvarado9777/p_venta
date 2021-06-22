
<?php
    include_once '../modelo/usuario.php';
    session_start();
    $user= $_POST['user']; /*creacion de variables para el metodo post de login tienene que  */
    $pass= $_POST['pass'];/*los nombres tienen que ser iguala como se maneja en la vista de login */
    $usuario= new usuario();
    if(!empty($_SESSION['us_tipo']))
    {
        switch ( $_SESSION['us_tipo']) {
            case '1':
                header('Location: ../Vistas/adm_catalogo.php');
                break;
            case '2': 
                header('Location: ../Vistas/adm_catalogo.php');
                break;
        }
    }
    else
    {
        //envimos un metodo llamdo loguearse con dos parametros
        if(!empty($usuario->Loguearse($user, $pass)=="logueado"))//si no es vacia empieza hacer el recorrido
        {
            $usuario->obtener_dato($user);
            foreach ($usuario->objetos as $objeto) {
                //print_r($objeto);
                $_SESSION['usuario']=$objeto->id_usuario;
                $_SESSION['us_tipo']=$objeto->is_admin;
                $_SESSION['nombre_us']=$objeto->nombre_usuario;
                //print_r($_SESSION['usuario']);
            }
            switch ( $_SESSION['us_tipo']) {
                case '1':
                    header('Location: ../Vistas/adm_catalogo.php');
                    break;
                case 2: 
                    header('Location: ../Vistas/adm_catalogo.php');
                    break;
            }
        }
        else
        {
            header('Location: ../index.php');
        }
    }


?>