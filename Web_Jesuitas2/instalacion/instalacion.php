<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Instalacion</title>
        <link rel="stylesheet" type="text/css" href="../style.css">
    </head>
    <body>
        <div id="general">
            <?php
                if(!isset($_POST["Instalar"]))
                {

                    echo '<h1>Crear BD Jesuita Viajero</h1>';
                    echo '<div class="caja">';
                        echo '<div>';
                            // Formulario de Inicio de Sesion
                            // Al darle al boton enviar, va hacia Pag2-CrearTablas.php
                            echo '<form action="instalacion.php" METHOD="POST">';
                                // Boton de enviar
                                echo '<input type="submit" value="Instalar" name="Instalar"/>';
                            echo '</form>';
                        echo '</div>';
                    echo '</div>';
                }
                else
                {
                    // Traer los metodos de la pagina operaciones.php
                    require_once 'instaladorclase.php';
                    // Crear el objeto de la operaciones.
                    $objeto=new instaladorclase();

                    $consulta = "
CREATE DATABASE IF NOT EXISTS jesuitasviajeros DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE jesuitasviajeros;

CREATE TABLE administrador
(
	nombreAdministrador varchar(60),
	password varchar(255)
	
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE lugar
(
	idLugar tinyint unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nombreLugar varchar(50) NOT NULL UNIQUE
	
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE jesuita
(
	idJesuita tinyint unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nombreJesuita varchar(60) NOT NULL UNIQUE,
	firma varchar(300)NOT NULL
	
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE maquina
(
	ip char(15) NOT NULL PRIMARY KEY,
	nombreAlumno varchar(60) NULL UNIQUE,
	password varchar(255) NOT NULL,
	primera_vez boolean DEFAULT 0,
	lugar tinyint unsigned NULL,
	jesuita tinyint unsigned NULL,
	
	FOREIGN KEY (lugar) REFERENCES lugar(idLugar),
	FOREIGN KEY (jesuita) REFERENCES jesuita(idJesuita)
	
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE visita
(
	idVisita SMALLINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	idLugar tinyint unsigned NOT NULL,
	idJesuita tinyint unsigned NOT NULL,
	fechaHora datetime NOT NULL default NOW(),
	
	FOREIGN KEY (idLugar) REFERENCES maquina(lugar) On Update Cascade On Delete Cascade,
	FOREIGN KEY (idJesuita) REFERENCES maquina(jesuita) On Update Cascade On Delete Cascade,
	
	UNIQUE (idLugar, idJesuita),
    CHECK(idLugar<>idJesuita)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE informacion_J
(
	idJesuita tinyint unsigned NOT NULL,
	infomacion varchar(255) NOT NULL,
	FOREIGN KEY (idJesuita) REFERENCES jesuita(idJesuita) On Update Cascade On Delete Cascade
	
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;";

                    $objeto->realizarConsultas($consulta);

                    // Si devuelve filas
                    if($objeto->comprobar()>0)
                    {
                        //echo '<p>Correcto</p>';
                        header('Location: crearadmin.php');
                    }
                    else
                    {
                        echo '<p>Ya esta creado esa BD</p>';
                        echo '</br><a href="instalacion.php" class="boton"> Volver </a></br>';
                    }
                }
            ?>
        </div>
    </body>
</html>
