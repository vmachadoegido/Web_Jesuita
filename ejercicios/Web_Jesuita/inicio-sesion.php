<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Inicio Sesion</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php
            echo '<div id="contenedor">';
                if(!isset($_POST["Enviar"]))
                {
                    echo '<form action="" METHOD="POST">';
                        echo '<h2>Inicio de Sesion</h2>';
                        echo '<input type="text" placeholder="Ip" name="ip" required>';
                        echo '<input type="password" placeholder="Password" name="password" required>';
                        echo '<input type="submit" value="Enviar" name="Enviar">';
                    echo '</form>';
                }
                            else
            {
                include 'procesosApp.php';
                $objeto = new procesosApp();

                // Guardar Variables
                $ip = $_POST["ip"];
                $password = $_POST["password"];

                // Funcion prepare
                $resultado = $objeto->iniciosession($ip, $password);

                // Corecto el inicio de session
                if($resultado == 'true')
                {
                    // Rediciona a comprobar
                    session_start();
                    $_SESSION["usuario"] = 'usuario';

                    // Rediciona a comprobar
                    header('Location: 0-rankingvisitas.php');
                }
                else
                {
                    echo '<p>El usuario o password son incorrecto</p>';
                    echo '<a href="inicio.php">Volver</a>';
                    echo '<a href="registro.php.php">Registrarte</a>';
                }
            }
            echo '</div>';
        ?>
    </body>
</html>