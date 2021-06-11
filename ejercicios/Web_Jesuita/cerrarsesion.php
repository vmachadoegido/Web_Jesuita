<?php
//Iniciar sesion
session_start();

// Cerrar sesion
session_destroy();

// Lo envia a la pagina inicio-sesion
header('Location: 0-rankingvisitas.php');

