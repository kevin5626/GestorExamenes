<?php

require_once __DIR__ . "/../clases/usuario.php";
require_once __DIR__ . "/../clases/dal/usuario_dal.php";
require_once __DIR__ . "/../clases/alumno.php";
require_once __DIR__ . "/../clases/dal/alumno_dal.php";
require_once __DIR__ . "/../clases/profesor.php";
require_once __DIR__ . "/../clases/dal/profesor_dal.php";
require_once __DIR__ . "/../clases/pregunta.php";
require_once __DIR__ . "/../clases/dal/pregunta_dal.php";
require_once __DIR__ . "/../clases/examen.php";
require_once __DIR__ . "/../clases/dal/examen_dal.php";
require_once __DIR__ . "/../clases/examen_y_preguntas.php";
require_once __DIR__ . "/../clases/dal/examen_preguntas_dal.php";



function iniciarSesion(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}


function responderJson($datos, int $codigoHttp = 200, int $flags = 0): void
{
    header("Content-Type: application/json; charset=UTF-8");
    http_response_code($codigoHttp);
    echo json_encode($datos, $flags);
    exit;
}




function registrarUsuario(array $datos): bool
{
    $nombre = $datos["nombre"];
    $apellido = $datos["apellido"];
    $email = $datos["email"];
    $contrasena = $datos["contrasena"];
    $tipoUsuario = $datos["tipoUsuario"];

    if ($tipoUsuario !== "profesor" && $tipoUsuario !== "alumno") {
        die("Debe seleccionar si es profesor o alumno.");
    }

    $dalUsuario = new UsuarioDAL();
    $dalAlumno = new AlumnoDAL();
    $dalProfesor = new ProfesorDAL();

    $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

    $usuario = new Usuario(null, $nombre, $apellido, $email, $contrasenaHash);
    $dalUsuario->insert($usuario);

    // Asignamos el usuario a su tipo
    if ($tipoUsuario === "profesor") {
        $profesor = new Profesor(null, $usuario->getIdUsuario());
        $dalProfesor->insert($profesor);
    } else {
        $alumno = new Alumno(null, $usuario->getIdUsuario());
        $dalAlumno->insert($alumno);
    }

    return true;
}


function mostrarMensajeRegistroExitoso(): void
{
    echo "<div id='mensaje' class='row justify-content-center w-100'>";
    echo "<div class='col-7 col-sm-6 col-lg-3 alert alert-success mx-5 text-center mt-3' role='alert'>";
    echo "¡Usuario registrado!";
    echo "<br>";
    echo "<a href='../pagina_web/index.php' class='btn btn-outline-dark mt-2'>Iniciar Sesion</a>";
    echo "</div>";
    echo "</div>";
    echo "<script>
        setTimeout(function() {
        const mensaje = document.getElementById('mensaje');
        if(mensaje) {
            mensaje.style.transition = 'opacity 1s';
            mensaje.style.opacity = '0';
            setTimeout(function() { mensaje.style.display = 'none'; }, 1000);
        }
        }, 3000);
        </script>";
}

function procesarCrearCuenta(): void
{
    iniciarSesion();

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        return;
    }

    $registrado = registrarUsuario([
        "nombre"      => $_POST["nombre"],
        "apellido"    => $_POST["apellido"],
        "email"       => $_POST["email"],
        "contrasena"  => $_POST["contrasena"],
        "tipoUsuario" => $_POST["tipoUsuario"],
    ]);

    if ($registrado) {
        mostrarMensajeRegistroExitoso();
    } else {
        echo "Error al asignar el tipo de usuario";
    }
}


function apiObtenerTemas(): void
{
    iniciarSesion();
    header("Content-Type: application/json; charset=UTF-8");

    if (!isset($_SESSION["idUsuario"]) || ($_SESSION["rol"] ?? "") !== "profesor") {
        responderJson(["error" => "Acceso no autorizado"], 403);
    }

    try {
        $preguntaDAL = new PreguntaDAL();
        responderJson($preguntaDAL->obtenerTemas(), 200, JSON_UNESCAPED_UNICODE);
    } catch (Throwable $error) {
        responderJson(["error" => "No se pudieron cargar los temas"], 500);
    }
}

    /** Devuelve en JSON los subtemas del tema recibido por POST ("tema"). */
function apiObtenerSubtemas(): void
{
    iniciarSesion();
    header("Content-Type: application/json; charset=UTF-8");

    $tema = trim((string) ($_POST["tema"] ?? ""));
    if ($tema === "") {
        responderJson([]);
    }

    try {
        $preguntaDAL = new PreguntaDAL();
        responderJson($preguntaDAL->obtenerSubtemasPorTema($tema), 200, JSON_UNESCAPED_UNICODE);
    } catch (Throwable $error) {
        responderJson(["error" => "No se pudieron cargar los subtemas"], 500);
    }
}

// ===========================================================================
// CREAR EXAMEN  (antes: crear_examen.php)
// ===========================================================================

/**
 * Obtiene el nombre del tema del examen: primero el campo "temaExamen";
 * si viene vacío, concatena los nombres de los temas seleccionados.
 */
function obtenerTemaExamen($temasSeleccionados): string
{
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

    return $tema;
}

/** Limpia los ids enviados: enteros, > 0 y sin repetir. */
function normalizarIdsPreguntas($idsEnviados): array
{
    if (!is_array($idsEnviados)) {
        return [];
    }

    return array_values(array_unique(array_filter(array_map("intval", $idsEnviados), function ($id) {
        return $id > 0;
    })));
}

/** Guarda el examen y sus preguntas. Responde JSON y termina. */
function guardarExamen(string $tema): void
{
    $idsPreguntas = normalizarIdsPreguntas($_POST["idsPreguntas"] ?? []);

    if (empty($idsPreguntas)) {
        responderJson(["ok" => false, "error" => "No hay preguntas para guardar en el examen."], 422);
    }

    try {
        $idUsuario = (int) ($_SESSION["idUsuario"] ?? 0);
        $profesorDAL = new ProfesorDAL();
        $profesor = $idUsuario > 0 ? $profesorDAL->obtenerPorIdUsuario($idUsuario) : null;
        $idProfesor = $profesor !== null ? (int) $profesor->getIdProfesor() : 0;

        if ($idProfesor <= 0) {
            responderJson(["ok" => false, "error" => "El usuario actual no tiene un registro de profesor válido."], 422);
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

        responderJson([
            "ok"       => true,
            "idExamen" => $idExamen,
            "url"      => $enlaceAcceso,
        ]);
    } catch (Throwable $error) {
        error_log("Error al guardar el examen: " . $error->getMessage());
        $mensajeError = "No se pudo guardar el examen en la base de datos.";
        $servidor = strtolower((string) ($_SERVER["SERVER_NAME"] ?? ""));
        if (in_array($servidor, ["localhost", "127.0.0.1", "::1"], true)) {
            $mensajeError .= " " . $error->getMessage();
        }
        responderJson(["ok" => false, "error" => $mensajeError], 500);
    }
}

/** Busca las preguntas según los bloques tema/subtema/dificultad/cantidad. */
function buscarPreguntasSeleccionadas($temasSeleccionados, string $tema): array
{
    $preguntas = [];
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

    return $preguntas;
}

/** Convierte las respuestas de una pregunta (JSON o array) en una lista simple. */
function obtenerListaRespuestas($respuestasRaw): array
{
    if (is_string($respuestasRaw)) {
        $datos = json_decode($respuestasRaw, true);
        if (isset($datos["respuesta"])) {
            return $datos["respuesta"];
        } elseif (is_array($datos)) {
            return $datos;
        }
        return [];
    } elseif (is_array($respuestasRaw)) {
        return $respuestasRaw["respuesta"] ?? $respuestasRaw;
    }

    return [];
}

/** Dibuja el "Modelo de examen" (HTML). */
function renderModeloExamen(array $preguntas, string $tema, string $errorGuardar = ""): void
{
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
                    $listaRespuestas = obtenerListaRespuestas($pregunta->getRespuestas());
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
    <?php
}

/** Punto de entrada de crear_examen.php */
function procesarCrearExamen(): void
{
    iniciarSesion();

    $temasSeleccionados = $_POST["temas"] ?? $_POST["subtemas"] ?? [];
    $tema = obtenerTemaExamen($temasSeleccionados);
    $preguntas = [];
    $errorGuardar = "";

    // 1) Guardado del examen (petición AJAX -> responde JSON)
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["guardarExamen"])) {
        guardarExamen($tema);
    }

    // 2) Armado del modelo de examen con las preguntas elegidas
    if (!empty($temasSeleccionados) && !isset($_POST["guardarExamen"])) {
        $preguntas = buscarPreguntasSeleccionadas($temasSeleccionados, $tema);
    }

    renderModeloExamen($preguntas, $tema, $errorGuardar);
}
