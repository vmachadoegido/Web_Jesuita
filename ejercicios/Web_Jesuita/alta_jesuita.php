<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Alta Jesuita</title>
        <link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    </head>
    <body>
        <div id="general">
            <img src="imagenes/logotipo.png"/>

            <h3>JESUITAS POR EL MUNDO</h3>

            <?php
                // Hasta que no se le da el boton enviar, mostrara el formulario.
                if(!isset($_POST["Enviar"]))
                {
                    echo '<form method="post">';
                        echo '<table id="agregarmasinfo">';
                            echo '<tr>';
                                echo '<td><label for="nombrejesuita">Nombre Jesuita</label></td>';
                                echo '<td><input type="text" name="nombrejesuita" placeholder="Nombre Jesuita"/></td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td><label for="firma">Firma</label></td>';
                                echo '<td><input type="text" name="firma" placeholder="Firma"/></td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td><label for="info[]">Otra informacion</label></td>';
                                echo '<td><input type="text" name="info[]" placeholder="Mas Informacion"/></td>';
                                echo '<td><button type="button" name="agregar" id="agregar">+</button></td>';
                            echo '</tr>';
                        echo '</table>';
                        echo '<input type="submit" name="Enviar" value="Enviar" />';
                    echo '</form>';

                }
                else
                {
                    // Traer los metodos de la pagina operaciones.php
                    require_once 'operaciones.php';
                    // Crear el objeto de la operaciones.
                    $objeto=new operaciones();

                    // Guardar el nombre y la firma en una variable
                    $nombrejesuita = $_POST["nombrejesuita"];
                    $firma = $_POST["firma"];

                    if((!empty($nombrejesuita) AND (!empty($firma))))
                    {
                        // Consulta para ssaber si existe ese jesuita.
                        $consulta = "SELECT * FROM jesuita WHERE nombreJesuita='$nombrejesuita'";
                        $objeto->realizarConsultas($consulta);

                        // Si devuelve fila, significa que existe ese jesuita, por lo tanto no se guarda
                        if ($objeto->comprobarFila()>0)
                        {
                            echo '<p> Error - Ese Jesuita ya existe</p>';
                            echo '<a href="alta_jesuita.php" class="boton"> Volver </br></a>';
                        }
                        else
                        {
                            // Consulta para insertar el nombre del jesuita y su firma
                            $consulta = "INSERT INTO jesuita (nombreJesuita, firma) VALUES ('$nombrejesuita', '$firma')";
                            $objeto->realizarConsultas($consulta);

                            // Si devuelve fila se introdujo corectamente los datos.
                            if ($objeto->comprobar()>0)
                            {
                                // Sacar la ultima id de la consulta, insert
                                $id=$objeto->ultimoid();

                                $consulta = "SELECT * FROM informacion_j WHERE idJesuita='$id'";
                                $objeto->realizarConsultas($consulta);

                                // Si existe esa id
                                if ($objeto->comprobarFila()>0)
                                {
                                    // Pendiente de configuracion
                                    echo '<p> No se introdujo nada... Config </p>';
                                    echo '<a href="alta_jesuita.php" class="boton"> Volver </br></a>';
                                }
                                else
                                {
                                    // Introduce toda la raid.
                                    // Recorre toda la raids, insertando la informacion en filas distintas
                                    foreach ($_POST["info"] as $contador)
                                    {
                                        // Si contador tiene contenido
                                        if(!empty($contador))
                                        {
                                            $consulta = "INSERT INTO informacion_j (idJesuita, infomacion) VALUES ('$id', '$contador')";
                                            $objeto->realizarConsultas($consulta);
                                        }
                                    }

                                    echo '<p>Se introdujo los datos correctamente.</p>';
                                    echo '<a href="alta_jesuita.php" class="boton"> Volver </br></a>';
                                }

                            }
                            else // Si no se introdujo bien el insert salta este error.
                            {
                                echo '<p> Error - Hubo un error inesperado</p>';
                                echo '<a href="alta_jesuita.php" class="boton"> Volver </br></a>';
                            }
                        }
                    }
                    else
                    {
                        echo '<p> No se introdujo el jesuita y su firma</p>';
                        echo '<a href="alta_jesuita.php" class="boton"> Volver </br></a>';
                    }
                }
            ?>
        </div>

    </body>
</html>

<script>
    $(document).ready(function()
    {
        // La variable i, empieza en 0
        var i=0;
        // Al hacer click en el boton #agregar. Ira sumando mas la i, y creara nuevas filas con columnas de cada + , que se vaya agreando
        $('#agregar').click(function()
        {
            i++;
            $('#agregarmasinfo').append('' +
                '<tr id="row'+i+'">' +
                '   <td><label for="info[]">Informacion '+i+'</label></td>'+
                '   <td><input type="text" name="info[]" placeholder="Mas Informacion"/></td>' +
                '   <td><button type="button" name="remove" id="'+i+'" class="eliminar">X</button></td>' +
                '</tr>'
            );
        });

        // Al darle el boton eliminar, eliminra una fila/columna.
        $(document).on('click', '.eliminar', function()
        {
            var id_boton = $(this).attr("id");
            $('#row'+id_boton+'').remove();
        });

    });
</script>
