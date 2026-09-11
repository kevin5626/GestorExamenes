<?php
    require_once("Resultado.php");

    class ResultadoDAL {
        private $usuario = 'root';
        private $contrasena = '1234';
        private $servidor = "localhost";
        private $basededatos = 'gestor_examenes';
    
        public function insertResultado($resultado) {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $consulta = (sprintf("INSERT INTO resultados (fechaResultado, calificacion, cantidadErrores, cantidadAciertos, idExamen) VALUES('%s', '%s', '%s', '%s', '%s');",
            $resultado -> getFechaResultado(), $resultado -> getCAaificacion(), $resultado -> getCantidadErrores(), $resultado -> getCantidadAciertos(), $resultado -> getIdExamen()));

            mysqli_query($conexion, $consulta);

            $idResultado = mysqli_insert_id($conexion);
            $resultado -> setIdResultado($idResultado);
            
            mysqli_close($conexion);
        }

        public function getResultados(): array {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $consulta = (sprintf("SELECT * FROM resultados"));
            $resultado = mysqli_query($conexion, $consulta);
            $registros = array();

            while($registro = mysqli_fetch_array($resultado)) {
                $resultado = new Resultado ($registro["idResultado"], $registro["fechaResultado"], $registro["calificacion"], $registro["cantidadErrores"], $registro["cantidadAciertos"], $registro["idExamen"]);

                $registros[] = $resultado;
            } 
            
            mysqli_close($conexion);

            return $registros;
        }
    }
?>