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

                // Traer la clase
                require_once 'clasephp.php';
                // Crear un objeto con la clase
                $objeto=new clasephp();

                echo '<h2>Modificar Maquina</h2>';

                // Si existe la cookie ["valoresformulario"][0], guada su valor en $ipmaquina
                if(isset($_COOKIE["valoresformulario"][0]))
                {
                    $ipmaquina= $_COOKIE["valoresformulario"][0];

                }
                else // Si no existe
                {
                    // Si existe un $_POST$_POST["ip"], guarda esa variable en $ipmaquina
                    if(isset($_GET["ip"]))
                    {
                        $ipmaquina = $_GET["ip"];
                    }
                    else // SI no existe $_POST["ip"], borra la cookies y reediciona a la lista de maquinas.
                    {
                        setcookie('valoresformulario[0]', '' , time()-60);
                        setcookie('valoresformulario[1]', '' , time()-60);
                        setcookie('valoresformulario[2]', '' , time()-60);
                        setcookie('valoresformulario[3]', '' , time()-60);
                        setcookie('valoresformulario[4]', '' , time()-60);
                        header('Location: PaginaAdministrador.php?opcion=usuario&opcionusuario=listar');
                    }

                }

                // Consulta para saber si la ip exista y traer la info de esa maquina.
                $consulta = "SELECT ip, nombreAlumno, lugar, jesuita FROM maquina WHERE ip='".$ipmaquina."';";
                $objeto->realizarConsultas($consulta);

                // Si la variable $_POST["Modificar"], no existe
                if(!isset($_POST["Modificar"]))
                {
                    // Extraigo las filas de la consulta.
                    $fila = $objeto->extraerFilas();
                    //Guardo las filas en variables.
                    $ipmaquina = $fila["ip"];
                    $nombrealumno = $fila["nombreAlumno"];
                    $lugarmaquina = $fila["lugar"];
                    $jesuitamaquina = $fila["jesuita"];

                    echo '<form METHOD="POST">';
                        // La ip de la maquina a modificar.
                        echo '<input type="text" placeholder="Ip de tu Maquina *" name="ip" value="' . $ipmaquina. '" readonly> ';

                        // Si existe $_COOKIE["valoresformulario"][1] muestra el valor editado.
                        if(isset($_COOKIE["valoresformulario"][1]))
                        {
                            echo '<input type="text" placeholder="Ip de tu Maquina Nueva" name="ipnew" value="'.$_COOKIE["valoresformulario"][1].'">';
                        }
                        else // Si no, estara vacio.
                        {
                            echo '<input type="text" placeholder="Ip de tu Maquina Nueva" name="ipnew">';
                        }

                        // Si exixte $_COOKIE["valoresformulario"][2] muestra el valor editado.
                        if(isset($_COOKIE["valoresformulario"][2]))
                        {
                            echo '<input type="text" placeholder="Nombre del Alumno" name="nombreAlumno" value="'.$_COOKIE["valoresformulario"][2].'">';
                        }
                        else // Si no, estara el valor de la consulta.
                        {
                            echo '<input type="text" placeholder="Nombre del Alumno" name="nombreAlumno" value="'.$nombrealumno.'">';
                        }

                        // Poner contraseña
                        echo '<input type="password" placeholder="password" name="password">';

/*---------------------------------------------------------*/
                        // Seleccion del Lugar

                        if(isset($_COOKIE["valoresformulario"][3]))
                        {
                            // Consulta
                            $consulta = "SELECT lugar.idLugar, lugar.nombreLugar FROM lugar LEFT JOIN maquina ON lugar.idLugar = maquina.lugar WHERE maquina.lugar IS NULL OR maquina.lugar = '$lugarmaquina';";
                            //print_r($consulta);
                            $objeto->realizarConsultas($consulta);

                            echo '<select name="lugar">';
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
                        else // Si no existe la cookie lugar
                        {
                            // Consulta muestra los lugares no asignados
                            $consulta = "SELECT maquina.ip, lugar.idLugar, lugar.nombreLugar  FROM maquina RIGHT JOIN lugar ON maquina.lugar = lugar.idLugar WHERE maquina.lugar is NULL ORDER BY lugar.nombreLugar;";
                            $objeto->realizarConsultas($consulta);

                            //print_r($consulta);

                            echo '<select name="lugar">';
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

/*--------------------------------------------------------------------------------------------------*/
                        // Seleccion del Jesuita

                        if(isset($_COOKIE["valoresformulario"][4]))
                        {
                            // Consulta
                            $consulta = "SELECT jesuita.idJesuita, jesuita.nombreJesuita FROM jesuita LEFT JOIN maquina ON maquina.jesuita = jesuita.idJesuita WHERE maquina.jesuita IS NULL OR maquina.jesuita = '$lugarmaquina';";
                            //print_r($consulta);
                            $objeto->realizarConsultas($consulta);

                            echo '<select name="jesuita">';
                            if ($objeto->comprobar()>0)
                            {
                                while ($fila = $objeto->extraerFilas())
                                {
                                    echo '<option value="'.$fila["idjesuita"].'">'.$fila["nombreJesuita"].'</option>';
                                }
                            }
                            else
                            {
                                echo '<p class="centrar"> Aun no hay jesuita </p>';
                            }
                            echo '</select>';
                        }
                        else // Si no existe la cookie lugar
                        {
                            // Consulta muestra los lugares no asignados
                            $consulta = "SELECT maquina.ip, jesuita.idJesuita, jesuita.nombreJesuita  FROM maquina RIGHT JOIN jesuita ON maquina.jesuita = jesuita.idJesuita WHERE maquina.jesuita is NULL ORDER BY jesuita.nombreJesuita;";
                            $objeto->realizarConsultas($consulta);

                            //print_r($consulta);

                            echo '<select name="jesuita">';
                            if ($objeto->comprobar()>0)
                            {
                                while ($fila = $objeto->extraerFilas())
                                {
                                    echo '<option value="'.$fila["idjesuita"].'">'.$fila["nombreJesuita"].'</option>';
                                }
                            }
                            else
                            {
                                echo '<p class="centrar"> Aun no hay jesuitas </p>';
                            }
                            echo '</select>';
                        }

                        echo '<input type="submit" value="Modificar" name="Modificar">';
                    echo '</form>';

                    echo '<button class="volver"><a href="../listarmaquinas.php">Volver</a></button>';
                }
                else
                {
                    if(!empty($_POST["nombreAlumno"]))
                    {

                    }
                    setcookie('valoresformulario[0]', ''.$_POST["ip"].'' , time()+60);
                    setcookie('valoresformulario[1]', ''.$_POST["ipnew"].'' , time()+60);
                    setcookie('valoresformulario[2]', ''.$_POST["nombreAlumno"].'' , time()+60);
                    setcookie('valoresformulario[3]', ''.$_POST["lugar"].'' , time()+60);
                    setcookie('valoresformulario[4]', ''.$_POST["jesuita"].'' , time()+60);

                    echo '<button class="volver"><a href="modificar_maquina.php">Volver</a></button>';
                }

            echo '</div>';
        ?>
    </body>
</html>
