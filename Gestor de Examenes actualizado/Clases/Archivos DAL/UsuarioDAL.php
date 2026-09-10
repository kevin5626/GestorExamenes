<?php
    require_once("usuario.php");

    class TutorDAL {
        private $usuario = 'root';
        private $contrasena = '1234';
        private $servidor = "localhost";
        private $basededatos = 'gestor_examenes';
    
        public function insertUsuario($usuario) {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $consulta = (sprintf("INSERT INTO usuarios (nombre, apellido, email, contrasena) VALUES('%s', '%s', '%s', '%s');",
            $usuario -> getNombre(), $usuario -> getApellido(), $usuario -> getEmail()));

            mysqli_query($conexion, $consulta);

            $idTutor = mysqli_insert_id($conexion);
            $usuario -> setIdTutor($idTutor);
            
            mysqli_close($conexion);
        }

        public function getUsuarios(): array {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $consulta = (sprintf("SELECT * FROM usuarios"));
            $resultado = mysqli_query($conexion, $consulta);
            $registros = array();

            while($registro = mysqli_fetch_array($resultado)) {
                $usuario = new Tutor ($registro["idUsuario"], $registro["nombre"], $registro["apellido"], $registro["email"], $registro["contrasena"]);

                $registros[] = $usuario;
            } 
            
            mysqli_close($conexion);

            return $registros;
        }
    }
?>