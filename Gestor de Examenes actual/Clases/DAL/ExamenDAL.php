<?php
    require_once("Examen.php");

    class ExamenDAL {
        private $usuario = 'root';
        private $contrasena = '1234';
        private $servidor = "localhost";
        private $basededatos = 'gestor_examenes';
    
        public function insertExamen($examen) {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $consulta = (sprintf("INSERT INTO examenes (tema, fechaExamen, enlaceAcceso, idProfesor) VALUES('%s', '%s', '%s', '%s');",
            $examen -> getTema(), $examen -> getFechaExamen(), $examen -> getEnlaceAcceso(), $examen -> getIdProfesor()));

            mysqli_query($conexion, $consulta);

            $idExamen = mysqli_insert_id($conexion);
            $examen -> setIdTutor($idExamen);
            
            mysqli_close($conexion);
        }

        public function getExamenes(): array {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $consulta = (sprintf("SELECT * FROM examenes"));
            $resultado = mysqli_query($conexion, $consulta);
            $registros = array();

            while($registro = mysqli_fetch_array($resultado)) {
                $examen = new Examen ($registro["idExamen"], $registro["tema"], $registro["fechaExamen"], $registro["enlaceAccceso"], $registro["idProfesor"]);

                $registros[] = $examen;
            } 
            
            mysqli_close($conexion);

            return $registros;
        }
    }
?>