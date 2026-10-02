<?php
require_once(__DIR__ . "/../Usuario.php");
require_once(__DIR__ . "/../AbstractMapper.php");

class UsuarioDAL extends AbstractMapper {
    public function insert($usuario) {
        $pdo = $this->conectar();
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, email, contrasena) VALUES(:nombre, :apellido, :email, :contrasena);");
        $stmt->execute([
            ':nombre'     => $usuario->getNombre(),
            ':apellido'   => $usuario->getApellido(),
            ':email'      => $usuario->getEmail(),
            ':contrasena' => $usuario->getContrasena() 
        ]);

        $idUsuario = $pdo->lastInsertId(); 
        $usuario->setIdUsuario($idUsuario);
    }

    public function get(): array {
        $pdo = $this->conectar();
        $stmt = $pdo->query("SELECT * FROM usuarios");
        $registros = array();

        while($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $usuario = new Usuario ($registro["idUsuario"], $registro["nombre"], $registro["apellido"], $registro["email"], $registro["contrasena"]);

            $registros[] = $usuario;
        }
        return $registros;
    }
}
?>