<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div id="general">
            <img src="imagenes/logotipo.png"/>
            <h3>JESUITAS POR EL MUNDO</h3>
            <?php

                require_once 'clasephp.php';
                $objeto=new operaciones();

                // Inicio Sesion
                session_start();

                // Pruebas
                $_SESSION["idJesuita"] = '1';


                if(!isset($_POST["enviar"]))
                {
                    $consulta = "SELECT * FROM lugar ORDER BY nombreLugar";

                    $objeto->realizarConsultas($consulta);

                    echo '<form action="Visitar-Lugares.php" METHOD="POST">';
                        echo '<select name="lugar">';
                            echo '<option value="no">Seleciona un Lugar</option>';
                            while ($fila = $objeto->extraerFilas())
                            {
                                echo '<option value="'.$fila["idLugar"].'">'.$fila["nombreLugar"].'</option>';
                            }
                        echo '</select>';
                        echo '<input type="submit" value="Enviar" name="enviar"/>';
                    echo '</form>';

                    echo '</br></br><a href="1-perfil.html" class="boton"> Volver </a></br>';
                }
                else
                {
                    $lugar= $_POST["lugar"];

                    if($lugar=='no')
                    {
                        echo '<p>Error - No has selecionado ningun lugar</p>';
                    }
                    else
                    {
                        $consulta= "SELECT * FROM maquina WHERE lugar='$lugar';";
//                    print_r($consulta);

                        $objeto->realizarConsultas($consulta);

                        if ($objeto->comprobarFila()>0)
                        {
                            $fila = $objeto->extraerFilas();
                            $jesuita = $fila["jesuita"];

                            if($fila["idJesuita"]==$_SESSION["idJesuita"])
                            {
                                echo '<p>Error no te puedes visitar a ti mismo</p>';
                            }
                            else
                            {
                                $consulta='INSERT INTO visita (idLugar, idJesuita, fechaHora) VALUES ('.$lugar.', '.$_SESSION["idJesuita"].', now());';
//                                print_r($consulta);
                                $objeto->realizarConsultas($consulta);

                                if($objeto->comprobar()>0)
                                {
                                    $consulta = "SELECT * FROM lugar";
                                    $objeto->realizarConsultas($consulta);

                                    if($objeto->comprobarSelect()>0)
                                    {
                                        $fila = $objeto->extraerFilas();
                                        echo '<p>Hiciste una visita a '.$fila["nombreLugar"].'</p>';
                                    }
                                    else
                                    {
                                        echo '<p>Error - Hubo un error fatal el lugar no existe</p>';
                                    }

                                }
                                else
                                {
                                    echo '<p>Eror al visitar el lugar</p>';
                                }
                            }
                        }
                        else{
                            echo '<p>Error - Ese lugar aun no se asigno a ningun jesuita</p>';
                        }
                    }
                    echo '</br></br><a href="Visitar-Lugares.php" class="boton"> Volver </br></a>';
                }
            ?>
        </div>
    </body>
</html>