<?php
    require_once("ExamenYPregunta.php");

    class TutorDAL {
        private $usuario = 'root';
        private $contrasena = '1234';
        private $servidor = "localhost";
        private $basededatos = 'gestor_examenes';
    
        public function insertTutor($examenYPregunta) {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $consulta = (sprintf("INSERT INTO examenesYPreguntas (nombre, apellido) VALUES('%s', '%s');",
            $examenYPregunta -> getNombre(), $examenYPregunta -> getApellido()));

            mysqli_query($conexion, $consulta);

            $idTutor = mysqli_insert_id($conexion);
            $examenYPregunta -> setIdTutor($idTutor);
            
            mysqli_close($conexion);
        }

        public function getTutores(): array {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $consulta = (sprintf("SELECT * FROM examenesYPreguntas"));
            $resultado = mysqli_query($conexion, $consulta);
            $registros = array();

            while($registro = mysqli_fetch_array($resultado)) {
                $examenYPregunta = new Tutor ($registro["Id_Tutor"], $registro["nombre"], $registro["apellido"]);

                $registros[] = $examenYPregunta;
            } 
            
            mysqli_close($conexion);

            return $registros;
        }
    }
?>