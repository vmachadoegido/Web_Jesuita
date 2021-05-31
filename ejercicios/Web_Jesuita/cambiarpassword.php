<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Inicio Sesion</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php
            // Inicia Sesion
            session_start();

            // Traer los metodos de la pagina operaciones.php
            require_once 'operaciones.php';

            // Crear el objeto de la operaciones.
            $objeto = new operaciones();

            // Comprobar los datos de la sesion.
            //echo '</br>ip: '.$_SESSION["ip"].' jesuita: '.$_SESSION["jesuita"].' usuario: '.$_SESSION["usuario"];


            echo '<div id="contenedor">';


                // Forumlario
                if(!isset($_POST["Cambiar"]))
                {
                    echo '<form METHOD="POST">';
                        echo '<input type="password" placeholder="Nuevo Password" name="password1">';
                        echo '<input type="password" placeholder="Repitela" name="password2">';
                        echo '<input type="submit" value="Cambiar" name="Cambiar">';
                    echo '</form>';
                }
                else
                {
                    // COmprobar los valores de las password
                    //echo 'password1: '.$_POST["password1"].' password2: '.$_POST["password2"];

                    // Si son iguales los password
                    if($_POST["password1"] == $_POST["password2"])
                    {
                        // Guardo el post en una variable
                        $passwordfinal =  $_POST["password1"];
                        // Encripta el password
                        $hashed_password = password_hash("$passwordfinal", PASSWORD_DEFAULT);

                        // Consulta para actualizar el password y la primera_vez
                        $consultar = 'UPDATE maquina SET password="'.$hashed_password.'", primera_vez=1 WHERE ip="'.$_SESSION["ip"].'";';
                        //print_r($consultar);
                        $objeto->realizarConsultas($consultar);

                        // Si devuelve fila, se hizo el cambio
                        if($objeto->comprobar($consultar)>0)
                        {
                            // Le lleva a la pagina de rankings
                            header('Location: 0-rankingvisitas.php');
                        }
                        else
                        {
                            echo '<p>Error Inesperado vuelva a intentarlo</p>';
                            echo '</br><a href="cambiarpassword.php" class="boton"> Volver </a></br>';
                        }

                    }
                    else
                    {
                        echo '<p>No coincide las password</p>';

                        echo '</br><a href="cambiarpassword.php" class="boton"> Volver </a></br>';
                    }
                }
            echo '</div>';
        ?>
    </body>
</html>