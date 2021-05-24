<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Eliminar Usuario</title>
        <link rel="stylesheet" href="estilo.css">
    </head>
    <body>
        <?php
            session_start();
// asd
            echo '<div id="contenedor">';
                if(!isset($_POST["confirmacion"]))
                {
                    echo '<form action="" METHOD="POST">';
                    echo '<label class="centrar2">Seguro que quieres eliminar el usuario?</label>';
                    echo '<label class="centrar2">'.$_POST["ip"].'</label>';

                    echo '<input type="checkbox" name="confirmacion" value="SI">Si';
                    echo '<input type="checkbox" name="confirmacion" value="No">No';

                    echo '<input type="submit" value="Enviar" name="enviar"/>';
                    echo '</form>';
                }
                else
                {
                    if($_POST["confirmacion"]=='SI')
                    {
                        echo 'hola';
                        echo $_POST["ip"];
                    }
                    if($_POST["confirmacion"]=='NO')
                    {
                        echo 'adios';
                    }
                }

                echo '<button class="volver"><a href="PaginaAdministrador.php?opcion=usuario&eliminar">Volver</a></button>';
            echo '</div>';
        ?>
    </body>
</html>