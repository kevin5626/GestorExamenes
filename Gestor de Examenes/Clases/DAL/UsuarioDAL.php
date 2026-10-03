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
            $usuario = new Usuario($registro["idUsuario"], $registro["nombre"], $registro["apellido"], $registro["email"], $registro["contrasena"]);

            $registros[] = $usuario;
        }
        return $registros;
    }

    public function login($email, $contrasena) {
        $pdo = $this->conectar();
        $stmt = $pdo->prepare("
            SELECT *
            FROM usuarios
            WHERE email = :email
        ");
        $stmt->execute([
            ':email' => $email
        ]);
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($datos) {
            if (password_verify($contrasena, $datos["contrasena"])) {
                $_SESSION["idUsuario"] = $datos["idUsuario"];
                $_SESSION["nombre"] = $datos["nombre"];
                $_SESSION["email"] = $datos["email"];
                if ($datos["idProfesor"] !== null) {
                    $_SESSION["rol"] = "profesor";
                    $_SESSION["idProfesor"] = $datos["idProfesor"];
                    header("Location: inicioProfesor.php");
                    exit;
                } elseif ($datos["idAlumno"] !== null) {
                    $_SESSION["rol"] = "alumno";
                    $_SESSION["idAlumno"] = $datos["idAlumno"];
                    header("Location: inicioAlumno.php");
                    exit;
                } else {
                    $error = "El usuario no tiene un rol asignado.";
                }
            } else {
                $error = "Email o contraseña incorrectos.";
            }
        } else {
            $error = "El usuario no existe.";
        }
        return $error;
    }
}
?>