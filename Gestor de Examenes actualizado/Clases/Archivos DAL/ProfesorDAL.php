<?php
    require_once("Profesor.php");

    class TutorDAL {
        private $usuario = 'root';
        private $contrasena = '1234';
        private $servidor = "localhost";
        private $basededatos = 'gestor_examenes';
    
        public function insertProfesor($profesor) {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $consulta = (sprintf("INSERT INTO profesores (idUsuario) VALUES('%s');",
            $profesor -> getIdUsuario()));

            mysqli_query($conexion, $consulta);

            $idProfesor = mysqli_insert_id($conexion);
            $profesor -> setIdProfesor($idProfesor);
            
            mysqli_close($conexion);
        }

        public function getProfesores(): array {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $consulta = (sprintf("SELECT * FROM profesores"));
            $resultado = mysqli_query($conexion, $consulta);
            $registros = array();

            while($registro = mysqli_fetch_array($resultado)) {
                $profesor = new Profesor ($registro["IdProfesor"], $registro["idUsuario"]);

                $registros[] = $profesor;
            } 
            
            mysqli_close($conexion);

            return $registros;
        }
    }
?>