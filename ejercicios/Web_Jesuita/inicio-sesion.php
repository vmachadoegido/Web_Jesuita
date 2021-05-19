<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Inicio Sesion</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php
            session_start();

            echo '<div id="contenedor">';
                if(!isset($_POST["Enviar"]))
                {
                    echo '<form action="" METHOD="POST">';
                        echo '<h2>Inicio de Sesion</h2>';
                        echo '<input type="text" placeholder="Usuario" name="usuario">';
                        echo '<input type="password" placeholder="Password" name="password">';
                        echo '<input type="submit" value="Enviar" name="Enviar">';
                    echo '</form>';
                }
                else
                {
                    // Finje ser admin aunque no tendria que estar aqui
                    if($_POST["usuario"]=='admin')
                    {
                        $_SESSION["usuario"]= 'admin';
                        header('Location: 0-rankingvisitas.php');
                    }

                    // Finje ser usuario, tendria que comprobar la base de datos.
                    if($_POST["usuario"]=='usuario')
                    {
                        $_SESSION["usuario"]= 'usuario';
                        header('Location: 0-rankingvisitas.php');
                    }
                }
            echo '</div>';
        ?>
    </body>
</html>



