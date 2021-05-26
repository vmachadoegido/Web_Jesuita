<?php

    // Traer los valores de la conexion.
    include 'conexion.php';
    class sesion
    {
        public $mysqli;
        public $resultado;

        function __construct()
        {
            $this->mysqli = new mysqli(servidor, usuario, password, basedatos);
        }


        function conexion($usuario, $password)
        {
            // Analiza la consulta
            $consulta =  $this->mysqli->prepare("SELECT * FROM maquina WHERE ip=? AND password=?");
            // Preparar
            $consulta->bind_param("ss", $usuario, $password);

            $consulta->execute();

            $this->resultado = $consulta->get_result();
            // Revisa si devuelve fila
            if($this->resultado->num_rows>0)
            {
                //echo 'Correcto';
                return 'true';
            }
            else
            {
                //echo 'Incorrecto';
                return 'false';
            }

        }
    }



