<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/css/all.min.css">
    <link rel="stylesheet" href="css/index2.css">
    <title>Login</title>
</head>
<?php
    session_start();
    if(!empty($_SESSION['us_tipo'])) /*si Existe una sesion  que me mande al contrololador  y se encarga de erutarla */
    {
        header('Location: controlador/logincontroller.php');
    }
    else/*sino exisate ninguna sesion que muestre el login */
    {
        session_destroy();
?>
<body>
<section>
        <div class="imgBx">
            <div class="overlay">
                <p>Diseño y construción
                    <span>
                        DIART
                    </span>
                    &mdash; venta e instalación de tablaroca&mdash;
                </p>
            </div>
        </div>
        <div class="contentBx">
            <div class="formBx">
                <h2>Login</h2>
                <form action="controlador/logincontroller.php" method="post">
                    <div class="inputBx">
                        <span>Usuario</span>
                        <input type="text" name="user" placeholder="Ingresar usuario" required>
                    </div>
                    <div class="inputBx">
                        <span>Contraseña</span>
                        <input type="password"  name="pass" placeholder="Ingresar contraseña" required>
                    </div>
                    <div class="inputBx">
                        <input type="submit" value="Login" name="">
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
<?php
    }
?>