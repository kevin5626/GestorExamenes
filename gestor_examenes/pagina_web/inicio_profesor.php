<?php
session_start();
if (!isset($_SESSION["idUsuario"])) {
    header("Location: index.php");
    exit;
}
if ($_SESSION["rol"] !== "profesor") {
    header("Location: inicio_alumno.php");
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
            <h1>Materia</h1>
        </div>
        <!-- Temas -->
        <div class="row g-3">
            <div class="col-md-4">
                <form action="crear_examen.php" method="get">
                    <button type="submit" name="materia" value="Programación" class="btn btn-outline-dark w-100">Programación</button>
                </form>
            </div>
            <div class="col-md-4">
                <form action="crear_examen.php" method="get">
                    <button type="submit" name="materia" value="Lenguaje" class="btn btn-outline-dark w-100">Lenguaje</button>
                </form>
            </div>
            <div class="col-md-4">
                <form action="crear_examen.php" method="get">
                    <button type="submit" name="materia" value="Historia" class="btn btn-outline-dark w-100">Historia</button>
                </form>
            </div>
            <div class="col-md-4">
                <form action="crear_examen.php" method="get">
                    <button type="submit" name="materia" value="Geografia" class="btn btn-outline-dark w-100">Geografia</button>
                </form>
            </div>
            <div class="col-md-4">
                <form action="crear_examen.php" method="get">
                    <button type="submit" name="materia" value="Ingles" class="btn btn-outline-dark w-100">Ingles</button>
                </form>
            </div>
            <div class="col-md-4">
                <form action="crear_examen.php" method="get">
                    <button type="submit" name="materia" value="Biologia" class="btn btn-outline-dark w-100">Biologia</button>
                </form>
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
                <a href="pruebas_recientes.php" class="text-decoration-none text-dark">
                    <div class="card text-center p-4">
                        <div class="fs-1">📁</div>
                        <h5 class="mt-3">Mis examenes</h5>
                    </div>
                </a>
            </div>
            <!-- Carpeta 2 -->
            <div class="col-md-4">
                <a href="pruebas_recientes.php" class="text-decoration-none text-dark">
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