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

            echo '<h2>Lista de Maquinas</h2>';

            // Si existe la variable eliminar
            if(isset($_GET["eliminar"]))
            {
                if(!isset($_POST["Enviar"]))
                {
                    echo '<form id="formulariopreguntar" method="post">';
                        echo '<label>Estas de seguro de eliminar la maquina '.$_GET["eliminar"].'?</label>';
                        echo '<input type="radio" name="pregunta" value="si">Si';
                        echo '<input type="radio" name="pregunta" value="no" checked>No';
                        echo '<input type="submit" name="Enviar" value="Enviar">';
                    echo '</form>';
                }
                else
                {
                    // Si el radio, selecciono si, eliminara la maquina
                    if($_POST["pregunta"] == 'si')
                    {
                        $consulta = "DELETE FROM maquina WHERE ip='".$_GET["eliminar"]."'";
                        print_r($consulta);
                        $objeto->realizarConsultas($consulta);

                        // Si devuelve fila, fue porque lo elimino
                        if($objeto->comprobar()>0)
                        {
                            echo '<p>Se borro la maquina correctamente</p>';
                        }
                        else // En caso que no se pudo eliminar
                        {
                            echo '<p>Hubo un problema inesperado :S </p>';
                        }
                    }
                    else // SI no selecciono el si
                    {
                        if($_POST["pregunta"] == 'no') // Si selecciono no, regresa al listado
                        {
                            header('Location: listarmaquinas.php');
                        }
                    }
                }

                echo '<button class="volver"><a href="listarmaquinas.php">Volver</a></button>';
            }
            else // SI no existe, muestra la lista.
            {
                $consulta = "SELECT * FROM maquina";
                $objeto->realizarConsultas($consulta);

                if($objeto->comprobar()>0)
                {
                    echo '<table>';
                        echo '<tr><th>Ip</th><th>Editar</th><th>Eliminar</th></tr>';
                        while ($fila = $objeto->extraerFilas())
                        {

                            echo '<tr>';
                                // Ip
                                echo '<td>'.$fila["ip"].'</td>';

                                // Editar Maquina
                                echo '<td><a href="./admin/modificar_maquina.php?ip='.$fila["ip"].'">Editar</a></td>';

                                // Eliminar Maquina
                                echo '<td><a href="listarmaquinas.php?eliminar='.$fila["ip"].'">Eliminar</a></td>';

                            echo '</tr>';
                        }
                    echo '</table>';
                }
                else
                {
                    echo '<p>Aun no hay maquinas registradas</p>';
                }

                echo '<button class="volver"><a href="0-rankingvisitas.php">Volver</a></button>';
            }


        echo '</div>';
        ?>
    </body>
</html>