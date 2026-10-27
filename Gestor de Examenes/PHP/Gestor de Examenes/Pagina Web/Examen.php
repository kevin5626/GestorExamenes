<?php

session_start();

if (!isset($_SESSION["idUsuario"])) {
    header("Location: index.php");
    exit;
}

require_once __DIR__ . "/../Clases/Examen.php";
require_once __DIR__ . "/../Clases/DAL/ExamenDAL.php";
require_once __DIR__ . "/../Clases/Pregunta.php";
require_once __DIR__ . "/../Clases/DAL/PreguntaDAL.php";

$idExamen = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
$examen = null;
$preguntas = [];

if ($idExamen > 0) {
    $examenDAL = new ExamenDAL();
    $preguntaDAL = new PreguntaDAL();
    $examen = $examenDAL->obtenerPorId($idExamen);

    if ($examen !== null) {
        $preguntas = $preguntaDAL->obtenerPorIdExamen($idExamen);
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Examen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <?php if ($examen === null): ?>
            <div class="alert alert-warning">No se encontró el examen solicitado.</div>
            <a href="inicioProfesor.php" class="btn btn-secondary">Volver</a>
        <?php else: ?>
        <div class="text-center mb-4">
            <h1>Examen de <?php echo htmlspecialchars($examen->getTema(), ENT_QUOTES, 'UTF-8'); ?></h1>
            <p>Responda las siguientes preguntas.</p>
            <p><strong>ID:</strong> <?php echo (int) $examen->getIdExamen(); ?>
                <?php if ($examen->getEnlaceAcceso() !== ""): ?>
                    | <strong>Código de acceso:</strong> <?php echo htmlspecialchars($examen->getEnlaceAcceso(), ENT_QUOTES, 'UTF-8'); ?>
                <?php endif; ?>
            </p>
        </div>

        <?php if (empty($preguntas)): ?>
            <div class="alert alert-info">El examen no tiene preguntas asociadas.</div>
        <?php else: ?>
        <form action="resultadoalumno.php" method="get">
            <input type="hidden" name="id" value="<?php echo (int) $examen->getIdExamen(); ?>">
            <?php
            $contador = 0;
            foreach ($preguntas as $pregunta):
                $contador++;
                $respuestasRaw = $pregunta->getRespuestas();

                if (is_string($respuestasRaw)) {
                    $datos = json_decode($respuestasRaw, true);
                    if (isset($datos["respuesta"])) {
                        $listaRespuestas = $datos["respuesta"];
                    } elseif (is_array($datos)) {
                        $listaRespuestas = $datos;
                    } else {
                        $listaRespuestas = [];
                    }
                } elseif (is_array($respuestasRaw)) {
                    $listaRespuestas = $respuestasRaw["respuesta"] ?? $respuestasRaw;
                } else {
                    $listaRespuestas = [];
                }
            ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title">Pregunta <?php echo $contador; ?></h2>
                    <hr>
                    <p><?php echo htmlspecialchars($pregunta->getTextoPregunta(), ENT_QUOTES, 'UTF-8'); ?></p>
                    <?php
                    $opcion = 0;
                    foreach ($listaRespuestas as $respuesta):
                        $opcion++;
                        $inputId = "p" . $contador . "o" . $opcion;
                    ?>
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="radio"
                            id="<?php echo $inputId; ?>"
                            name="pregunta<?php echo $contador; ?>"
                            value="<?php echo htmlspecialchars((string) $respuesta, ENT_QUOTES, 'UTF-8'); ?>"
                            <?php echo $opcion === 1 ? "required" : ""; ?>
                        >
                        <label class="form-check-label" for="<?php echo $inputId; ?>"><?php echo htmlspecialchars((string) $respuesta, ENT_QUOTES, 'UTF-8'); ?></label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
            <div class="text-center mb-5">
                <button type="submit" class="btn btn-success btn-lg">
                    Entregar examen
                </button>
            </div>
        </form>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
