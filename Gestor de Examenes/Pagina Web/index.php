<?php
session_start();
require_once(__DIR__ . "/../Clases/AbstractMapper.php");
$error = "";
if(isset($_POST["Comparar"])) {
    $email = $_POST["Email"];
    $contrasena = $_POST["contrasena"];

    $consulta = new Manager();
    $consulta -> verificarDatos($email, $contrasena);
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
                            <input type="email" class="form-control" id="Email" name="Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contraseña:</label>
                            <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                        </div>
                        <div class="d-grid">
                            <input type="submit" class="btn btn-primary boton" name="Comparar" value="Iniciar sesión">
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
                        <button type="button" class="btn btn-outline-dark" onclick="window.location.href='login.html'">Crear cuenta</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>