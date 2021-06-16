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

                echo '<h2>Modificar Lugares</h2>';

                // Guardo la id del jesuita
                $idlugar = $_GET["id"];

                // Hasta que no se le da el boton enviar, mostrara el formulario.
                if(!isset($_POST["Enviar"]))
                {
                    $consulta = "SELECT * FROm lugar WHERE idLugar='$idlugar'";
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
                                    // Mostrar el nombre del Lugar
                                    echo '<tr>';
                                        echo '<td><label for="nombrelugar">Nombre del Lugar</label></td>';
                                        echo '<td><input type="text" name="nombrelugar" placeholder="Nombre del Lugar" value="'.$fila["nombreLugar"].'" required/></td>';
                                    echo '</tr>';

                                echo '</table>';
                                echo '<input type="submit" name="Modificar" value="Modificar" />';
                            echo '</form>';
                        }
                        else
                        {
                            $nombrelugar = $_POST["nombrelugar"];

                            // Consulta para actualizar la informacion del nombrejesuita y firma
                            $consulta = "UPDATE lugar SET nombreLugar='".$nombrelugar."' WHERE idLugar='$idlugar';";
                            //print_r($consulta);
                            $objeto->realizarConsultas($consulta);

                            if($objeto->comprobar()>0)
                            {
                                echo '<p>Se actualizo el lugar correctamente</p>';
                            }
                            else
                            {
                                echo '<p>No modificaste nada</p>';
                            }
                        }
                    }
                    else
                    {
                        echo '<p>Hubo un problema con ese Lugar.</p>';
                    }

                    echo '<button class="volver"><a href="listarlugares.php">Volver</a></button>';
                }
            echo '</div>';
        ?>
    </body>
</html>
