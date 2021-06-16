<?php
    include 'conexion.php';
    class clasephp
    {
        public $mysqli;
        public $resultado;
        function __construct()
        {
            $this->mysqli = new mysqli(servidor, usuario, password, basedatos);
        }

        function realizarConsultas($sql)
        {
            $this->resultado = $this->mysqli->query($sql);
        }

        function comprobarSelect()
        {
            return $this->resultado->num_rows;
        }

        function comprobar(){
            return $this->mysqli->affected_rows;
        }
        function extraerFilas(){
            return $this->resultado->fetch_array();
        }

        function iniciosession2($usuario, $password)
        {
            // Establece la conexion
            $this->mysqli = new mysqli(servidor, usuario, password, basedatos);

            // Analizar Consulta
            $consulta = $this->mysqli->prepare("SELECT * FROM administrador WHERE nombreAdministrador=?");

            // Preparar Consulta
            $consulta->bind_param('s', $usuario);
            // Ejecutar consulta
            $consulta->execute();

            // Devuelve la fila
            $resultado = $consulta->get_result();

            // Si hay filas afectadas, es correcto.
            if($resultado->num_rows>0)
            {
                // Extraer filas
                $fila = $resultado->fetch_array();

                if (password_verify(''.$password.'', ''.$fila["password"].''))
                {
                    // Usuario correcto
                    return 'true';
                }
                else
                {
                    // password incorrecto
                    return 'false';
                }
            }
            else
            {
               // usuario incorrecto
                return 'false';
            }
        }

    }
?>
