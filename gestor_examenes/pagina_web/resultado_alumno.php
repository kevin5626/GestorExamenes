<?php

session_start();
if (!isset($_SESSION["idUsuario"])) {
    header("Location: index.php");
    exit;
}
if (($_SESSION["rol"] ?? "") !== "alumno" || empty($_SESSION["idAlumno"])) {
    header("Location: inicio_alumno.php");
    exit;
}

require_once __DIR__ . "/../clases/resultado.php";
require_once __DIR__ . "/../clases/dal/resultado_dal.php";
require_once __DIR__ . "/../clases/dal/examen_dal.php";
require_once __DIR__ . "/../clases/dal/pregunta_dal.php";
require_once __DIR__ . "/../clases/usuario.php";

$resultado = null;
$error = "";
$idExamen = (int) ($_POST["id"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] !== "POST" || $idExamen <= 0) {
    $error = "No se recibió un examen válido.";
} else {
    try {
        $examenDAL = new ExamenDAL();
        $preguntaDAL = new PreguntaDAL();
        $examen = $examenDAL->obtenerPorId($idExamen);
        $preguntas = $preguntaDAL->obtenerPorIdExamen($idExamen);
        $respuestas = $_POST["respuestas"] ?? [];

        if ($examen === null || empty($preguntas)) {
            $error = "No se encontró el examen o no contiene preguntas.";
        } elseif (!is_array($respuestas)) {
            $error = "No se recibieron respuestas válidas.";
        } else {
            $cantidadAciertos = 0;
            foreach ($preguntas as $pregunta) {
                $idPregunta = $pregunta->getIdPregunta();
                $respuestaAlumno = trim((string) ($respuestas[$idPregunta] ?? ""));
                if ($respuestaAlumno === "") {
                    $error = "Falta responder una o más preguntas.";
                    break;
                }

                if (strcasecmp($respuestaAlumno, trim($pregunta->getRespuestaCorrecta())) === 0) {
                    $cantidadAciertos++;
                }
            }

            if ($error === "") {
                $cantidadErrores = count($preguntas) - $cantidadAciertos;
                $calificacion = (int) round(($cantidadAciertos / count($preguntas)) * 10);
                $resultado = new Resultado(0, new DateTime(), $calificacion, $cantidadErrores, $cantidadAciertos, $idExamen, (int) $_SESSION["idAlumno"]);

                $resultadoDAL = new ResultadoDAL();
                $resultadoDAL->insert($resultado);
            }
        }
    } catch (Exception $e) {
        $error = "Ocurrió un error al procesar el examen: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    }
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
        <h1 class="mb-4">Resultado del examen</h1>
        <?php if ($error !== ""): ?>
            <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php elseif ($resultado !== null): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <p><strong>ID del resultado:</strong> <?php echo $resultado->getIdResultado(); ?></p>
                    <p><strong>ID del examen:</strong> <?php echo $resultado->getIdExamen(); ?></p>
                    <p><strong>ID del alumno:</strong> <?php echo $resultado->getIdAlumno(); ?></p>
                    <p><strong>Alumno:</strong> <?php echo htmlspecialchars((string) ($_SESSION["nombre"] ?? "" ), ENT_QUOTES, 'UTF-8'). htmlspecialchars((string) ($_SESSION["apellido"] ?? "" ), ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Fecha:</strong> <?php echo htmlspecialchars($resultado->getFechaResultado()->format('Y-m-d H:i:s'), ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Calificación:</strong> <?php echo $resultado->getCalificacion(); ?>/10</p>
                    <p><strong>Aciertos:</strong> <?php echo $resultado->getCantidadAciertos(); ?></p>
                    <p class="mb-0"><strong>Errores:</strong> <?php echo $resultado->getCantidadErrores(); ?></p>
                </div>
            </div>
        <?php endif; ?>
        <a href="inicio_alumno.php" class="btn btn-secondary">Volver al inicio</a>
    </div>
</body>
</html>