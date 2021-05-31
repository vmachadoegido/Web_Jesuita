<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div id="general">
            <img src="imagenes/logotipo.png">

            <h3>JESUITAS POR EL MUNDO</h3>
            <?php
                require_once 'operaciones.php';
                $objeto=new operaciones();

                // Inicio Sesion
                session_start();

                // Pruebas, finje ser la maquina 1
                $_SESSION["jesuita"] = '1';
                echo $_SESSION["jesuita"];


                // Hasta que no se envia el lugar
                if(!isset($_POST["visitar"]))
                {

/* Cokkiee ultimas tres visitas -------------------------------------------------------- */
                    echo '<div id="tresvisitas">';
                        echo '<h2>Ultimas 3 Visita Tuyas</h2>';
                        // SI no existe la cookie lugares_visitados, mostrara un mensaje
                        if(!isset($_COOKIE['lugares_visitados']))
                        {
                            echo '<td>Aun no has visitado ningun lugar</td>';
                        }
                        else // Si existe la cookie lugares_visitados mostra lo guardado en esta
                        {
                            echo '<table>';
                                echo '<tr>';
                                //echo '<td>' . $_COOKIE['lugares_visitados'] . '</td>';
                                echo '<th>Lugares</th>';

                                // Ordena el valor menor al mayor | 0 1 2
                                sort($_COOKIE['lugares_visitados']);

                                //Recorre toda la array de la cookie lugares_visitados
                                foreach($_COOKIE['lugares_visitados'] as $lugar)
                                {
                                    echo '<td>'.$lugar.'</td>';
                                }
                                echo '</tr>';
                            echo '</table>';
                        }
                    echo '</div>';

//                    echo $_COOKIE['lugares_visitados'][0].'-0</br>';
//                    echo $_COOKIE['lugares_visitados'][1].'-1</br>';
//                    echo $_COOKIE['lugares_visitados'][2].'-2</br>';



/* Despegable -----------------------------------------------------------------------------------------------------*/

                    // Hacer la consulta de lugar ordenado por el nombre
                    $consulta = "SELECT maquina.ip, maquina.jesuita, lugar.idLugar, lugar.nombreLugar FROM maquina INNER JOIN lugar ON lugar.idLugar = maquina.lugar ORDER BY lugar.nombreLugar";

                    $objeto->realizarConsultas($consulta);

                    // Comprueba que le devuelve fila
                    if ($objeto->comprobarFila()>0)
                    {
                        // Formulario
                        echo '<form action="Visitar-Lugares.php" METHOD="POST">';
                            echo '<select name="lugar">';
                                echo '<option value="no">Seleciona un Lugar</option>';
                                while ($fila = $objeto->extraerFilas())
                                {
                                    // Visualiza el nombreLugar y al enviar envia la idLugar
                                    echo '<option value="'.$fila["idLugar"].'">'.$fila["nombreLugar"].'</option>';
                                }
                            echo '</select>';
                            echo '<input type="submit" value="Visitar" name="visitar"/>';
                        echo '</form>';

                        echo '<a href="0-rankingvisitas.php" class="boton"> Volver </a>';
                    }
                    else // En caso que no haya lugares, devuelve un erro.
                    {
                       echo '<p>Error - Aun no hay lugares</p>';
                    }

                }
                else // Cuando se le da el boton enviar.
                {
                    // Guardo lo enviado en una variable.
                    $lugar= $_POST["lugar"];

                    // En caso de no selecionar un lugar da error.
                    if($lugar=='no')
                    {
                        echo '<p>Error - No has selecionado ningun lugar</p>';
                    }
                    else // En caso de haber selecionado otro lugar.
                    {
                        // Consulta para comprobar que esa idLugar pertenece a una maquina
                        $consulta= "SELECT * FROM maquina WHERE lugar='$lugar';";
                        //print_r($consulta);
                        $objeto->realizarConsultas($consulta);

                        // En caso de devolver fila, existe ese lugar que es de una maquina.
                        if ($objeto->comprobarFila()>0)
                        {
                            // Extraigo las filas
                            $fila = $objeto->extraerFilas();

                            // Guardo la idJesuita en una variable.
                            $jesuita = $fila["jesuita"];


                            // Consulta para hacer la visita
                            $consulta = 'INSERT INTO visita (idLugar, idJesuita, fechaHora) VALUES ('.$lugar.' , '.$_SESSION["jesuita"].', now());';
                            //print_r($consulta);
                            $objeto->realizarConsultas($consulta);

                            // Guardo la id del error
                            $numeroerror = $objeto->error();

                            // Si esta rellena $numeroerror, significa que hubo un error al hacer la consulta. check o unique.
                            if(!empty($numeroerror))
                            {
                                // Error CONSTRAINT - Check
                                if($numeroerror = 4025)
                                {
                                    echo '<p>No te puedes visitar a ti mismo</p>';
                                }
                                // Error - Entrada Duplicada - C.Unique
                                if ($numeroerror = 1062)
                                {
                                    echo '<p>No puedes visitar esta ciudad mas veces.</p>';
                                }
                            }
                            else // No hubo error
                            {
                                // Consulta del la idLugar visitado.
                                $consulta = "SELECT * FROM lugar WHERE idLugar= $lugar";
                                //print_r($consulta);
                                $objeto->realizarConsultas($consulta);

                                // Comprueba si devuelve fila la consulta, por lo tanto esa idLugar exita.
                                if ($objeto->comprobarFila() > 0) {
                                    // Extraigo las filas
                                    $fila = $objeto->extraerFilas();
                                    // Muestra un mensaje del lugar visitado
                                    echo '<p>Hiciste una visita a ' . $fila["nombreLugar"] . '</p>';

                                    // Guardo el nombre del lugar en una variable, para facilitar el codigo.
                                    $lugarvisitado = $fila["nombreLugar"];

                                    // Si esta vacio la cookie lugares_visitados[0] crea la cookie.
                                    if (empty($_COOKIE['lugares_visitados'][0])) {
                                        // Crea la cookie lugares_visitados[0] con el valor del lugar
                                        setcookie('lugares_visitados[0]', $lugarvisitado, time() + 3600);
                                    }
                                    else // Si no esta vacia la cookie lugares_visitados[0]
                                    {
                                        // Si esta vacio la cookie lugares_visitados[1]
                                        if (empty($_COOKIE['lugares_visitados'][1])) {
                                            // Guardo la cookie lugares_visitados[0] en una auxiliar
                                            $auxiliar = $_COOKIE['lugares_visitados'][0];

                                            // Creo una cookie lugares_visitados[0] con el lugar visitado
                                            setcookie('lugares_visitados[0]', $lugarvisitado, time() + 3600);

                                            // Creo una cookie lugares_visitados[1] con el valor del auxiliar
                                            setcookie('lugares_visitados[1]', $auxiliar, time() + 3600);

                                        } else // Si no esta vacio lugares_visitados[1]
                                        {
                                            // Si esta vacio la cookie lugares_visitados[2]
                                            if (empty($_COOKIE['lugares_visitados'][2])) {
                                                // Guardo la cookie lugares_visitados[0] en una auxiliar
                                                $auxiliar1 = $_COOKIE['lugares_visitados'][0];
                                                $auxiliar2 = $_COOKIE['lugares_visitados'][1];

                                                // Creo una cookie lugares_visitados[2] con el valor del auxiliar
                                                setcookie('lugares_visitados[2]', $auxiliar2, time() + 3600);

                                                // Creo una cookie lugares_visitados[1] con el valor del auxiliar
                                                setcookie('lugares_visitados[1]', $auxiliar1, time() + 3600);

                                                // Creo una cookie lugares_visitados[0] con el lugar visitado
                                                setcookie('lugares_visitados[0]', $lugarvisitado, time() + 3600);
                                            } else // Si esta rellena lugares_visitados[2]
                                            {
                                                // Guardo la cookie lugares_visitados[0] en una auxiliar
                                                $auxiliar1 = $_COOKIE['lugares_visitados'][0];
                                                $auxiliar2 = $_COOKIE['lugares_visitados'][1];

                                                // Creo una cookie lugares_visitados[0] con el lugar visitado
                                                setcookie('lugares_visitados[0]', $lugarvisitado, time() + 3600);

                                                // Creo una cookie lugares_visitados[1] con el valor del auxiliar1
                                                setcookie('lugares_visitados[1]', $auxiliar1, time() + 3600);

                                                // Creo una cookie lugares_visitados[2] con el valor del auxiliar2
                                                setcookie('lugares_visitados[2]', $auxiliar2, time() + 3600);

                                            }
                                        }
                                    }
                                }
                            }
                        }
                        else // Si no devuelve filas eselugar no tiene ninguna maquina
                        {
                            echo '<p>Error - Ese lugar aun no se asigno a ningun jesuita</p>';
                        }
                    }
                    // Boton de Volver
                    echo '<a href="Visitar-Lugares.php" class="boton"> Volver </br></a>';
                }
            ?>
        </div>
    </body>
</html>