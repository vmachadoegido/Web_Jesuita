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

                require_once 'clasephp.php';
                $objeto=new clasephp();

                // Inicio Sesion
                session_start();

                // Pruebas, finje ser el jesuita 1
                $_SESSION["idJesuita"] = '1';

                // Hasta que no se envia el lugar
                if(!isset($_POST["enviar"]))
                {
                    // Hacer la consulta de lugar ordenado por el nombre
                    $consulta = "SELECT * FROM lugar ORDER BY nombreLugar";

                    $objeto->realizarConsultas($consulta);

                    // Comprueba que le devuelve fila
                    if ($objeto->comprobarSelect()>0)
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
                            echo '<input type="submit" value="Enviar" name="enviar"/>';
                        echo '</form>';

                        echo '</br></br><a href="0-rankingvisitas.php" class="boton"> Volver </a></br>';
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
                        if ($objeto->comprobarSelect()>0)
                        {
                            // Extraigo las filas
                            $fila = $objeto->extraerFilas();

                            // Guardo la idJesuita en una variable.
                            $jesuita = $fila["jesuita"];


                            // Comprueba que el usuario
                            if($fila["jesuita"] ===$_SESSION["idJesuita"])
                            {
                                echo '<p>Error no te puedes visitar a ti mismo</p>';
                            }
                            else
                            {
                                $consulta='INSERT INTO visita (idLugar, idJesuita, fechaHora) VALUES ('.$lugar.', '.$_SESSION["idJesuita"].', now());';
                                //print_r($consulta);
                                $objeto->realizarConsultas($consulta);

                                // Si devuelve fila la consulta, por lo tanto se pudo hacer la visita.
                                if($objeto->comprobar()>0)
                                {
                                    // Consulta del la idLugar visitado.
                                    $consulta = "SELECT * FROM lugar WHERE idLugar= $lugar";
                                    //print_r($consulta);
                                    $objeto->realizarConsultas($consulta);

                                    // Comprueba si devuelve fila la consulta, por lo tanto esa idLugar exita.
                                    if($objeto->comprobarSelect()>0)
                                    {
                                        // Extraigo las filas
                                        $fila = $objeto->extraerFilas();
                                        // Muestra un mensaje del lugar visitado
                                        echo '<p>Hiciste una visita a '.$fila["nombreLugar"].'</p>';

                                        setcookie('lugares_visitados', $fila["nombreLugar"] , time()+3600);

//                                        setcookie('lugares_visitados[0]', 'Roma' , time()+3600);
//                                        setcookie('lugares_visitados[1]', 'Barcelona' , time()+3600);
//                                        setcookie('lugares_visitados[2]', 'Brazil' , time()+3600);

                                    }
                                    else // Si no se encuentra ese lugar no existe o otros problemas.
                                    {
                                        echo '<p>Error - Hubo un error fatal el lugar no existe</p>';
                                    }

                                }
                                else // Si no devuelve filas, no se pudo insertar/ hacer esa visita.
                                {
                                    echo '<p>Eror al visitar el lugar</p>';
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