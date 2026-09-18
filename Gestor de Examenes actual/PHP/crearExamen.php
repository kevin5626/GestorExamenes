<?php
session_start();

if (!isset($_SESSION["idUsuario"])) {
    header("Location: ../Pagina Web/index.php");
    exit;
}

if (($_SESSION["rol"] ?? "") !== "profesor") {
    header("Location: ../Pagina Web/inicioAlumno.php");
    exit;
}

require_once __DIR__ . "/../Clases/Pregunta.php";
require_once __DIR__ . "/../Clases/DAL/PreguntaDAL.php";

$tema = "Programación";
$subtemasSeleccionados = $_POST["subtemas"] ?? [];
$preguntas = [];

if (!empty($subtemasSeleccionados)) {
    $preguntaDAL = new PreguntaDAL();

    foreach ($subtemasSeleccionados as $bloque) {
        $subtema = trim((string) ($bloque["subtema"] ?? ""));
        $dificultad = trim((string) ($bloque["dificultad"] ?? "Facil"));
        $cantidad = isset($bloque["cantidad"]) ? max(1, (int) $bloque["cantidad"]) : 1;

        if ($subtema === "") {
            continue;
        }

        $preguntasDelSubtema = $preguntaDAL->obtenerPorTemaSubtemaDificultad($tema, $subtema, $dificultad, $cantidad);
        foreach ($preguntasDelSubtema as $pregunta) {
            $preguntas[] = $pregunta;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modelo de examen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0">Modelo de examen</h2>
                <a href="../Pagina Web/crearExamen.php" class="btn btn-outline-secondary">Volver</a>
            </div>

            <?php if (empty($preguntas)): ?>
                <p class="text-muted">No se encontraron preguntas para la selección actual.</p>
            <?php else: ?>
                <?php
                $contador = 0;
                foreach ($preguntas as $pregunta):
                    $contador++;
                    $respuestasRaw = $pregunta->getRespuestas();

                    if (is_string($respuestasRaw)) {
                        $datos = json_decode($respuestasRaw, true);
                        $listaRespuestas = $datos["respuesta"] ?? [];
                    } elseif (is_array($respuestasRaw)) {
                        $listaRespuestas = $respuestasRaw["respuesta"] ?? $respuestasRaw;
                    } else {
                        $listaRespuestas = [];
                    }
                ?>
                    <div class="pregunta border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Pregunta <?php echo $contador; ?></h5>
                        </div>

                        <p class="mt-3 mb-3"><?php echo htmlspecialchars($pregunta->getTextoPregunta(), ENT_QUOTES, 'UTF-8'); ?></p>

                        <?php foreach ($listaRespuestas as $respuesta): ?>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="respuestaPregunta<?php echo $contador; ?>" disabled>
                                <label class="form-check-label"><?php echo htmlspecialchars($respuesta, ENT_QUOTES, 'UTF-8'); ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <p class="mb-0"><strong>Código de acceso:</strong> <?php echo htmlspecialchars($tema, ENT_QUOTES, 'UTF-8'); ?></p>
                    <button type="button" class="btn btn-success">Enviar examen</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
