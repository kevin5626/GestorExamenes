<?php

session_start();
if (!isset($_SESSION["idUsuario"])) {
    header("Location: principal.php");
    exit;
}
if ($_SESSION["rol"] !== "profesor") {
    header("Location: alumno.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Profesor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <!-- Título -->
        <div class="mb-4">
            <h1>Temas</h1>
        </div>
        <!-- Temas -->
        <div class="row g-3">
            <div class="col-md-4">
                <a href="crearExamen.php" class="text-decoration-none">
                    <button type="button" class="btn btn-outline-dark w-100">Matemática</button>
                </a>
            </div>
            <div class="col-md-4">
                <a href="profesor1.html" class="text-decoration-none">
                    <button type="button" class="btn btn-outline-dark w-100">Lengua</button>
                </a>
            </div>
            <div class="col-md-4">
                <a href="profesor1.html" class="text-decoration-none">
                    <button type="button" class="btn btn-outline-dark w-100">Historia</button>
                </a>
            </div>
            <div class="col-md-4">
                <a href="profesor1.html" class="text-decoration-none">
                    <button type="button" class="btn btn-outline-dark w-100">Geografía</button>
                </a>
            </div>
            <div class="col-md-4">
                <a href="profesor1.html" class="text-decoration-none">
                    <button type="button" class="btn btn-outline-dark w-100">Inglés</button>
                </a>
            </div>
            <div class="col-md-4">
                <a href="profesor1.html" class="text-decoration-none">
                    <button type="button" class="btn btn-outline-dark w-100">Programación</button>
                </a>
            </div>
        </div>
        <hr class="my-5">
        <!-- Mis exámenes -->
        <div class="mb-4">
            <h2>Mis exámenes</h2>
        </div>
        <div class="row g-4">
            <!-- Carpeta 1 -->
            <div class="col-md-4">
                <a href="misExamenes.php" class="text-decoration-none text-dark">
                    <div class="card text-center p-4">
                        <div class="fs-1">📁</div>
                        <h5 class="mt-3">Mis pruebas</h5>
                    </div>
                </a>
            </div>
            <!-- Carpeta 2 -->
            <div class="col-md-4">
                <a href="pruebasrecientes.php" class="text-decoration-none text-dark">
                    <div class="card text-center p-4">
                        <div class="fs-1">📁</div>
                        <h5 class="mt-3">Pruebas recientes</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>