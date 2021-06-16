<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Inicio Sesion</title>
        <link rel="stylesheet" href="estilo.css">
    </head>
    <body>
        <?php
            echo '<div id="contenedor">';
                if(!isset($_POST["Enviar"]))
                {
                    echo '<form METHOD="POST">';
                        echo '<h2>Inicio de Sesion</h2>';
                        echo '<input type="text" placeholder="Usuario" name="usuario" required>';
                        echo '<input type="password" placeholder="Password" name="password" required>';
                        echo '<input type="submit" value="Enviar" name="Enviar">';
                    echo '</form>';
                }
                else
                {
                    include 'clasephp.php';
                    $objeto = new clasephp();

                    // Guardar Variables
                    $usuario = $_POST["usuario"];
                    $password = $_POST["password"];

                    // Funcion prepare
                    $resultado = $objeto->iniciosession2($usuario, $password);

                    // Corecto el inicio de session
                    if($resultado == 'true')
                    {
                        // Rediciona a comprobar
                        session_start();
                        $_SESSION["usuario"] = 'admin';

                        // Rediciona a comprobar
                        header('Location: ../0-rankingvisitas.php');
                    }
                    else
                    {
                        echo '<p>El usuario o password son incorrecto</p>';
                        echo '<a href="InicioSesion-Administrador.php">Volver</a>';
                    }
                }
            echo '</div>';
        ?>
    </body>
</html>



