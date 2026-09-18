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
    <title>Pruebas recientes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Pruebas recientes</h1>
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">Prueba actualmente en ejecución</h2>
                <hr>
                <p><strong>Tema:</strong> Matemática</p>
                <p><strong>Subtemas:</strong> Álgebra y Geometría</p>
                <p><strong>Código del examen:</strong> MAT123</p>
                <p><strong>Estado:</strong> <span class="badge bg-success">En ejecución</span></p>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title mb-4">Alumnos que terminaron la prueba</h2>
                <h3 class="mb-3">Alumnos aprobados</h3>
                <div class="list-group mb-4">
                    <div class="list-group-item d-flex justify-content-between">
                        <span>Juan Pérez</span>
                        <strong>8/10</strong>
                    </div>
                    <div class="list-group-item d-flex justify-content-between">
                        <span>Martina González</span>
                        <strong>9/10</strong>
                    </div>
                    <div class="list-group-item d-flex justify-content-between">
                        <span>Lucas Fernández</span>
                        <strong>7/10</strong>
                    </div>
                </div>
                <h3 class="mb-3">Alumnos no aprobados</h3>
                <div class="list-group">
                    <div class="list-group-item d-flex justify-content-between">
                        <span>Pedro Rodríguez</span>
                        <strong>4/10</strong>
                    </div>
                    <div class="list-group-item d-flex justify-content-between">
                        <span>Sofía López</span>
                        <strong>5/10</strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">Resumen</h2>
                <hr>
                <p>Alumnos que aprobaron: <strong>3</strong></p>
                <p>Alumnos que no aprobaron: <strong>2</strong></p>
            </div>
        </div>
        <a href="profesor.php"><button type="button" class="btn btn-secondary">Volver al panel del profesor</button></a>
    </div>
</body>
</html>
