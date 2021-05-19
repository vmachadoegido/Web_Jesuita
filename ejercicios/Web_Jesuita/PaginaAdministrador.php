<!doctype html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Inicio Sesion</title>
        <link rel="stylesheet" href="estilo.css">
    </head>
    <body>
        <?php
            session_start();

            if($_SESSION["tipo"] == 'admin')
            {
                echo '<div id="contenedor">';
/*--- Opciones ---------------------------------------------------------------------------*/
                if (!isset($_GET["opcion"])) {
                    echo '<h2>Bienvenido Administrador</h2>';
                    echo '<div class="opciones">';
                    echo '<ul>';
                    echo '<li><a href="PaginaAdministrador.php?opcion=lugar">Lugares</a></li>';
                    echo '<li><a href="PaginaAdministrador.php?opcion=jesuita">Jesuita</a></li>';
                    echo '<li><a href="PaginaAdministrador.php?opcion=usuario">Usuarios</a></li>';
                    echo '<li><a href="PaginaAdministrador.php?opcion=cerrarsesion">Cerrar Sesion</a></li>';
                    echo '</ul>';
                    echo '<div>';
                } else
                {
                    require_once 'clasephp.php';

                    $objeto = new clasephp();

/*--- Lugares ---------------------------------------------------------------------------*/
                    if ($_GET["opcion"] == "lugar")
                    {
/*--- Lugares Opciones ---------------------------------------------------------------------------*/
                        if (!isset($_GET["opcionlugar"]))
                        {
                            echo '<h2>Gestion de Lugares</h2>';
                            echo '<div class="opciones">';
                            echo '<ul>';
                            echo '<li><a href="PaginaAdministrador.php?opcion=lugar&opcionlugar=agregar">Agregar</a></li>';
                            echo '<li><a href="PaginaAdministrador.php?opcion=lugar&opcionlugar=modificar">Modificar</a></li>';
                            echo '<li><a href="PaginaAdministrador.php?opcion=lugar&opcionlugar=eliminar">Eliminar</a></li>';
                            echo '<li><a href="PaginaAdministrador.php?opcion=lugar&opcionlugar=listar">Listar</a></li>';
                            echo '</ul>';
                            echo '</div>';
                            echo '<button class="volver"><a href="PaginaAdministrador.php">Volver</a></button>';
                        }
                        else
                        {
/*--- Lugares Agregar ---------------------------------------------------------------------------*/
                            // Si entra por la opcion agregar
                            if ($_GET["opcionlugar"] == "agregar")
                            {
                                echo '<h2>Agregar Lugares</h2>';
                                // Si existe la variable agregar muestra el formulario
                                if (!isset($_POST["Agregar"]))
                                {
                                    echo '<form action="#" METHOD="POST">';
                                    echo '<input type="text" placeholder="Nombre del Lugar" name="nombre">';
                                    echo '<input type="submit" value="Agregar" name="Agregar">';
                                    echo '</form>';

                                    echo '<button class="volver"><a href="PaginaAdministrador.php?opcion=lugar">Volver</a></button>';
                                }
                                else
                                {   // Cuando se envia el formulario
                                    // Comprueba que la variable del formulario no este vacia
                                    // SI esta vacia da error, campo vacio
                                    if (empty($_POST["nombre"]))
                                    {
                                        echo '<p class="errorup">Error - Campo Vacio</p>';
                                        echo '<button class="volver"><a href="PaginaAdministrador.php?opcion=lugar">Volver</a></button>';
                                    }
                                    else
                                    {
                                        // Si no esta vacia entra
                                        // Se guarda la variable enviada por el formulario entre comilla en otra variable.
                                        $nombre = "'" . $_POST["nombre"] . "'";

                                        // Consulta para comprobar que existe ese nombre
                                        $consulta = "SELECT * FROM lugar WHERE nombreLugar=" . $nombre . ";";
                                        //print_r($consulta);

                                        $objeto->realizarConsultas($consulta);

                                        // Si existe ese nombre, por lo tanto ese lugar existe muestra un mensaje de erro, ya existe ese lugar
                                        if ($objeto->comprobarSelect() > 0)
                                        {
                                            echo '<p class="errorup">Error - Ese Lugar ya existe</p>';
                                            echo '<button class="volver"><a href="PaginaAdministrador.php?opcion=lugar&opcionlugar=agregar">Volver</a></button>';
                                        }
                                        else
                                        {
                                            // Si ese lugar no existe

                                            // Consulta para insertar ese lugar.
                                            $consulta = "INSERT INTO lugar (nombreLugar) values (" . $nombre . ");";

                                            // print_r($consulta);
                                            $objeto->realizarConsultas($consulta);

                                            // Comprueba que se inserto bien
                                            if ($objeto->comprobar() > 0)
                                            {
                                                echo '<p class="correctoup">Se introduzco correctamente el lugar ' . $nombre . '</p>';
                                            } else
                                            {
                                                echo '<p class="errorup">Error - Hubo un problema con la BD</p>';
                                            }
                                            echo '<button class="volver"><a href="PaginaAdministrador.php?opcion=lugar&opcionlugar=agregar">Volver</a></button>';
                                        }
                                    }
                                }
                            }
                            else
                            {
/*--- Lugares Modificar ---------------------------------------------------------------------------*/
                                if ($_GET["opcionlugar"] == "modificar")
                                {

                                }
                                else
                                {
/*--- Lugares Eliminar ---------------------------------------------------------------------------*/
                                    if ($_GET["opcionlugar"] == "eliminar")
                                    {

                                    } else
                                    {
/*--- Lugares Listar ---------------------------------------------------------------------------*/
                                        if ($_GET["opcionlugar"] == "listar")
                                        {
                                            echo '<h2>Lista de Lugares</h2>';

                                            $consulta = "SELECT * FROM lugar ORDER BY idLugar;";

                                            $objeto->realizarConsultas($consulta);

                                            if ($objeto->comprobarSelect() > 0)
                                            {
                                                echo '<table>';
                                                echo '<tr>';
                                                    echo '<th>Id</th>';
                                                    echo '<th>Nombre del Lugar</th>';
                                                echo '</tr>';

                                                while ($fila = $objeto->extraerFilas())
                                                {
                                                    echo '<tr>';
                                                        echo '<td>' . $fila["idLugar"] . '</td>';
                                                        echo '<td>' . $fila["nombreLugar"] . '</td>';
                                                    echo '</tr>';
                                                }
                                                echo '</table>';

                                                echo '<button class="volver"><a href="PaginaAdministrador.php?opcion=lugar">Volver</a></button>';
                                            } else
                                            {
                                                // Muestra un error de que la contraseña o usuario es incorrecto.
                                                echo '<h2>Error</h2>';
                                                echo '<p class="errorup">No hay datos.</p>';
                                                echo '<button class="volver"><a href="InicioSesion-Administrador.php">Volver</a></button>';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    else
                    {
/*--- Jesuitas ---------------------------------------------------------------------------*/
                        if ($_GET["opcion"] == "jesuita")
                        {
                            echo 'jesuita';
                            echo '<button class="volver"><a href="PaginaAdministrador.php">Volver</a></button>';
                        }
                        else
                        {
/*--- Usuarios ---------------------------------------------------------------------------*/
                            if ($_GET["opcion"] == "usuario")
                            {
                                if (!isset($_GET["opcionusuario"]))
                                {
                                    echo '<h2>Gestion de Usuario</h2>';
                                    echo '<div class="opciones">';
                                    echo '<ul>';
                                    echo '<li><a href="PaginaAdministrador.php?opcion=usuario&opcionusuario=agregar">Agregar</a></li>';
                                    echo '<li><a href="PaginaAdministrador.php?opcion=usuario&opcionusuario=modificar">Modificar</a></li>';
                                    echo '<li><a href="PaginaAdministrador.php?opcion=usuario&opcionusuario=eliminar">Eliminar</a></li>';
                                    echo '<li><a href="PaginaAdministrador.php?opcion=usuario&opcionusuario=listar">Listar</a></li>';
                                    echo '</ul>';
                                    echo '</div>';
                                    echo '<button class="volver"><a href="PaginaAdministrador.php">Volver</a></button>';
                                }
                                else
                                {
/*--- Usuarios Agregar ---------------------------------------------------------------------------*/
                                    if ($_GET["opcionusuario"] == "agregar")
                                    {
                                        echo '<h2>Agregar Usuario</h2>';

                                        if (!isset($_POST["Agregar"]))
                                        {
                                            echo '<form action="#" METHOD="POST">';
                                            echo '<input type="text" placeholder="Ip de tu Maquina *" name="ip">';

                                            echo '<input type="submit" value="Agregar" name="Agregar">';
                                            echo '</form>';

                                            echo '<button class="volver"><a href="PaginaAdministrador.php?opcion=usuario">Volver</a></button>';
                                        }
                                        else
                                        {   // Cuando se envia el formulario
                                            // Comprueba que la variable del formulario no este vacia
                                            // SI esta vacia da error, campo vacio
                                            if ((empty($_POST["ip"])) and (empty($_POST["ip"])) and (empty($_POST["password"])))
                                            {
                                                echo '<p class="errorup">Error - Campo Vacio</p>';
                                                echo '<button class="volver"><a href="PaginaAdministrador.php?opcion=usuario&opcionusuario=agregar">Volver</a></button>';
                                            }
                                            else
                                            {
                                                // Si no esta vacia entra
                                                // Se guarda la variable enviada por el formulario entre comilla en otra variable.
                                                $ip = "'" . $_POST["ip"] . "'";

                                                // Consulta para comprobar que existe ese nombre
                                                $consulta = "SELECT * FROM maquina WHERE ip=" . $ip . ";";
                                                //print_r($consulta);

                                                $objeto->realizarConsultas($consulta);

                                                // Si existe ese nombre, por lo tanto ese lugar existe muestra un mensaje de erro, ya existe ese lugar
                                                if ($objeto->comprobarSelect() > 0)
                                                {
                                                    echo '<p class="errorup">Error - Ese usuario ya existe</p>';
                                                    echo '<button class="volver"><a href="PaginaAdministrador.php?opcion=usuario&opcionusuario=agregar">Volver</a></button>';
                                                }
                                                else
                                                {
                                                    // Si ese lugar no existe

                                                    // Consulta para insertar ese lugar.
                                                    $consulta = "INSERT INTO maquina (ip, password) values (" . $ip . ", '123456');";

                                                    // print_r($consulta);
                                                    $objeto->realizarConsultas($consulta);

                                                    // Comprueba que se inserto bien
                                                    if ($objeto->comprobar() > 0)
                                                    {
                                                        echo '<p class="correctoup">Se introduzco correctamente el usuario ' . $ip . '</p>';
                                                    }
                                                    else
                                                    {
                                                        echo '<p class="errorup">Error - Hubo un problema con la BD</p>';
                                                    }
                                                    echo '<button class="volver"><a href="PaginaAdministrador.php?opcion=usuario&opcionusuario=agregar">Volver</a></button>';
                                                }
                                            }
                                        }
                                    }
/*--- Usuarios Modificar ---------------------------------------------------------------------------*/
                                    else
                                    {
                                        if ($_GET["opcionusuario"] == "modificar")
                                        {
                                            echo '<h2>Modificar Usuario</h2>';

                                            if (!isset($_POST["Modificar"]))
                                            {
                                                echo '<form action="#" METHOD="POST">';
                                                    echo '<input type="text" placeholder="Ip de la Maquina *" name="ip">';
                                                    echo '<input type="text" placeholder="Ip de la Maquina Nueva" name="ipnew">';
                                                    echo '<input type="text" placeholder="Nombre del Alumno" name="nombreAlumno">';
                                                    echo '<input type="password" placeholder="password" name="password">';

                                                    $consulta = "SELECT * FROM lugar";

                                                    $objeto->realizarConsultas($consulta);

                                                    if ($objeto->comprobar() > 0)
                                                    {
                                                        echo '<select class="centrar" name="lugar">';
                                                            echo '<option value="vacio">Elige Lugar</option>';
                                                        while ($fila = $objeto->extraerFilas())
                                                        {
                                                            echo '<option value="' . $fila["idLugar"] . '">' . $fila["nombreLugar"] . '</option>';
                                                        }
                                                        echo '</select>';
                                                    }
                                                    else
                                                    {
                                                        echo '<p class="centrar"> Aun no hay lugares </p>';
                                                    }

                                                    $consulta = "SELECT * FROM jesuita";

                                                    $objeto->realizarConsultas($consulta);

                                                    if ($objeto->comprobar() > 0)
                                                    {
                                                        echo '<select name="jesuita">';
                                                            echo '<option value="vacio">Elige Jesuita</option>';
                                                        while ($fila = $objeto->extraerFilas())
                                                        {
                                                            echo '<option value="' . $fila["idJesuita"] . '">' . $fila["nombreJesuita"] . '</option>';
                                                        }
                                                        echo '</select>';
                                                    }
                                                    else
                                                    {
                                                        echo '<p class="centrar"> Aun no hay lugares </p>';
                                                    }

                                                    echo '<input type="submit" value="Modificar" name="Modificar">';
                                                echo '</form>';

                                                echo '<button class="volver"><a href="PaginaAdministrador.php?opcion=usuario">Volver</a></button>';
                                            }
                                            else
                                            {
                                                // Si esta vacio la ip
                                                if (empty($_POST["ip"]))
                                                {
                                                    echo '<p class="errorup">Error - Campo Obligatorio Vacio</p>';
                                                    echo '<button class="volver"><a href="PaginaAdministrador.php?opcion=usuario&opcionusuario=modificar">Volver</a></button>';
                                                }
                                                else
                                                {
                                                    $consulta = "SELECT * FROM maquina WHERE ip='" . $_POST["ip"] . "';";
                                                    //print_r($consulta);
                                                    $objeto->realizarConsultas($consulta);

                                                    if ($objeto->comprobarSelect() > 0)
                                                    {
                                                        // Si esta rellena la ip nueva
                                                        if (!empty($_POST["ipnew"]))
                                                        {
                                                            $consulta = "UPDATE maquina SET ip='" . $_POST["ipnew"] . "' WHERE ip='" . $_POST["ip"] . "';";
                                                            $objeto->realizarConsultas($consulta);

                                                            if ($objeto->comprobar() > 0)
                                                            {
                                                                echo '<p class="correctoup">Se cambio de ip correctamente</p>';
                                                            }
                                                            else
                                                            {
                                                                echo '<p class="errorup">Error - Hubo un problema con el cambio de ip</p>';
                                                            }
                                                        }
                                                        else
                                                        {
                                                            // echo 'ipnew esta vacia';
                                                        }
                                                        // Si esta rellena el nombreAlumno
                                                        if (!empty($_POST["nombreAlumno"]))
                                                        {
                                                            $consulta = "UPDATE maquina SET nombreAlumno='" . $_POST["nombreAlumno"] . "' WHERE ip='" . $_POST["ip"] . "';";
                                                            //print_r($consulta);
                                                            $objeto->realizarConsultas($consulta);

                                                            if ($objeto->comprobar() > 0)
                                                            {
                                                                echo '<p class="correctoup">Se cambio el nombre correctamente</p>';
                                                            }
                                                            else
                                                            {
                                                                echo '<p class="errorup">Error - Hubo un problema con el cambio de nombre</p>';
                                                            }
                                                        }
                                                        else
                                                        {
                                                            // echo 'nombrealumno esta vacia';
                                                        }

                                                        // Si esta rellena el password
                                                        if (!empty($_POST["password"]))
                                                        {
                                                            $consulta = "UPDATE maquina SET password='" . $_POST["password"] . "' WHERE ip='" . $_POST["ip"] . "';";
                                                            $objeto->realizarConsultas($consulta);

                                                            if ($objeto->comprobar() > 0)
                                                            {
                                                                echo '<p class="correctoup">Se cambio el password correctamente</p>';
                                                            }
                                                            else
                                                            {
                                                                echo '<p class="errorup">Error - Hubo un problema con el cambio password</p>';
                                                            }

                                                        }
                                                        else
                                                        {
                                                            // echo 'password esta vacia';
                                                        }
                                                        // Si esta rellena el lugar
                                                        if (!empty($_POST["lugar"]))
                                                        {
                                                            if($_POST["lugar"] != 'vacio')
                                                            {
                                                                $consulta = "UPDATE maquina SET lugar='" . $_POST["idLugar"] . "' WHERE ip='" . $_POST["ip"] . "';";
                                                                $objeto->realizarConsultas($consulta);

                                                                if ($objeto->comprobar() > 0)
                                                                {
                                                                    echo '<p class="correctoup">Se cambio el lugar correctamente</p>';
                                                                }
                                                                else
                                                                {
                                                                    echo '<p class="errorup">Error - Hubo un problema con el cambio del lugar</p>';
                                                                }
                                                            }
                                                        }
                                                        else
                                                        {
                                                            // echo 'idLugar esta vacia';
                                                        }
                                                        // Si esta rellena el jesuita
                                                        if (!empty($_POST["jesuita"]))
                                                        {
                                                            if($_POST["lugar"] != 'vacio')
                                                            {
                                                                $consulta = "UPDATE maquina SET jesuita='" . $_POST["idJesuita"] . "' WHERE ip='" . $_POST["ip"] . "';";
                                                                $objeto->realizarConsultas($consulta);

                                                                if ($objeto->comprobar() > 0)
                                                                {
                                                                    echo '<p class="correctoup">Se cambio el jesuita correctamente</p>';
                                                                }
                                                                else
                                                                {
                                                                    echo '<p class="errorup">Error - Hubo un problema con el cambio del jesuita</p>';
                                                                }
                                                            }
                                                        }
                                                        else
                                                        {
                                                            // echo 'idJesuita esta vacia';
                                                        }
                                                        echo '<button class="volver"><a href="PaginaAdministrador.php?opcion=usuario&opcionusuario=modificar">Volver</a></button>';
                                                    }
                                                    else
                                                    {
                                                        echo '<p class="errorup">Error - Esa ip no existe</p>';
                                                    }
                                                }
                                            }
                                        }
/*--- Usuarios Eliminar ---------------------------------------------------------------------------*/
                                        else
                                        {
                                            if ($_GET["opcionusuario"] == "eliminar")
                                            {
                                                echo '<h2>Eliminar Usuario</h2>';
                                                if (!isset($_POST["Eliminar"]))
                                                {
                                                    echo '<form action="" METHOD="POST">';
                                                        echo '<input type="text" placeholder="Ip de la Maquina " name="ip">';

                                                        echo '<input type="submit" value="Eliminar" name="Eliminar">';
                                                    echo '</form>';

                                                    echo '<button class="volver"><a href="PaginaAdministrador.php?opcion=usuario">Volver</a></button>';
                                                }
                                                else
                                                {
                                                    if(!isset($_POST["confirmacion"]))
                                                    {
                                                        echo '<form action="" METHOD="POST">';
                                                            echo '<label class="centrar2">Seguro que quieres eliminar el usuario?</label>';
                                                            echo '<label class="centrar2">'.$_POST["ip"].'</label>';

                                                            echo '<input type="checkbox" name="confirmacion" value="SI">Si';
                                                            echo '<input type="checkbox" name="confirmacion" value="No">No';


                                                            echo '</br><input type="submit" value="Enviar" name="enviar"/>';
                                                        echo '</form>';
                                                    }
                                                    else
                                                    {
                                                        if($_POST["confirmacion"]=='SI')
                                                        {
                                                            echo 'hola';
                                                            echo $_POST["ip"];
                                                        }
                                                        if($_POST["confirmacion"]=='NO')
                                                        {
                                                            echo 'adios';
                                                        }
                                                    }

                                                    echo '<button class="volver"><a href="PaginaAdministrador.php?opcion=usuario&eliminar">Volver</a></button>';


                                                }
                                            }
                                            else
                                            {

                                            }
                                        }
                                        {
                                        }
                                    }
                                }
                            } /*--- Cerrar Sesion ---------------------------------------------------------------------------*/
                            else {
                                if ($_GET["opcion"] == "cerrarsesion")
                                {
                                    echo 'cerrarsesion';
                                    //header('Location: InicioSesion-Administrador.php');

                                    echo '<button class="volver"><a href="PaginaAdministrador.php">Volver</a></button>';
                                }
                            }
                        }
                    }
                }
            }
            else
            {
                header('Location: 1-PaginaPrincipal.php');
            }

        echo '</div>';
        ?>
    </body>
</html>