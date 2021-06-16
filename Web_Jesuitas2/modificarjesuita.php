<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Modificar Jesuita</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php
            echo '<div id="contenedor">';
                // Traer la clase
                require_once 'operaciones.php';
                // Crear un objeto con la clase
                $objeto=new operaciones();

                echo '<h2>Modificar Jesuitas</h2>';

                // Guardo la id del jesuita
                $idjesuita = $_GET["id"];

                // Hasta que no se le da el boton enviar, mostrara el formulario.
                if(!isset($_POST["Enviar"]))
                {
                    $consulta = "SELECT * FROm jesuita WHERE idJesuita='$idjesuita'";
                    //print_r($consulta);
                    $objeto->realizarConsultas($consulta);

                    // Si devuelve la idJesuita es correcto
                    if($objeto->comprobarFila())
                    {
                        if(!isset($_POST["Modificar"]))
                        {
                            $fila = $objeto->extraerFilas();
                            echo '<form method="post">';
                                echo '<table id="agregarmasinfo">';
                                    // Mostrar el nombre del Jesuita
                                    echo '<tr>';
                                        echo '<td><label for="nombrejesuita">Nombre del Jesuita</label></td>';
                                        echo '<td><input type="text" name="nombrejesuita" placeholder="Nombre Jesuita" value="'.$fila["nombreJesuita"].'" required/></td>';
                                    echo '</tr>';

                                    // Mostrar la firma
                                    echo '<tr>';
                                        echo '<td><label for="firma">Firma</label></td>';
                                        echo '<td><input type="text" name="firma" placeholder="Firma" value="'.$fila["firma"].'" required/></td>';
                                    echo '</tr>';

                                echo '</table>';
                                echo '<input type="submit" name="Modificar" value="Modificar" />';
                            echo '</form>';
                        }
                        else
                        {
                            $nombrejesuita = $_POST["nombrejesuita"];
                            $firma = $_POST["firma"];

                            // Consulta para actualizar la informacion del nombrejesuita y firma
                            $consulta = "UPDATE jesuita SET nombreJesuita='".$nombrejesuita."', firma='".$firma."' WHERE idJesuita='$idjesuita';";
                            //print_r($consulta);
                            $objeto->realizarConsultas($consulta);

                            if($objeto->comprobar()>0)
                            {
                                echo '<p>Se actualizo la informacion correctamente</p>';
                            }
                            else
                            {
                                echo '<p>No modificaste nada</p>';
                            }
                        }
                    }
                    else
                    {
                        echo '<p>Hubo un problema con ese jesuita.</p>';
                    }

                    echo '<button class="volver"><a href="listarjesuita.php">Volver</a></button>';
                }
            echo '</div>';
        ?>
    </body>
</html>
