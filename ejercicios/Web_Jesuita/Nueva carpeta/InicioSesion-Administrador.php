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
                    echo '<form action="#" METHOD="POST">';
                        echo '<h2>Inicio de Sesion</h2>';
                        echo '<input type="text" placeholder="Usuario" name="usuario">';
                        echo '<input type="password" placeholder="Password" name="password">';
                        echo '<input type="submit" value="Enviar" name="Enviar">';
                    echo '</form>';
                }
                else
                {
                    // Inicio Sesion
                    session_start();

                    require_once 'clasephp.php';

                    $objeto=new operaciones();

                    $usuario= $_POST["usuario"];
                    $password= $_POST["password"];

                    $consulta = "SELECT * FROM administrador WHERE nombreAdministrador='$usuario' and password='$password';";

                    $objeto->realizarConsultas($consulta);

                    if($objeto->comprobarSelect()>0)
                    {
                        // Extraer fila
                        $fila = $objeto->extraerFilas();

                        // Guardar el nombreAdministrador en la sesion
                        $_SESSION["idUsuario"]=$fila["nombreAdministrador"];
                        $_SESSION["tipo"] = 'admin';

                        // echo 'correcto';

                        // Lo lleva a la pagina de los rankins
                        header('Location: PaginaAdministrador.php');
                    }
                    else
                    {
                        // Muestra un error de que la contraseña o usuario es incorrecto.
                        echo '<h2>Error</h2>';
                        echo '<p class="errorup">El usuario o el password son incorrecto.</p>';
                        echo '<button class="volver"><a href="InicioSesion-Administrador.php">Volver</a></button>';
                    }
                }
            echo '</div>';
        ?>
    </body>
</html>



