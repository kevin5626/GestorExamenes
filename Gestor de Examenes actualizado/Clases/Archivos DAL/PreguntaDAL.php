<?php
    require_once("Pregunta.php");

    class PreguntaDAL {
        private $usuario = 'root';
        private $contrasena = '1234';
        private $servidor = "localhost";
        private $basededatos = 'gestor_examenes';
    
        public function insertPregunta($pregunta) {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $consulta = (sprintf("INSERT INTO preguntas (materia, tema, subtema, dificultad, textoPregunta, respuestas, respuestaCorrecta, apariciones) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
            $pregunta -> getMateria(), $pregunta -> getTema(), $pregunta -> getSubtema(), $pregunta -> getDificultad(), $pregunta -> getTextoPregunta(), $pregunta -> getRespuestas(), $pregunta -> getRespuestaCorrecta(), $pregunta -> getApariciones()));

            mysqli_query($conexion, $consulta);

            $idPregunta = mysqli_insert_id($conexion);
            $pregunta -> setIdPregunta($idPregunta);
            
            mysqli_close($conexion);
        }

        public function getPreguntas(): array {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $consulta = (sprintf("SELECT * FROM preguntas"));
            $resultado = mysqli_query($conexion, $consulta);
            $registros = array();

            while($registro = mysqli_fetch_array($resultado)) {
                $pregunta = new Pregunta ($registro["idPregunta"], $registro["materia"], $registro["tema"], $registro["subtema"], $registro["dificultad"], $registro["textoPregunta"], $registro["respuestas"], $registro["respuestaCorrecta"], $registro["apariciones"]);

                $registros[] = $pregunta;
            } 
            
            mysqli_close($conexion);

            return $registros;
        }
    }
?>