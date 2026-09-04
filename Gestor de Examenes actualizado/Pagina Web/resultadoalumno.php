<?php

session_start();
if (!isset($_SESSION["idUsuario"])) {
    header("Location: principal.html");
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
    <title>Resultado del examen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="text-center mb-4">
            <h1>Resultado del examen</h1>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">Datos del alumno</h2>
                <hr>
                <p><strong>Nombre:</strong> Juan</p>
                <p><strong>Apellido:</strong> Pérez</p>
            </div>
        </div>

        <div class="card text-center mb-4">
            <div class="card-body">
                <h2>Nota</h2>
                <hr>
                <h1>8/10</h1>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="card-title">Preguntas correctas</h2>
                        <hr>
                        <p>Pregunta 1: Correcta</p>
                        <p>Pregunta 3: Correcta</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="card-title">Preguntas incorrectas</h2>
                        <hr>
                        <p>Pregunta 2: Incorrecta</p>
                        <p><strong>Respuesta correcta:</strong> x = 3</p>
                    </div>
                </div>
            </div>
        </div>  

        <div class="text-center mt-4">
            <a href="profesor.php">
                <button type="button" class="btn btn-secondary">Volver al inicio</button>
            </a>
        </div>
    </div>
</body>
</html>