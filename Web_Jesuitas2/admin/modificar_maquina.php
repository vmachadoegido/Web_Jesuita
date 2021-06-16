<!doctype html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Jesuitas Viajeros</title>
        <link rel="stylesheet" href="estilo.css">
    </head>
    <body>
        <?php
            echo '<div id="contenedor">';

                // Traer la clase
                require_once 'clasephp.php';
                // Crear un objeto con la clase
                $objeto=new clasephp();

                echo '<h2>Modificar Maquina</h2>';

                // Si esta vacio
                if(!isset($_GET["ip"]))
                {
                    header('Location: ../listarmaquinas.php');
                }
                else
                {
                    $ipmaquina2 = $_GET["ip"];

                    // Consulta para saber si la ip exista y traer la info de esa maquina.
                    $consulta = "SELECT ip, nombreAlumno, lugar, jesuita FROM maquina WHERE ip='".$ipmaquina2."';";
                    //print_r($consulta);
                    $objeto->realizarConsultas($consulta);

                    // Extraigo las filas de la consulta.
                    $fila = $objeto->extraerFilas();
                    //Guardo las filas en variables.
                    $ipmaquina = $fila["ip"];
                    $nombrealumno = $fila["nombreAlumno"];
                    $lugarmaquina = $fila["lugar"];
                    $jesuitamaquina = $fila["jesuita"];


                    if(!isset($_POST["Modificar"]))
                    {
                        echo '<form METHOD="POST">';

                        // La ip de la maquina a modificar.
                        echo '<input type="text" placeholder="Ip de tu Maquina *" name="ip" value="' . $ipmaquina. '" readonly> ';

                        // El nombre del alumno de la maquina.
                        echo '<input type="text" placeholder="Nombre del Alumno" name="nombreAlumno" value="'.$nombrealumno.'" required>';

                        // Lugar
                        // Si esta vacia, significa que no tiene maquina asignada
                        if(empty($lugarmaquina))
                        {
                            echo '<select name="lugar">';

                            // Consulta muestra los lugares no asignados
                            $consulta = "SELECT lugar.idLugar, lugar.nombreLugar FROM lugar LEFT JOIN maquina ON lugar.idLugar = maquina.lugar WHERE maquina.lugar IS NULL OR maquina.lugar = '$lugarmaquina';";
                            $objeto->realizarConsultas($consulta);

                            echo '<option>No tiene lugar asignado</option>';
                            if ($objeto->comprobar()>0)
                            {
                                while ($fila = $objeto->extraerFilas())
                                {
                                    echo '<option value="'.$fila["idLugar"].'">'.$fila["nombreLugar"].'</option>';
                                }
                            }
                            else
                            {
                                echo '<p class="centrar"> Aun no hay lugares </p>';
                            }
                            echo '</select>';
                        }
                        else // Si esta rellena, significa que esta asignada a una maquina.
                        {
                            // Consulta para sacar el primer lugar de la maquina.
                            $consulta = "SELECT idLugar, nombreLugar FROM lugar WHERE idLugar = '".$lugarmaquina."';";
                            //print_r($consulta);
                            $objeto->realizarConsultas($consulta);

                            // Si devuelve fila, lo muestra
                            if ($objeto->comprobarSelect()>0)
                            {
                                // Extraigo las filas
                                $fila = $objeto->extraerFilas();

                                // Si esta rellena $fila["nombreLugar"]
                                if(!empty($fila["nombreLugar"]))
                                {
                                    echo '<select name="lugar">';
                                    // Opcion del lugar de la maquina
                                    echo '<option value="'.$fila["idLugar"].'">'.$fila["nombreLugar"].'</option>';

                                    // Consulta muestra los lugares no asignados
                                    $consulta = "SELECT lugar.idLugar, lugar.nombreLugar FROM lugar LEFT JOIN maquina ON lugar.idLugar = maquina.lugar WHERE maquina.lugar IS NULL";
                                    //print_r($consulta);
                                    $objeto->realizarConsultas($consulta);

                                    // Si devuelve filas, significa que aun quedan lugar por asignar.
                                    if ($objeto->comprobar()>0)
                                    {
                                        // Va mostrando cada fila de la consulta, la id y nombre del lugar.
                                        while ($fila = $objeto->extraerFilas())
                                        {
                                            echo '<option value="'.$fila["idLugar"].'">'.$fila["nombreLugar"].'</option>';
                                        }
                                    }
                                    else // No hay lugares ya asignados.
                                    {
                                        echo '<p class="centrar"> Aun no hay lugares </p>';
                                    }
                                    echo '</select>';
                                }
                                else // No tiene un lugar asignado
                                {
                                    echo '<option value="no">Aun no tiene un lugar asignado</option>';
                                }
                            }
                            else // Por si pasa, al eliminar/modificar esa ip de la maquina
                            {
                                echo '<p>Esa ip dejo de existir</p>';
                            }
                        }


                        // Jesuitas
                        // Si esta vacia, significa que no tiene maquina asignada
                        if(empty($lugarmaquina))
                        {
                            echo '<select name="jesuita">';

                            // Consulta muestra los lugares no asignados
                            $consulta = "SELECT jesuita.idJesuita, jesuita.nombreJesuita FROM jesuita LEFT JOIN maquina ON jesuita.idJesuita = maquina.jesuita WHERE maquina.jesuita IS NULL OR maquina.jesuita = '$jesuitamaquina';";
                            print_r($consulta);
                            $objeto->realizarConsultas($consulta);

                            echo '<option>No tiene jesuita asignado</option>';
                            if ($objeto->comprobar()>0)
                            {
                                while ($fila = $objeto->extraerFilas())
                                {
                                    echo '<option value="'.$fila["idJesuita"].'">'.$fila["nombreJesuita"].'</option>';
                                }
                            }
                            else
                            {
                                echo '<p class="centrar"> Aun no hay jesuita </p>';
                            }
                            echo '</select>';
                        }
                        else // Si esta rellena, significa que esta asignada a una maquina.
                        {
                            // Consulta para sacar el primer lugar de la maquina.
                            $consulta = "SELECT idJesuita, nombreJesuita FROM jesuita WHERE idJesuita= '".$jesuitamaquina."';";
                            //print_r($consulta);
                            $objeto->realizarConsultas($consulta);

                            // Si devuelve fila, lo muestra
                            if ($objeto->comprobarSelect()>0)
                            {
                                // Extraigo las filas
                                $fila = $objeto->extraerFilas();

                                // Si esta rellena $fila["nombreLugar"]
                                if(!empty($fila["nombreJesuita"]))
                                {
                                    echo '<select name="jesuita">';
                                    // Opcion del lugar de la maquina
                                    echo '<option value="'.$fila["idJesuita"].'">'.$fila["nombreJesuita"].'</option>';

                                    // Consulta muestra los lugares no asignados
                                    $consulta = "SELECT jesuita.idJesuita, jesuita.nombreJesuita FROM jesuita LEFT JOIN maquina ON jesuita.idJesuita = maquina.jesuita WHERE maquina.jesuita IS NULL;";
                                    //print_r($consulta);
                                    $objeto->realizarConsultas($consulta);

                                    // Si devuelve filas, significa que aun quedan lugar por asignar.
                                    if ($objeto->comprobar()>0)
                                    {
                                        // Va mostrando cada fila de la consulta, la id y nombre del lugar.
                                        while ($fila = $objeto->extraerFilas())
                                        {
                                            echo '<option value="'.$fila["idJesuita"].'">'.$fila["nombreJesuita"].'</option>';
                                        }
                                    }
                                    else // No hay lugares ya asignados.
                                    {
                                        echo '<p class="centrar"> Aun no hay jesuitas </p>';
                                    }
                                    echo '</select>';
                                }
                                else // No tiene un lugar asignado
                                {
                                    echo '<option value="no">Aun no tiene un jesuita asignado</option>';
                                }
                            }
                            else // Por si pasa, al eliminar/modificar esa ip de la maquina
                            {
                                echo '<p>Esa ip dejo de existir</p>';
                            }
                        }

                        // Boton Enviar
                        echo '<input type="submit" name="Modificar" value="Modificar">';
                        echo '</form>';

                        echo '<button class="volver"><a href="../listarmaquinas.php">Volver</a></button>';

                    }
                    else
                    {
                        // Si esta vacio
                        if(empty($ipmaquina))
                        {
                            echo '<p>Hubo un problema fatal</p>';
                        }
                        else  // SI no esta vacio
                        {
                            // Actualizar los datos de la maquina

                            // SI esta relleno el nombreAlumno
                            if(!empty($_POST["nombreAlumno"]))
                            {
                                $consulta = "UPDATE maquina SET nombreAlumno='".$_POST["nombreAlumno"]."' WHERE ip='".$ipmaquina."'";
                                //printf($consulta);
                                $objeto->realizarConsultas($consulta);
                            }

                            // SI esta relleno el lugar
                            if(!empty($_POST["nombreAlumno"]))
                            {
                                $consulta = "UPDATE maquina SET lugar=".$_POST["lugar"]." WHERE ip='".$ipmaquina."'";
                                //printf($consulta);
                                $objeto->realizarConsultas($consulta);
                            }

                            // SI esta relleno el lugar
                            if(!empty($_POST["jesuita"]))
                            {
                                $consulta = "UPDATE maquina SET jesuita=".$_POST["jesuita"]." WHERE ip='".$ipmaquina."'";
                                //printf($consulta);
                                $objeto->realizarConsultas($consulta);
                            }

                            echo '<p>Modificado correctamente</p>';

                        }

                        echo '<button class="volver"><a href="../listarmaquinas.php">Volver</a></button>';
                    }
                }



            echo '</div>';
        ?>
    </body>
</html>
