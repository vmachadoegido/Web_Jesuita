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
            require_once 'clasephp.php';
            $objeto=new clasephp();

            echo '<br/><a href="Visitar-Lugares.php"> Visitar</a>';
            echo '<br/><a href="cerrarsesion.php"> Cerrar Sesion </a>';

            /*Consulta para mostrar los 5 lugares con mas visitas*/
//            $sql="select v.ip,lugar, count(v.ip) AS contador from Visita v INNER JOIN Lugar l ON l.ip=v.ip group by v.ip having contador ORDER by contador desc LIMIT 5";
            $sql="select maquina.lugar, count(visitas.idLugar) AS contador from visitas INNER JOIN maquina GROUP by maquina.ip HAVING contador ORDER BY contador desc LIMIT 5";
            $objeto->realizarConsultas($sql);
            echo '<div>';
                echo '<h2>Ranking 5 Lugares Mas Visitados</h2>';
                    if ($objeto->comprobar()>0){
                        echo '<table>';
                            echo '<tr>';
                                echo '<th>Ciudad</th><th>Numero de visitas</th>';
                                while($fila=$objeto->extraerFilas())
                                {
                                    echo '<tr><td>'.$fila["lugar"].'</td> <td class="centrarvisita">'.$fila["contador"].'</td></tr>';
                                }
                            echo '</tr>';
                        echo '</table>';
                    }
                    else{
                        echo' No hay visitas a ningun lugar';
                    }
            echo '</div>';
            /*Consulta para mostrar los 5 jesuitas con mas visitas*/
//            $sql="SELECT v.idJesuita,j.nombre, COUNT(*) AS visitas FROM Visita v INNER JOIN Jesuita j ON v.idJesuita=j.idJesuita GROUP BY idJesuita ORDER BY COUNT(*) DESC LIMIT 5";
            $sql="SELECT visitas.idJesuita, maquina.jesuita, COUNT(*) AS visitas FROM visitas INNER JOIN maquina ON visitas.idJesuita=maquina.ip GROUP BY idJesuita ORDER BY COUNT(*) DESC LIMIT 5";
            $objeto->realizarConsultas($sql);
            echo '<div>';
                echo '<h2>Ranking 5 Jesuitas Mas Viajeros</h2>';
                        if ($objeto->comprobar()>0){
                            echo '<table>';
                                echo '<tr>';
                                    echo '<th>Lugar</th> <th>Numero de visitas</th>';
                                    while($fila=$objeto->extraerFilas())
                                    {
                                        echo '<tr><td>'.$fila["jesuita"].'</td> <td class="centrarvisita">'.$fila["visitas"].'</td></tr>';
                                    }
                                echo '</tr>';
                            echo '</table>';
                        }
                        else{
                            echo' No hay jesuitas viajando';
                        }
            echo '</div>';
            /*Consulta para mostrar los 5 visitas*/
//            $sql="SELECT nombre, lugar, DATE_FORMAT(fechaHora, '%H:%i:%S' ) as hora   FROM Visita v INNER JOIN Jesuita j ON v.idJesuita=j.idJesuita INNER JOIN Lugar l ON v.ip=l.ip ORDER BY fechaHora DESC LIMIT 5";
            $sql="SELECT maquina.jesuita, maquina.lugar, DATE_FORMAT(fechaHora, '%H:%i:%S' ) as hora FROM visitas INNER JOIN maquina ON visitas.idJesuita=maquina.ip ORDER BY fechaHora DESC LIMIT 5";
            $objeto->realizarConsultas($sql);
            echo '<div>';
                echo '<h2>Ultimas 5 Visitas</h2>';
                if ($objeto->comprobar()>0)
                {
                    echo '<div id="ultimasVisitas">';
                    while($fila=$objeto->extraerFilas())
                    {
                        echo $fila["jesuita"].' ha visitado '.$fila["lugar"].' a las '.$fila["hora"].'<br>';
                    }
                    echo '</div>';
                }
                else{
                    echo' No hay ultimas visitas';
                }
            echo '</div>';

        ?>
    </div>
    </body>
</html>
