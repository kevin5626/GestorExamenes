<?php
    require_once("alumno.php");

    class AlumnoDAL {
        private $usuario = 'root';
        private $contrasena = '1234';
        private $servidor = "localhost";
        private $basededatos = 'gestor_examenes';
    
        public function insertAlumno($alumno) {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            // $consulta = (sprintf("INSERT INTO alumnos (idUsuario) VALUES('%s');",
            // $alumno -> getNombre(), $alumno -> getApellido()));

            mysqli_query($conexion, $consulta);

            $idAlumno = mysqli_insert_id($conexion);
            $alumno -> setIdAlumno($idAlumno);
            
            mysqli_close($conexion);
        }

        public function getAlumnos(): array {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $consulta = (sprintf("SELECT * FROM alumnos"));
            $resultado = mysqli_query($conexion, $consulta);
            $registros = array();

            while($registro = mysqli_fetch_array($resultado)) {
                $alumno = new Tutor ($registro["idAlumno"], $registro["idUsuario"]);

                $registros[] = $alumno;
            } 
            
            mysqli_close($conexion);

            return $registros;
        }
    }
?>