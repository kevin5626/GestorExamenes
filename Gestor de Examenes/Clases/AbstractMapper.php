<?php
abstract class AbstractMapper {
    protected string $servidor;
    protected string $usuario;
    protected string $contrasenia;
    protected string $basededatos;
    protected string $charset;

    public function __construct() {
        $config = require __DIR__ . '/../PHP/config.php';
        $this->servidor    = $config['servidor'];
        $this->usuario     = $config['usuario'];
        $this->contrasenia = $config['contrasena'];
        $this->basededatos = $config['basededatos'];
        $this->charset     = $config['charset'] ?? 'utf8mb4';
    }

    abstract protected function insert($objeto);
    abstract protected function get(): array;

    public function verificarDatos($email, $contrasena) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $conexion = new mysqli($this->servidor, $this->usuario, $this->contrasenia, $this->basededatos);
        
        $conexion -> set_charset($this->charset);

        $error = "";
        $sql = "SELECT 
                    u.*,
                    p.idProfesor,
                    a.idAlumno
                FROM usuarios u
                LEFT JOIN profesores p 
                    ON u.idUsuario = p.idUsuario
                LEFT JOIN alumnos a 
                    ON u.idUsuario = a.idUsuario
                WHERE u.email = ?";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $datos = $resultado->fetch_assoc();
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

        $stmt -> close();
        $conexion -> close();
    }
}    
?>