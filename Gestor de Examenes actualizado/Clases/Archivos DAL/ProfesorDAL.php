<?php
    require_once("tutor.php");

    class TutorDAL {
        private $usuario = 'root';
        private $contrasena = '1234';
        private $servidor = "localhost";
        private $basededatos = 'gestor_alumnos';
    
        public function insertTutor($tutor) {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $consulta = (sprintf("INSERT INTO tutores (nombre, apellido) VALUES('%s', '%s');",
            $tutor -> getNombre(), $tutor -> getApellido()));

            mysqli_query($conexion, $consulta);

            $idTutor = mysqli_insert_id($conexion);
            $tutor -> setIdTutor($idTutor);
            
            mysqli_close($conexion);
        }

        public function getTutores(): array {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $consulta = (sprintf("SELECT * FROM tutores"));
            $resultado = mysqli_query($conexion, $consulta);
            $registros = array();

            while($registro = mysqli_fetch_array($resultado)) {
                $tutor = new Tutor ($registro["Id_Tutor"], $registro["nombre"], $registro["apellido"]);

                $registros[] = $tutor;
            } 
            
            mysqli_close($conexion);

            return $registros;
        }
    }
?>