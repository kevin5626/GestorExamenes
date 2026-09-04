<?php

session_start();
require_once __DIR__ . "/conexion.php";
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
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
    if ($resultado->num_rows === 1) {
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
            } else {
                $error = "El usuario no tiene un rol asignado.";
            }
        } else {
            $error = "Email o contraseña incorrectos.";
        }
    } else {
        $error = "El usuario no existe.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4">
                    <h1 class="text-center mb-4">Inicio de sesión</h1>
                    <form method="post">
                        <div class="mb-3">
                            <label for="Email" class="form-label">Email:</label>
                            <input
                                type="email"
                                class="form-control"
                                id="Email"
                                name="Email"
                                required
                            >
                        </div>
                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contraseña:</label>
                            <input
                                type="password"
                                class="form-control"
                                id="contrasena"
                                name="contrasena"
                                required
                            >
                        </div>
                        <div class="d-grid">
                            <input
                                type="submit"
                                class="btn btn-primary"
                                value="Iniciar sesión"
                            >
                        </div>
                           <?php if ($error !== "") { ?>
                        <div class="alert alert-danger text-center mb-3 mt-4">
                            <?php echo $error; ?>
                        </div>
                    <?php } ?>
                    </form>
                    <div class="text-center my-3">
                        <span>¿No tienes una cuenta?</span>
                    </div>
                    <div class="d-grid">
                        <button type="button" class="btn btn-outline-dark" onclick="window.location.href='CrearCuenta.php'">Crear cuenta</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>