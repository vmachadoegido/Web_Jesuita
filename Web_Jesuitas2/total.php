<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Ranking visitas</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div id="general">
            <?php
                // Inicia Ssion
                session_start();
                // Traer los metodos de la pagina operaciones.php
                require_once 'operaciones.php';
                // Crear el objeto de la operaciones.
                $objeto=new operaciones();
                
/*- Total de visitas de cada lugar ---------------------------------------------------------------------------------*/
                $sql="
SELECT visita.idLugar, lugar.idLugar, lugar.nombreLugar, COUNT(visita.idVisita) as visitas
FROM visita
RIGHT JOIN lugar ON visita.idLugar = lugar.idLugar
GROUP BY lugar.idLugar;";
                //print_r($sql);
                $objeto->realizarConsultas($sql);

                echo '<div>';
                    echo '<h2>Total de Visitas de cada Lugar</h2>';
                    // Si devuelve filas, existe esos datos
                    if ($objeto->comprobarFila()>0)
                    {
                        echo '<table>';
                            echo '<tr>';
                                echo '<th>Lugar</th>';
                                echo '<th>Numero de visitas</th>';
                                // Visualiza el resultado de las filas devueltas.
                                while($fila=$objeto->extraerFilas())
                                {
                                    echo '<tr>';
                                        echo '<td>'.$fila["nombreLugar"].'</td>';
                                        echo '<td class="centrarvisita">'.$fila["visitas"].'</td>';
                                    echo '</tr>';
                                }
                            echo '</tr>';
                        echo '</table>';
                    }
                    else // SI no devuelve ninguna fila, no hay lugares
                    {
                        echo 'No hay lugares creados';
                    }
                echo '</div>';

/*- Lugares no visitados  ---------------------------------------------------------------------------------*/
            $sql="
SELECT visita.idLugar, lugar.idLugar, lugar.nombreLugar, COUNT(visita.idVisita) as visitas
FROM visita
RIGHT JOIN lugar ON visita.idLugar = lugar.idLugar
GROUP BY lugar.idLugar
HAVING visitas = 0;";
            //print_r($sql);
            $objeto->realizarConsultas($sql);

            echo '<div>';
            echo '<h2>Lugares no visitados</h2>';
            // Si devuelve filas, existe esos datos
            if ($objeto->comprobarFila()>0)
            {
                echo '<table>';
                echo '<tr>';
                echo '<th>Lugar</th>';
                // Visualiza el resultado de las filas devueltas.
                while($fila=$objeto->extraerFilas())
                {
                    echo '<tr>';
                    echo '<td>'.$fila["nombreLugar"].'</td>';
                    echo '</tr>';
                }
                echo '</tr>';
                echo '</table>';
            }
            else // SI no devuelve ninguna fila, no hay lugares
            {
                echo 'No hay lugares creados o ya han sido visitados';
            }
            echo '</div>';




/*- Total de jesuita viajeros ---------------------------------------------------------------------------------*/
            $sql="
SELECT visita.idJesuita, jesuita.idJesuita, jesuita.nombreJesuita, COUNT(visita.idVisita) as visitas
FROM visita
RIGHT JOIN jesuita ON visita.idJesuita = jesuita.idJesuita
GROUP BY  jesuita.idJesuita;";
            //print_r($sql);
            $objeto->realizarConsultas($sql);

            echo '<div>';
            echo '<h2>Total de Jesuitas Viajeros</h2>';
            // Si devuelve filas, existe esos datos
            if ($objeto->comprobarFila()>0)
            {
                echo '<table>';
                echo '<tr>';
                echo '<th>Jesuita</th>';
                echo '<th>Numero de viajes</th>';
                // Visualiza el resultado de las filas devueltas.
                while($fila=$objeto->extraerFilas())
                {
                    echo '<tr>';
                        echo '<td>'.$fila["nombreJesuita"].'</td>';
                        echo '<td class="centrarvisita">'.$fila["visitas"].'</td>';
                    echo '</tr>';
                }
                echo '</tr>';
                echo '</table>';
            }
            else // SI no devuelve ninguna fila, no hay jesuitas.
            {
                echo 'No hay jesuitas creados';
            }
            echo '</div>';

/*- Jesuitas no viajeros ---------------------------------------------------------------------------------*/
            $sql="
SELECT visita.idJesuita, jesuita.idJesuita, jesuita.nombreJesuita, COUNT(visita.idVisita) as visitas
FROM visita
RIGHT JOIN jesuita ON visita.idJesuita = jesuita.idJesuita
GROUP BY  jesuita.idJesuita
HAVING visitas = 0;";
            //print_r($sql);
            $objeto->realizarConsultas($sql);

            echo '<div>';
            echo '<h2>Jesuitas no Viajeros</h2>';
            // Si devuelve filas, existe esos datos
            if ($objeto->comprobarFila()>0)
            {
                echo '<table>';
                echo '<tr>';
                echo '<th>Jesuitas</th>';
                // Visualiza el resultado de las filas devueltas.
                while($fila=$objeto->extraerFilas())
                {
                    echo '<tr>';
                    echo '<td>'.$fila["nombreJesuita"].'</td>';
                    echo '</tr>';
                }
                echo '</tr>';
                echo '</table>';
            }
            else // SI no devuelve ninguna fila, no hay jesuitas.
            {
                echo 'Todos los jesuitas han viajado o no hay jesuitas';
            }
            echo '</div>';

            echo '<br><a href="0-rankingvisitas.php" class="boton"> Volver </br></a>';
            ?>
        </div>
    </body>
</html>
