-- Base de datos BD_Jesuitas (viajes de los jesuitas)
-- DROP TABLE Jesuitas;
CREATE DATABASE IF NOT EXISTS jesuitasviajeros DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE jesuitasviajeros;

-- Estructura tabla Jesuita
CREATE TABLE administrador(
	nombreAdministrador varchar(60),
	password varchar(255)
	
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Estructura tabla Lugar
CREATE TABLE lugar(
	idLugar tinyint unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nombreLugar varchar(50) NOT NULL UNIQUE
	
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Estructura tabla Jesuita
CREATE TABLE jesuita(
	idJesuita tinyint unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nombreJesuita varchar(60) NOT NULL UNIQUE,
	firma varchar(300)NOT NULL
	
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE maquina(
	ip char(15) NOT NULL PRIMARY KEY,
	nombreAlumno varchar(60) NULL UNIQUE,
	password varchar(255) NOT NULL,
	primera_vez boolean DEFAULT 0,
	lugar tinyint unsigned NULL,
	jesuita tinyint unsigned NULL,
	
	FOREIGN KEY (lugar) REFERENCES lugar(idLugar),
	FOREIGN KEY (jesuita) REFERENCES jesuita(idJesuita)
	
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE visita(
	idVisita SMALLINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	idLugar tinyint unsigned NOT NULL,
	idJesuita tinyint unsigned NOT NULL,
	fechaHora datetime NOT NULL default NOW(),
	
	FOREIGN KEY (idLugar) REFERENCES lugar(idLugar),
	FOREIGN KEY (idJesuita) REFERENCES jesuita(idJesuita),
	
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE informacion_J(
	idJesuita tinyint unsigned NOT NULL,
	infomacion varchar(255) NOT NULL,
	FOREIGN KEY (idJesuita) REFERENCES jesuita(idJesuita)
	
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;




