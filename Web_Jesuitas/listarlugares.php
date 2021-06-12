<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Modificar Jesuita</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php
            echo '<div id="contenedor">';
                // Traer la clase
                require_once 'operaciones.php';
                // Crear un objeto con la clase
                $objeto=new operaciones();

                // Si existe la variable eliminar
                if(isset($_GET["eliminar"]))
                {
                    // Si no existe la variable enviar
                    if(!isset($_POST["Enviar"]))
                    {
                        $consulta = "SELECT * FROM lugar WHERE idLugar=".$_GET["eliminar"].";";
                        //print_r($consulta);
                        $objeto->realizarConsultas($consulta);

                        // Si devuelve filas, existe ese jesuita
                        if($objeto->comprobarFila()>0)
                        {
                            $fila = $objeto->extraerFilas();

                            echo '<form id="formulariopreguntar" method="post">';
                                echo '<label>Estas de seguro de eliminar el lugar '.$fila["nombreLugar"].'?</label>';
                                echo '<input type="radio" name="pregunta" value="si">Si';
                                echo '<input type="radio" name="pregunta" value="no" checked>No';
                                echo '<input type="submit" name="Enviar" value="Enviar">';
                            echo '</form>';
                        }
                        else // No existe
                        {
                            echo '<p>Ese lugar no existe</p>';
                        }
                    }
                    else
                    {
                        // Si el radio, selecciono si, eliminara la maquina
                        if($_POST["pregunta"] == 'si')
                        {
                            $consulta = "DELETE FROM lugar WHERE idLugar='".$_GET["eliminar"]."'";
                            //print_r($consulta);
                            $objeto->realizarConsultas($consulta);

                            // Si devuelve fila, fue porque lo elimino
                            if($objeto->comprobar()>0)
                            {
                                echo '<p>Se borro el lugar correctamente</p>';
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
                                header('Location: listarlugares.php');
                            }
                        }
                    }
                    echo '<button class="volver"><a href="listarlugares.php">Volver</a></button>';
                }
                else // SI no existe la variable eliminar, muestra la lista.
                {
                    echo '<h2>Lista Lugares</h2>';

                    // Consulta para recoger toda la info de maquina.
                    $consulta = "SELECT * FROM lugar";
                    //print_r($consulta);
                    $objeto->realizarConsultas($consulta);

                    // Si devuelve, hay jesuitas
                    if($objeto->comprobar()>0)
                    {
                        echo '<table>';
                        echo '<tr><th>Nombre del Lugar</th><th>Editar</th><th>Eliminar</th></tr>';
                        while ($fila = $objeto->extraerFilas())
                        {
                            $idjesuita = $fila["idLugar"];
                            echo '<tr>';
                            // Nombre del Jesuita
                            echo '<td>'.$fila["nombreLugar"].'</td>';

                            // Editar Maquina
                            echo '<td><a href="modificarlugares.php?id='.$idjesuita.'">Editar</a></td>';

                            // Eliminar Maquina
                            echo '<td><a href="listarlugares.php?eliminar='.$idjesuita.'">Eliminar</a></td>';
                            
                            echo '</tr>';
                        }
                        echo '</table>';
                    }
                    else // Aun no se creo ninguna jesuita
                    {
                        echo '<p>Aun no hay lugares registrados</p>';
                    }
                    echo '</br><button class="volver"><a href="0-rankingvisitas.php">Volver</a></button>';
                }
            echo '</div>';
        ?>
    </body>
</html>
