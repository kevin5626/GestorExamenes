<?php
session_start();
if (!isset($_SESSION["idUsuario"])) {
    header("Location: index.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../imagenes/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/style.css">
    <title>Panel Alumno</title>

</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid px-4">
        <div class="d-flex">
            <img src="../imagenes/favicon.png" width="30" height="30">
            <h4 style="font-family: 'Cal Sans', sans-serif;">estor de Examenes</h4>
        </div>
        </ul>
            <div class="d-flex">
                <div class="align-items-center justify-content-center text-center me-4 p-0">
                    <img src="../imagenes/icono_persona_alumno.png" alt="Usuario" width="30" height="30">
                    <h6><?php echo $_SESSION["nombre"]. " ". $_SESSION["apellido"]; ?></h6>
                </div>
                <div class="mt-2">
                    <a href="../php/cerrar_sesion.php" class="btn btn-danger">
                        <img src="../imagenes/icono_puerta.png" alt="Cerrar sesión" width="20" height="20">
                    </a>
                </div>
            </div>
        </div>
    </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4">
                    <h1 class="text-center mb-4">Ingresar a examen</h1>

                    <p class="text-center mb-4">Ingrese el código del examen proporcionado por el profesor.</p>
                    <form action="examen.php" method="get">
                        <div class="mb-4">
                            <label for="id" class="form-label">ID del examen</label>
                            <input type="number" class="form-control" id="id" name="id" placeholder="Ingrese el ID" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="index.php">
                                <button type="button" class="btn btn-secondary">Cancelar</button>
                            </a>

                            <button type="submit" class="btn btn-primary">Aceptar</button>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="mt-4">
        <!-- Mis exámenes -->
        <div>
            <h2>Exámenes realizados</h2>
        </div>
        <div class="row justify-content-center g-2">
            <!-- Carpeta 1 -->
            <div class="col-md-4 zoom">
                <a href="pruebas_recientes.php" class="text-decoration-none text-dark">
                    <div class="card text-center p-4">
                        <div class="fs-1">
                            <img src="../imagenes/icono_carpeta1.png" width="50" height="50">
                        </div>
                        <h5 class="mt-3">Exámenes</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>