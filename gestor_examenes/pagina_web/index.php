<?php
session_start();
require_once(__DIR__ . "/../clases/abstract_mapper.php");
require_once(__DIR__ . "/../clases/dal/usuario_dal.php");
$error = "";
if (isset($_POST["Comparar"])) {
    $email = $_POST["Email"];
    $contrasena = $_POST["contrasena"];
    $consulta = new UsuarioDAL();
    $error = $consulta->login($email, $contrasena);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../imagenes/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/style.css">
    <title>Inicio de sesión</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card py-4 px-5">
                    <h1 class="text-center mb-3" style="font-family: 'Dm Sans', sans-serif">Inicio de sesión</h1>
                    <?php if (isset($_GET["registro"]) && $_GET["registro"] === "exito") { ?>
                        <div class="alert alert-success ocultar-3s text-center mb-4" role="alert">
                            ¡Usuario registrado con éxito!
                        </div>
             <style>
                   .ocultar-3s {
                   animation: ocultarDiv 0.5s ease 3s forwards;
                     }

                       @keyframes ocultarDiv {
                         to {
                             opacity: 0;
                           visibility: hidden;
                           display: none;
                            }
                     }
            </style>
                    <?php } ?>
                    <form method="post">
                        <div class="mb-3">
                            <label for="Email" class="form-label">Email</label>
                            <input type="email" class="form-control" style="border-radius: 25px" id="Email" name="Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" style="border-radius: 25px" id="contrasena" name="contrasena" required>
                        </div>
                        <div class="d-grid">
                            <input type="submit" class="btn btn-primary boton mt-2" name="Comparar" value="Iniciar sesión">
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