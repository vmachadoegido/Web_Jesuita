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
                // Traer los metodos de la pagina operaciones.php
                require_once 'operaciones.php';
                // Crear el objeto de la operaciones.
                $objeto=new operaciones();

            //$_SESSION["usuario"] = 'admin';

/* Navegador --------------------------------------------------------------------------------------------------*/
                echo '<nav>';
                    echo '<ul>';
                        // Si esta vacio la session usuario mostra enn el menu Inicio Sesion
                        if(empty($_SESSION["usuario"]))
                        {
                            echo '<li><a href="inicio-sesion.php">Inicio Sesion</a></li>';
                        }
                        else // Si esta vacio la sesion usuario mostra sus opciones
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
                                echo '<li><a href="total.php">Total</a></li>';
                                echo '<li><a href="#">Lugares</a>';
                                    echo '<ul>';
                                        echo '<li><a href="listarlugares.php">Listar</a></li>';
                                        echo '<li><a href="./admin/PaginaAdministrador.php?opcion=lugar&opcionlugar=agregar">Agregar</a></li>';
                                    echo '</ul>';
                                echo '</li>';

                                echo '<li><a href="#">Jesuita</a>';
                                    echo '<ul>';
                                        echo '<li><a href="listarjesuita.php">Listar</a></li>';
                                        echo '<li><a href="alta_jesuita.php">Agregar</a></li>';
                                    echo '</ul>';
                                echo '</li>';

                                echo '<li><a href="#">Maquinas</a>';
                                    echo '<ul>';
                                        echo '<li><a href="listarmaquinas.php">Listar</a></li>';
                                        echo '<li><a href="./admin/PaginaAdministrador.php?opcion=usuario&opcionusuario=agregar">Agregar</a></li>';
                                        echo '<li><a href="asignar-lugar-jesuita.php">Asignar</a></li>';
                                    echo '</ul>';
                                echo '</li>';

                            }
                            // Si el usuario es admin o usuario mostra el boton salir
                            if( ($_SESSION["usuario"] == 'admin') or ($_SESSION["usuario"] == 'usuario'))
                            {
                                echo '<li id="salir"><a href="cerrarsesion.php">Salir</a></li>';
                            }
                        }
                    echo '</ul>';
                echo '</nav>';

/* Main ------------------------------------------------------------------------------------------------- */
/* 5 lugares mas visitados -----------------------------------------------------------*/
            // Consulta para conseguir los cinco lugares mas visitados.
            $sql="SELECT maquina.lugar, count(visita.idLugar) AS contador, lugar.nombreLugar from visita INNER JOIN maquina LEFT JOIN lugar ON maquina.lugar = lugar.idLugar GROUP by maquina.ip HAVING contador ORDER BY contador desc LIMIT 5";
            $objeto->realizarConsultas($sql);

            echo '<div>';
                echo '<h2>Ranking 5 Lugares Mas Visitados</h2>';
                // Si devuelve filas, existe esos datos
                if ($objeto->comprobarFila()>0)
                {
                    echo '<table>';
                        echo '<tr>';
                            echo '<th>Ciudad</th>';
                            echo '<th>Numero de visitas</th>';
                            // Visualiza el resultado de las filas devueltas.
                            while($fila=$objeto->extraerFilas())
                            {
                                if(!empty($fila["lugar"]))
                                {
                                    echo '<tr>';
                                        echo '<td>'.$fila["nombreLugar"].'</td>';
                                        echo '<td class="centrarvisita">'.$fila["contador"].'</td>';
                                    echo '</tr>';
                                }

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
            $sql="SELECT visita.idJesuita, jesuita.nombreJesuita, COUNT(*) AS visitas FROM visita INNER JOIN maquina ON visita.idJesuita=maquina.jesuita LEFT JOIN jesuita ON visita.idVisita=jesuita.idJesuita GROUP BY idJesuita ORDER BY COUNT(*) DESC LIMIT 5";
            $objeto->realizarConsultas($sql);

            echo '<div>';
                echo '<h2>Ranking 5 Jesuitas Mas Viajeros</h2>';
                // SI devuelve filas, por lo tanto hay jesuitas visitando
                if ($objeto->comprobarFila()>0)
                {
                    echo '<table>';
                        echo '<tr>';
                            echo '<th>Lugar</th>';
                            echo '<th>Numero de visitas</th>';
                            // Va mostrando los jesuitas con las filas.
                            while($fila=$objeto->extraerFilas())
                            {
                                if(!empty($fila["nombreJesuita"]))
                                {
                                    echo '<tr><td>' . $fila["nombreJesuita"] . '</td> <td class="centrarvisita">' . $fila["visitas"] . '</td></tr>';
                                }
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
            $sql="SELECT visita.idJesuita, jesuita.nombreJesuita, visita.idLugar, lugar.nombreLugar, DATE_FORMAT(fechaHora, '%H:%i:%S' ) as hora FROM visita INNER JOIN jesuita ON visita.idJesuita=jesuita.idJesuita INNER JOIN lugar ON visita.idLugar=lugar.idLugar ORDER BY fechaHora DESC LIMIT 5;";
            $objeto->realizarConsultas($sql);

            echo '<div>';
                echo '<h2>Ultimas 5 Visitas</h2>';
                // COmprueba que devuelve filas, por lo tanto hay visitas
                if ($objeto->comprobarFila()>0)
                {
                    echo '<div id="ultimasVisitas">';
                    // Muestra los jesuitas, lugares y la hora de la visita.
                    while($fila=$objeto->extraerFilas())
                    {
                        echo $fila["nombreJesuita"].' ha visitado '.$fila["nombreLugar"].' a las '.$fila["hora"].'<br>';
                    }
                    echo '</div>';
                }
                else // Si no devuelve filas no hay visitas.
                {
                    echo' No hay ultimas visitas';
                }
            echo '</div>';
            ?>
        </div>
    </body>
</html>
