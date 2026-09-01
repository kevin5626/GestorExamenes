<?php

session_start();

require_once __DIR__ . "/Usuario.php";
require_once __DIR__ . "/conexion.php";

$email = $_POST["Email"] ?? "";
$contrasena = $_POST["contrasena"] ?? "";

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

if ($resultado->num_rows == 1) {

    $datos = $resultado->fetch_assoc();

    if (password_verify($contrasena, $datos["contrasena"])) {

        $_SESSION["idUsuario"] = $datos["idUsuario"];
        $_SESSION["nombre"] = $datos["nombre"];
        $_SESSION["email"] = $datos["email"];

        if ($datos["idProfesor"] !== null) {

            $_SESSION["rol"] = "profesor";
            $_SESSION["idProfesor"] = $datos["idProfesor"];

            header("Location: profesor.php");
            exit;

        } elseif ($datos["idAlumno"] !== null) {

            $_SESSION["rol"] = "alumno";
            $_SESSION["idAlumno"] = $datos["idAlumno"];

            header("Location: alumno.php");
            exit;
        }
    }
}

echo "Email o contraseña incorrectos.";
echo "<br><a href='principal.html'>Volver</a>";

?>