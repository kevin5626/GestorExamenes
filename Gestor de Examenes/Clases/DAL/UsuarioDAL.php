<?php
    require_once(__DIR__ . "/../Usuario.php");

    class UsuarioDAL extends AbstractMapper {
        public function insert($usuario) {
            $consulta = (sprintf("INSERT INTO usuarios (nombre, apellido, email, contrasena) VALUES('%s', '%s', '%s', '%s');",
            $usuario -> getNombre(), $usuario -> getApellido(), $usuario -> getEmail(), $usuario -> getContrasena()));

            $idUsuario = mysqli_insert_id($conexion);
            $usuario -> setIdUsuario($idUsuario);
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