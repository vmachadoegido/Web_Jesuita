<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Inicio Sesion</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php
            echo '<div id="contenedor">';
                if(!isset($_POST["Enviar"]))
                {
                    echo '<form action="" METHOD="POST">';
                        echo '<h2>Inicio de Sesion</h2>';
                        echo '<input type="text" placeholder="Usuario" name="usuario">';
                        echo '<input type="password" placeholder="Password" name="password">';
                        echo '<input type="submit" value="Enviar" name="Enviar">';
                    echo '</form>';
                }
                else
                {
                    // Inicia Sesion
                    session_start();

                    // Traer los metodos de la pagina operaciones.php
                    require_once 'operaciones.php';

                    // Crear el objeto de la operaciones.
                    $objeto = new operaciones();

                    // Guardar los datos del formulario en variables.
                    $usuario = $_POST["usuario"];
                    $password = $_POST["password"];

                    // Si esta vacio el usuario
                    if(empty($usuario))
                    {
                        echo '<p class="centrarvisita">No pusiste el usuario </p>';
                        echo '<a href="inicio-sesion.php" class="boton"> Volver </br></a>';
                    }
                    else
                    {
                        // Analizar la consulta y guardarla
                        $consultar = $objeto->conexion()->prepare("SELECT * FROM maquina WHERE ip=? AND password=?");
                        // Preparar la consulta
                        $consultar->bind_param("ss", $usuario, $password);
                        // Ejecutar la consulta
                        $consultar->execute();
                        // Devuelve el resultado de la consulta
                        $resultado = $consultar->get_result();

                        // Si el numero de filas es mas de 0, significa que devolvio filas la consulta.
                        // Por lo tanto es correcto los datos introducidos
                        if ($resultado->num_rows > 0)
                        {
                            // echo 'Correcto';
                            // Recorrer las filas de la consulta
                            $fila = $resultado->fetch_assoc();

                            // Guardar las variables
                            $_SESSION["ip"] = $fila["ip"];
                            $_SESSION["jesuita"] = $fila["jesuita"];
                            $_SESSION["usuario"] = 'usuario';

//                            // Si es la primera vez,de su inicio cambie la contraseña
//                            if($fila["primera_vez"] == 0)
//                            {
//                                // Default 0 - true es primera vez
//                            }
//                            else
//                            {
//                                // 1 - false NO es la primera vez
//                            }

                            header('Location: 0-rankingvisitas.php');
                        }
                        else
                        {
                            echo '<p class="centrarvisita">El usuario o contraseña son incorrecto</p>';
                            echo '<a href="inicio-sesion.php" class="boton"> Volver </br></a>';
                        }

                    }
/*- Encriptacion -------------------------------------------------------------------------------------*/
/*
                        // Analizar la consulta y guardarla
                        $consultar = $objeto->conexion()->prepare("SELECT * FROM maquina WHERE ip=?");
                        // Preparar la consulta
                        $consultar->bind_param("s", $usuario);
                        // Ejecutar la consulta
                        $consultar->execute();
                        // Devuelve el resultado de la consulta
                        $resultado = $consultar->get_result();

                        // Si el numero de filas es mas de 0, significa que devolvio filas la consulta.
                        // Por lo tanto es correcto los datos introducidos
                        if($resultado->num_rows>0)
                        {
                            // Recorrer las filas de la consulta
                            $fila= $resultado->fetch_assoc();

                            // Verifica si la contraseña introducida es igual a la de la BD. QUe esta encriptada.
                            if (password_verify($password, $fila["password"]))
                            {
                                // Guardar las variables
                                $_SESSION["ip"] = $fila["ip"];
                                $_SESSION["jesuita"] = $fila["jesuita"];
                                $_SESSION["usuario"] = 'usuario';

                                //Si es la primera vez,de su inicio cambie la contraseña
//                                if($fila["primera_vez"] == 0)
//                                {
//                                    // Default 0 - true es primera vez
//                                }
//                                else
//                                {
//                                    // 1 - false NO es la primera vez
//                                }
                            }
                            else // SI la contraseña no coincide
                            {
                                echo '<p class="centrarvisita">El usuario o contraseña son incorrecto</p>';
                                echo '<a href="inicio-sesion.php" class="boton"> Volver </br></a>';
                            }
                        }
                        else // Si el usuario no existe.
                        {
                            echo '<p class="centrarvisita">El usuario o contraseña son incorrecto</p>';
                            echo '<a href="inicio-sesion.php" class="boton"> Volver </br></a>';
                        }
                    }
*/
                }
            echo '</div>';
        ?>
    </body>
</html>