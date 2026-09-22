<?php
    require_once(__DIR__ . "/../Usuario.php");
    require_once(__DIR__ . "/../AbstractMapper.php");

    class UsuarioDAL extends AbstractMapper {
        public function insert($usuario) {
            $consulta = (sprintf("INSERT INTO usuarios (nombre, apellido, email, contrasena) VALUES('%s', '%s', '%s', '%s');",
            $usuario -> getNombre(), $usuario -> getApellido(), $usuario -> getEmail(), $usuario -> getContrasena()));
            mysqli_query($this->conectar(), $consulta);

            $idUsuario = mysqli_insert_id($this->conectar());
            $usuario -> setIdUsuario($idUsuario);
            return "Funciona satisfactoriamente";
        }

        public function get(): array {
            $consulta = (sprintf("SELECT * FROM usuarios"));
            $resultado = mysqli_query($conexion, $consulta);
            $registros = array();

            while($registro = mysqli_fetch_array($resultado)) {
                $usuario = new Usuario ($registro["idUsuario"], $registro["nombre"], $registro["apellido"], $registro["email"], $registro["contrasena"]);

                $registros[] = $usuario;
            }
            return $registros;
        }
    }
?>