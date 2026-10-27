<?php
require_once __DIR__ . "/../Clases/Pregunta.php";
require_once __DIR__ . "/../Clases/DAL/PreguntaDAL.php";
require_once __DIR__ . "/../Clases/Examen.php";
require_once __DIR__ . "/../Clases/DAL/ExamenDAL.php";
require_once __DIR__ . "/../Clases/ExamenYPreguntas.php";
require_once __DIR__ . "/../Clases/DAL/ExamenYPreguntasDAL.php";
require_once __DIR__ . "/../Clases/Profesor.php";
require_once __DIR__ . "/../Clases/DAL/ProfesorDAL.php";

session_start();

$temasSeleccionados = $_POST["temas"] ?? $_POST["subtemas"] ?? [];
$tema = trim((string) ($_POST["temaExamen"] ?? ""));
if ($tema === "" && is_array($temasSeleccionados)) {
    $nombresTemas = [];
    foreach ($temasSeleccionados as $seleccion) {
        if (is_array($seleccion)) {
            $nombreTema = trim((string) ($seleccion["tema"] ?? ""));
            if ($nombreTema !== "") {
                $nombresTemas[] = $nombreTema;
            }
        }
    }
    $tema = implode(", ", array_unique($nombresTemas));
}
$preguntas = [];
$errorGuardar = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["guardarExamen"])) {
    $idsPreguntas = $_POST["idsPreguntas"] ?? [];
    $idsPreguntas = array_values(array_unique(array_filter(array_map("intval", $idsPreguntas))));

    $idProfesor = (int) ($_SESSION["idProfesor"] ?? 0);
    if ($idProfesor <= 0) {
        $profesorDAL = new ProfesorDAL();
        $profesor = $profesorDAL->obtenerPorIdUsuario((int) $_SESSION["idUsuario"]);
        if ($profesor !== null) {
            $idProfesor = (int) $profesor->getIdProfesor();
            $_SESSION["idProfesor"] = $idProfesor;
        }
    }

    if ($idProfesor <= 0) {
        $errorGuardar = "No se pudo identificar al profesor para guardar el examen.";
    } elseif (empty($idsPreguntas)) {
        $errorGuardar = "No hay preguntas para guardar en el examen.";
    } else {
        $examenDAL = new ExamenDAL();
        $examenYPreguntaDAL = new ExamenYPreguntaDAL();

        $examen = new Examen(0, $tema, new DateTime(), "", $idProfesor);
        $examenDAL->insert($examen);

        return $enlaceAcceso = "../Pagina Web/Examen.php?id=" . $examen->getIdExamen();
        $examen->setEnlaceAcceso($enlaceAcceso);
        $examenDAL->actualizarEnlaceAcceso($examen);

        foreach ($idsPreguntas as $idPregunta) {
            $examenYPregunta = new ExamenYPregunta($examen->getIdExamen(), $idPregunta);
            $examenYPreguntaDAL->insert($examenYPregunta);
        }

        header("Location: ../Pagina Web/Examen.php?id=" . $examen->getIdExamen());
        exit;
    }

    $preguntaDAL = new PreguntaDAL();
    foreach ($idsPreguntas as $idPregunta) {
        $pregunta = $preguntaDAL->obtenerPorId($idPregunta);
        if ($pregunta !== null) {
            $preguntas[] = $pregunta;
        }
    }
}

if (!empty($temasSeleccionados) && empty($preguntas) && !isset($_POST["guardarExamen"])) {
    $preguntaDAL = new PreguntaDAL();

    foreach ($temasSeleccionados as $bloque) {
        if (!is_array($bloque)) {
            continue;
        }

        $temaBloque = trim((string) ($bloque["tema"] ?? $tema));
        $subtema = trim((string) ($bloque["subtema"] ?? ""));
        $dificultad = trim((string) ($bloque["dificultad"] ?? "Facil"));
        $cantidad = isset($bloque["cantidad"]) ? max(1, (int) $bloque["cantidad"]) : 1;

        if ($subtema === "") {
            continue;
        }

        $temaConsulta = $temaBloque !== "" ? $temaBloque : $tema;
        $preguntasDelSubtema = $preguntaDAL->obtenerPorTemaSubtemaDificultad($temaConsulta, $subtema, $dificultad, $cantidad);
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
                <a href="../Pagina Web/crearExamen.html" class="btn btn-outline-secondary">Volver</a>
            </div>

            <?php if ($errorGuardar !== ""): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorGuardar, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <?php if (empty($preguntas)): ?>
                <p class="text-muted">No se encontraron preguntas para la selección actual.</p>
            <?php else: ?>
                <form method="post">
                    <input type="hidden" name="guardarExamen" value="1">
                    <input type="hidden" name="temaExamen" value="<?php echo htmlspecialchars($tema, ENT_QUOTES, 'UTF-8'); ?>">
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
                    <input type="hidden" name="idsPreguntas[]" value="<?php echo (int) $pregunta->getIdPregunta(); ?>">
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
                    <p class="mb-0"><strong>Código de acceso:</strong> <?php echo htmlspecialchars($examen->getIdExamen(), ENT_QUOTES, 'UTF-8'); ?></p>
                    <button type="submit" class="btn btn-success">Enviar examen</button>
                
                </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
