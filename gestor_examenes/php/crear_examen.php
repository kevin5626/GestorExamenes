<?php
require_once __DIR__ . "/../clases/pregunta.php";
require_once __DIR__ . "/../clases/dal/pregunta_dal.php";
require_once __DIR__ . "/../clases/examen.php";
require_once __DIR__ . "/../clases/dal/examen_dal.php";
require_once __DIR__ . "/../clases/examen_y_preguntas.php";
require_once __DIR__ . "/../clases/dal/examen_preguntas_dal.php";
require_once __DIR__ . "/../clases/profesor.php";
require_once __DIR__ . "/../clases/dal/profesor_dal.php";

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
    header("Content-Type: application/json; charset=UTF-8");
    $idsEnviados = $_POST["idsPreguntas"] ?? [];
    $idsPreguntas = is_array($idsEnviados)
        ? array_values(array_unique(array_filter(array_map("intval", $idsEnviados), function ($id) {
            return $id > 0;
        })) )
        : [];

    if (empty($idsPreguntas)) {
        http_response_code(422);
        echo json_encode(["ok" => false, "error" => "No hay preguntas para guardar en el examen."]);
        exit;
    }

    try {
        $idUsuario = (int) ($_SESSION["idUsuario"] ?? 0);
        $profesorDAL = new ProfesorDAL();
        $profesor = $idUsuario > 0 ? $profesorDAL->obtenerPorIdUsuario($idUsuario) : null;
        $idProfesor = $profesor !== null ? (int) $profesor->getIdProfesor() : 0;

        if ($idProfesor <= 0) {
            http_response_code(422);
            echo json_encode(["ok" => false, "error" => "El usuario actual no tiene un registro de profesor válido."]);
            exit;
        }

        $_SESSION["idProfesor"] = $idProfesor;
        $examenDAL = new ExamenDAL();
        $examenYPreguntaDAL = new ExamenYPreguntaDAL();

        $examen = new Examen(0, $tema, new DateTime(), "", $idProfesor);
        $examenDAL->insert($examen);

        $idExamen = $examen->getIdExamen();
        $enlaceAcceso = "examen.php?id=" . $idExamen;
        $examen->setEnlaceAcceso($enlaceAcceso);
        $examenDAL->actualizarEnlaceAcceso($examen);

        foreach ($idsPreguntas as $idPregunta) {
            $examenYPregunta = new ExamenYPregunta($idExamen, $idPregunta);
            $examenYPreguntaDAL->insert($examenYPregunta);
        }

        echo json_encode([
            "ok" => true,
            "idExamen" => $idExamen,
            "url" => $enlaceAcceso,
        ]);
        exit;
    } catch (Throwable $error) {
        error_log("Error al guardar el examen: " . $error->getMessage());
        http_response_code(500);
        $mensajeError = "No se pudo guardar el examen en la base de datos.";
        $servidor = strtolower((string) ($_SERVER["SERVER_NAME"] ?? ""));
        if (in_array($servidor, ["localhost", "127.0.0.1", "::1"], true)) {
            $mensajeError .= " " . $error->getMessage();
        }
        echo json_encode(["ok" => false, "error" => $mensajeError]);
        exit;
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
    <div class="container mt-4">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0">Modelo de examen</h2>
                <a href="../pagina_web/crear_examen.html" class="btn btn-outline-secondary">Volver</a>
            </div>

            <?php if ($errorGuardar !== ""): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorGuardar, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <?php if (empty($preguntas)): ?>
                <p class="text-muted">No se encontraron preguntas para la selección actual.</p>
            <?php else: ?>
                <form id="guardarExamenForm" method="post" action="../php/crear_examen.php">
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
                    <div class="pregunta border rounded p-3 mb-3">
                        <input type="hidden" name="idsPreguntas[]" value="<?php echo (int) $pregunta->getIdPregunta(); ?>">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Pregunta <?php echo $contador; ?></h5>
                            <button type="button" class="btn btn-danger btn-sm eliminarPregunta">X</button>
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
                    <button type="submit" class="btn btn-success">Enviar examen</button>
                
                </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
                            