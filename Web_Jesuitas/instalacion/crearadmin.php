<!DOCTYPE html>
<!-- Victor Manuel Machado Egido -->
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Instalacion - Crear admin</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div id="general">
            <?php
                // Hasta que no se le da al boton crear no sale.
                if(!isset($_POST["Crear"]))
                {
                    // Formulario
                    echo '<h1>Crear Admin</h1>';
                    // Formulario de Creacion del Gestor
                    echo '<form METHOD="POST" >';
                        echo '<table>';
                            echo '<tr>';
                                // Introducir Nombre de Usuario
                                echo '<td><label for ="nombreusuario">Usuario</label></td>';
                                echo '<td><input type="text" name="nombreusuario" placeholder="Usuario" required/></td>';
                            echo '</tr>';
                            echo '<tr>';
                                // Introducir Contraseña
                                echo '<td><label for ="password">Introduce la contraseña</label></td>';
                                echo '<td><input type="password" name="password" placeholder="Password" required/></td>';
                            echo '</tr>';
                            echo '<tr>';
                                // Introducir Contraseña 2
                                echo '<td><label for ="password2">Introduce de nuevo contraseña</label></td>';
                                echo '<td><input type="password" name="password2" placeholder="Password" required/></td>';
                            echo '</tr>';
                            echo '</table>';
                            // Boton Enviar
                            echo '<td rowspan="2" style="text-align:center;" ><input type="submit" value="Crear" name="Crear"/></td>';
                    echo '</form>';
                }
                else
                {
                    // Si son iguales las contraseñas introducidas
                    if($_POST["password"] == $_POST["password2"])
                    {
                        include '../operaciones.php';
                        $objeto = new operaciones();


                        // Consulta para crear el admin
                        $consulta = "INSERT INTO administrador (nombreAdministrador, password) VALUES ('".$_POST["nombreusuario"]."', '".password."')";
                        //print_r($consulta);

                        $objeto->realizarConsultas($consulta);

                        if($objeto->comprobar()>0)
                        {
                            echo '<p>Creado usuario admin</p>';
                            echo '</br><a href="../0-rankingvisitas.php" class="boton"> Pagina Inicio </a></br>';
                        }
                        else
                        {
                            echo '<p>Hubo un problema inesperado</p>';
                            echo '</br><a href="crearadmin.php" class="boton"> Volver </a></br>';
                        }

                    }
                    else // Si no son iguales.
                    {
                        echo '<p>La contraseña no coinciden</p>';
                        echo '</br><a href="crearadmin.php" class="boton"> Volver </a></br>';
                    }


                }
            ?>
        </div>
    </body>
</html>
