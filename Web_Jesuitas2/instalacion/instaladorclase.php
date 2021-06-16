<?php

// Traer los valores de la conexion.
include 'conexion.php';

class instaladorclase
{
    public $mysqli;
    public $resultado;

    // COntructor que siempre ejecuta la coenxion con la Base de Datos.
    function __construct()
    {
        $this->mysqli = new mysqli(servidor, usuario, password);
    }

    // Funcion para realizar la consulta.
    function realizarConsultas($sql)
    {
        $this->resultado = $this->mysqli->multi_query($sql);
    }

    function comprobar()
    {
        return $this->mysqli->affected_rows;
    }
}