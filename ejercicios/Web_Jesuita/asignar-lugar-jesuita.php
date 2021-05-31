<!doctype html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Asignar Lugar & Jesuita</title>
        <link rel="stylesheet" href="Nueva carpeta/style.css">
    </head>
    <body>
        <div id="general">
            <img src="Nueva carpeta/imagenes/logotipo.png">

            <h3>Asignar Lugar y Jesuita</h3>
            <?php
                // Trae las operaciones
                require_once 'operaciones.php';
                // Crea el objeto de operaciones
                $objeto=new operaciones();

                // Inicio Sesion
                session_start();


                // Hasta que no se le da enviar
                if(!isset($_POST["Asignar"]))
                {
                    // Formulario
                    echo '<form method="post">';
                        echo '<table id="agregarmasinfo">';
                            echo '<tr>';
                                echo '<td><label for="nombremaquina">Ip de la Maquina</label></td>';
                                echo '<td><input type="text" name="nombremaquina" placeholder="Ip de la Maquina"/></td>';
                            echo '</tr>';
                            echo '<tr>';
                                // Consulta para mostrar los lugares que no fueron asignados a una maquina
                                $consulta = "SELECT lugar.idLugar, lugar.nombreLugar FROM lugar  LEFT JOIN maquina  ON lugar.idLugar = maquina.lugar  WHERE maquina.lugar IS NULL  ORDER BY lugar.nombreLugar;";
                                $objeto->realizarConsultas($consulta);

                                // Label de lugar
                                echo '<td><label for="lugar">Lugar</label></td>';

                                // Comprueba que devolvio filas, por lo tanto hay lugares sin asignar
                                if ($objeto->comprobarFila()>0)
                                {
                                    echo '<td><select name="lugar">';
                                        echo '<option value="no">Seleciona un Lugar</option>';
                                        while ($fila = $objeto->extraerFilas())
                                        {
                                            // Visualiza el nombreLugar y al enviar envia la idLugar
                                            echo '<option value="'.$fila["idLugar"].'">'.$fila["nombreLugar"].'</option>';
                                        }
                                    echo '</select><td>';
                                }
                            echo '</tr>';
                            echo '<tr>';
                            // Consulta para mostrar los lugares que no fueron asignados a una maquina
                            $consulta = "SELECT jesuita.idJesuita, jesuita.nombreJesuita FROM jesuita  LEFT JOIN maquina  ON jesuita.idJesuita = maquina.jesuita  WHERE maquina.jesuita IS NULL;";
                            $objeto->realizarConsultas($consulta);

                            // Label de lugar
                            echo '<td><label for="jesuita">Jesuita</label></td>';

                            // Comprueba que devolvio filas, por lo tanto hay lugares sin asignar
                            if ($objeto->comprobarFila()>0)
                            {
                                echo '<td><select name="jesuita">';
                                echo '<option value="no">Seleciona un Jesuita</option>';
                                while ($fila = $objeto->extraerFilas())
                                {
                                    // Visualiza el nombreLugar y al enviar envia la idLugar
                                    echo '<option value="'.$fila["idJesuita"].'">'.$fila["nombreJesuita"].'</option>';
                                }
                                echo '</select><td>';
                            }
                            echo '</tr>';
                        echo '</table>';
                        echo '</br><input type="submit" name="Asignar" value="Asignar" /></br>';
                    echo '</form>';

                    // Boton para regresar
                    echo '</br><a href="0-rankingvisitas.php" class="boton"> Volver </a></br>';

                }
                else // Ha enviado el boton asignar
                {
                    // Si esta vacio el nombremaquina
                    if(empty($_POST["nombremaquina"]))
                    {
                        echo '<p>Introduce la ip de la maquina</p>';

                        echo '</br><a href="asignar-lugar-jesuita.php" class="boton"> Volver </a></br>';
                    }
                    else // Si esta relleno el nombremaquina
                    {
                        // Consulta para saber si existe esa ip
                        $consulta = "SELECT ip FROM maquina WHERE ip='".$_POST["nombremaquina"]."';";
                        //print_r($consulta);
                        $objeto->realizarConsultas($consulta);

                        // Existe esa ip
                        if($objeto->comprobarFila()>0)
                        {
                            // Si lugar y jesuita, no se seleciono nada
                            if(($_POST["lugar"] == 'no') AND ($_POST["jesuita"] == 'no'))
                            {
                                echo '<p>Seleciona un lugar o jesuita para asignar</p>';

                                echo '</br><a href="asignar-lugar-jesuita.php" class="boton"> Volver </a></br>';
                            }
                            else //Se seleciono alguno de ambos
                            {
                                // Si estan rellenos ambos
                                if((!empty($_POST["lugar"])) AND (!empty($_POST["jesuita"])))
                                {
                                    // Actualizar el lugar y jesuita de esa maquina
                                    $consulta = "UPDATE maquina SET lugar=".$_POST["lugar"].", jesuita=".$_POST["jesuita"]." WHERE ip = '".$_POST["nombremaquina"]."'";
                                    //print_r($consulta);
                                    $objeto->realizarConsultas($consulta);

                                    // Se actualizo el lugar y jesuita correctamente.
                                    if ($objeto->comprobar()>0)
                                    {
                                        echo '<p>Se actualizo los datos de la maquina</p>';

                                        echo '</br><a href="asignar-lugar-jesuita.php" class="boton"> Volver </a></br>';
                                    }
                                }
                                else // Si esta relleno uno de ambos
                                {
                                    echo 'hola';
                                    // Si solo se rellena lugar
                                    if(!empty($_POST["lugar"]))
                                    {
                                        // Actualizar el lugar y jesuita de esa maquina
                                        $consulta = "UPDATE maquina SET lugar='".$_POST["lugar"]."' WHERE ip = '".$_POST["nombremaquina"]."'";
                                        //print_r($consulta);
                                        $objeto->realizarConsultas($consulta);

                                        // Se actualizo el lugar y jesuita correctamente.
                                        if ($objeto->comprobar()>0)
                                        {
                                            echo '<p>Se asigno correctamente el lugar a la maquina</p>';

                                            echo '</br><a href="asignar-lugar-jesuita.php" class="boton"> Volver </a></br>';
                                        }
                                    }
                                    else
                                    {
                                        // Actualizar el lugar y jesuita de esa maquina
                                        $consulta = "UPDATE maquina SET jesuita='".$_POST["jesuita"]."' WHERE ip = '".$_POST["nombremaquina"]."'";
                                        //print_r($consulta);
                                        $objeto->realizarConsultas($consulta);

                                        // Se actualizo el lugar y jesuita correctamente.
                                        if ($objeto->comprobar()>0)
                                        {
                                            echo '<p>Se asigno correctamente el jesuita a la maquina</p>';

                                            echo '</br><a href="asignar-lugar-jesuita.php" class="boton"> Volver </a></br>';
                                        }
                                    }
                                }
                                echo 'hola1';
                            }
                        }
                        else // En caso que nod evuelva filas, por lo tanto no existe.
                        {
                            echo '<p>Esa ip no existe</p>';

                            echo '</br><a href="asignar-lugar-jesuita.php" class="boton"> Volver </a></br>';
                        }

                    }
                }
            ?>
        </div>
    </body>
</html>