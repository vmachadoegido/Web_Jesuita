<?php
    // Traer los valores de la conexion.
    include 'conexion.php';
    class clasephp
    {
        public $mysqli;
        public $resultado;

        // COntructor que siempre ejecuta la coenxion con la Base de Datos.
        function __construct()
        {
            $this->mysqli = new mysqli(servidor, usuario, password, basedatos);
        }

        // Funcion para realizar la consulta.
        function realizarConsultas($sql)
        {
            $this->resultado = $this->mysqli->query($sql);
        }

        // Funcion para comprar una consulta SELECT.
        function comprobarSelect()
        {
            return $this->resultado->num_rows;
        }

        // Funcion para comprar una consulta INSERT, UPDATE, REPLACE or DELETE.
        function comprobar()
        {
            return $this->mysqli->affected_rows;
        }

        // Funcion para extraer filas de la consulta.
        function extraerFilas()
        {
            return $this->resultado->fetch_array();
        }
    }
?>
