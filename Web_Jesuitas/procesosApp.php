<?php
    // Se trae los datos del servidot
    include 'conexion.php';

    class procesosApp
    {
        public $mysqli;

        function iniciosession($ip, $password)
        {
            // Establece la conexion
            $this->mysqli = new mysqli(servidor, usuario, password, basedatos);

            // Analizar Consulta
            $consulta = $this->mysqli->prepare("SELECT * FROM maquina WHERE ip=?");

            // Preparar Consulta
            $consulta->bind_param('s', $ip);
            // Ejecutar consulta
            $consulta->execute();

            // Devuelve la fila
            $resultado = $consulta->get_result();

            // Si hay filas afectadas, es correcto.
            if($resultado->num_rows>0)
            {
                // Extraer filas
                $fila = $resultado->fetch_array();

                //echo $password;
                //echo '<br>'.$fila["password"].'';
                if (password_verify($password, $fila["password"]))
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

        function iniciosession2($ip, $password)
        {
            // Establece la conexion
            $this->mysqli = new mysqli(servidor, usuario, password, basedatos);

            // Analizar Consulta
            $consulta = $this->mysqli->prepare("SELECT * FROM nombreAdministrador  WHERE ip=?");

            // Preparar Consulta
            $consulta->bind_param('s', $ip);
            // Ejecutar consulta
            $consulta->execute();

            // Devuelve la fila
            $resultado = $consulta->get_result();

            // Si hay filas afectadas, es correcto.
            if($resultado->num_rows>0)
            {
                // Extraer filas
                $fila = $resultado->fetch_array();

                //echo $password;
                //echo '<br>'.$fila["password"].'';
                if (password_verify($password, $fila["password"]))
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