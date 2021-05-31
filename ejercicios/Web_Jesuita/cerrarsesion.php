<?php
// Cerrar sesion
session_destroy();
// Lo envia a la pagina inicio-sesion
header('Location: inicio-sesion.php');

