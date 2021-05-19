<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Ranking visitas</title>
        <link rel="stylesheet" href="style.css">
        <meta http-equiv="refresh" content="5">
    </head>
    <body>
        <div id="general">
            <img src="imagenes/logotipo.png">
            <?php
                // Inicia Ssion
                session_start();
                // Traer los metodos de la pagina clasephp.php
                require_once 'clasephp.php';
                // Crear el objeto de la clasephp.
                $objeto=new clasephp();

/* Navegador --------------------------------------------------------------------------------------------------*/
                echo '<nav>';
                    echo '<ul>';
                        // Si no existe la session usuario mostra enn el menu Inicio Sesion
                        if(isset($_SESSION["usuario"]))
                        {
                            echo '<li><a href="inicio-sesion.php">Inicio Sesion</a></li>';
                        }
                        else // SI existe la sesion usuario mostra sus opciones
                        {
                            // Si el usuario es admin o usuario mostra el boton perfil
                            if( ($_SESSION["usuario"] == 'admin') or ($_SESSION["usuario"] == 'usuario'))
                            {
                                echo '<li id="perfil"><a href="#">Perfil</a></li>';
                            }
                            // Si el usuario es usuario mostrara visitar
                            if( $_SESSION["usuario"] == 'usuario')
                            {
                                echo '<li id="visitar"><a href="Visitar-Lugares.php">Visitar</a></li>';
                            }
                            // Si el usuario es admin mostrara el boton total, usuario y lugares.
                            if($_SESSION["usuario"] == 'admin')
                            {
                                echo '<li><a href="#">Total</a></li>';
                                echo '<li><a href="#">Usuario</a></li>';
                                echo '<li><a href="#">Lugares</a></li>';
                            }
                            // Si el usuario es admin o usuario mostra el boton salir
                            if( ($_SESSION["usuario"] == 'admin') or ($_SESSION["usuario"] == 'usuario'))
                            {
                                echo '<li id="salir"><a href="inicio-sesion.php">Salir</a></li>';
                            }
                        }
                    echo '</ul>';
                echo '</nav>';

/* Main ------------------------------------------------------------------------------------------------- */
/* 5 lugares mas visitados -----------------------------------------------------------*/
            // Consulta para conseguir los cinco lugares mas visitados.
            $sql="SELECT maquina.lugar, count(visita.idLugar) AS contador from visita INNER JOIN maquina GROUP by maquina.ip HAVING contador ORDER BY contador desc LIMIT 5";
            $objeto->realizarConsultas($sql);

            echo '<div>';
                echo '<h2>Ranking 5 Lugares Mas Visitados</h2>';
                // Si devuelve filas, existe esos datos
                if ($objeto->comprobarSelect()>0)
                {
                    echo '<table>';
                        echo '<tr>';
                            echo '<th>Ciudad</th>';
                            echo '<th>Numero de visitas</th>';
                            // Visualiza el resultado de las filas devueltas.
                            while($fila=$objeto->extraerFilas())
                            {
                                echo '<tr>';
                                    echo '<td>'.$fila["lugar"].'</td>';
                                    echo '<td class="centrarvisita">'.$fila["contador"].'</td>';
                                echo '</tr>';
                            }
                        echo '</tr>';
                    echo '</table>';
                }
                else // SI no devuelve ninguna fila, no hay lugares visitados aun.
                {
                    echo' No hay visitas a ningun lugar';
                }
            echo '</div>';

/* 5 jesuitas mas viajeros -----------------------------------------------------------*/

            /* Consulta para mostrar los 5 jesuitas con mas visitas*/
            $sql="SELECT visitas.idJesuita, maquina.jesuita, COUNT(*) AS visitas FROM visitas INNER JOIN maquina ON visitas.idJesuita=maquina.ip GROUP BY idJesuita ORDER BY COUNT(*) DESC LIMIT 5";
            $objeto->realizarConsultas($sql);

            echo '<div>';
                echo '<h2>Ranking 5 Jesuitas Mas Viajeros</h2>';
                // SI devuelve filas, por lo tanto hay jesuitas visitando
                if ($objeto->comprobar()>0)
                {
                    echo '<table>';
                        echo '<tr>';
                            echo '<th>Lugar</th>';
                            echo '<th>Numero de visitas</th>';
                            // Va mostrando los jesuitas con las filas.
                            while($fila=$objeto->extraerFilas())
                            {
                                echo '<tr><td>'.$fila["jesuita"].'</td> <td class="centrarvisita">'.$fila["visitas"].'</td></tr>';
                            }
                        echo '</tr>';
                    echo '</table>';
                }
                else // No hay jesuita visitando, no devuelve filas.
                {
                    echo' No hay jesuitas viajando';
                }
            echo '</div>';

/* Ultimas 5 visitas ----------------------------------------------------------------------------------------------- */
            /*Consulta para mostrar los 5 visitas*/
            $sql="SELECT maquina.jesuita, maquina.lugar, DATE_FORMAT(fechaHora, '%H:%i:%S' ) as hora FROM visita INNER JOIN maquina ON visita.idJesuita=maquina.ip ORDER BY fechaHora DESC LIMIT 5";
            $objeto->realizarConsultas($sql);

            echo '<div>';
                echo '<h2>Ultimas 5 Visitas</h2>';
                // COmprueba que devuelve filas, por lo tanto hay visitas
                if ($objeto->comprobar()>0)
                {
                    echo '<div id="ultimasVisitas">';
                    // Muestra los jesuitas, lugares y la hora de la visita.
                    while($fila=$objeto->extraerFilas())
                    {
                        echo $fila["jesuita"].' ha visitado '.$fila["lugar"].' a las '.$fila["hora"].'<br>';
                    }
                    echo '</div>';
                }
                else // Si no devuelve filas no hay visitas.
                {
                    echo' No hay ultimas visitas';
                }
            echo '</div>';

/* Ultima visita echa por ti ------------------------------------------------------------------------------------------ */
                // Ver sus ultimas tres visitas.
                // Si eres usuario
                if(!empty($_SESSION["usuario"]))
                {
                    // Si eres perfil usuario
                    if($_SESSION["usuario"] == 'usuario')
                    {
                        echo '<h2>Ultimas Visita Tuyas</h2>';
                        // SI no existe la cookie lugares_visitados, mostrara un mensaje
                        if(!isset($_COOKIE['lugares_visitados']))
                        {
                            echo '<td>Aun no has visitado ningun lugar</td>';
                        }
                        else // Si existe la cookie lugares_visitados mostra lo guardado en esta
                        {
                            echo '<table>';
                                echo '<tr>';
                                    echo '<td>'.$_COOKIE['lugares_visitados'].'</td>';
//                                    echo '<th>Lugares</th>';
                                    // Recorre toda la array de la cookie lugares_visitados
//                                    foreach($_COOKIE['lugares_visitados'] as $lugar)
//                                    {
//                                        echo '<td>'.$lugar.'</td>';
//                                    }
                                echo '</tr>';
                            echo '</table>';
                        }
                    }
                }
            ?>
        </div>
    </body>
</html>
