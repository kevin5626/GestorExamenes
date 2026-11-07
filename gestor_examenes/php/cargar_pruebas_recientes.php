<?php
session_start();
if (!isset($_SESSION["idUsuario"])) {
    header("Location: index.php");
    exit;
}
if (!in_array($_SESSION["rol"] ?? "", ["profesor", "alumno"], true)) {
    header("Location: inicio_alumno.php");
    exit;
}

require_once __DIR__ . "/../clases/dal/examen_dal.php";

$idProfesor = (int) ($_SESSION["idProfesor"] ?? 0);
$idAlumno = (int) ($_SESSION["idAlumno"] ?? 0);
$esAlumno = $_SESSION["rol"] === "alumno";
$examenes = [];
$resultadosAlumno = [];
$errorCarga = false;

try {
    $examenDAL = new ExamenDAL();
    if ($esAlumno) {
        if ($idAlumno <= 0) {
            throw new RuntimeException("No se encontró el alumno de la sesión.");
        }

        $resultadosAlumno = $examenDAL->obtenerResultadosPorAlumno($idAlumno);
    } else {
        if ($idProfesor <= 0) {
            throw new RuntimeException("No se encontró el profesor de la sesión.");
        }

        $filas = $examenDAL->obtenerConResultadosPorProfesor($idProfesor);
        foreach ($filas as $fila) {
            $idExamen = (int) $fila["idExamen"];
            if (!isset($examenes[$idExamen])) {
                $examenes[$idExamen] = [
                    "tema" => $fila["tema"],
                    "fechaExamen" => $fila["fechaExamen"],
                    "enlaceAcceso" => $fila["enlaceAcceso"],
                    "resultados" => [],
                ];
            }

            if ($fila["idResultado"] !== null) {
                $examenes[$idExamen]["resultados"][] = $fila;
            }
        }
    }
} catch (Throwable $error) {
    error_log("Error al cargar las pruebas recientes: " . $error->getMessage());
    $errorCarga = true;
}

$totalResultados = 0;
$sumaCalificaciones = 0;
if ($esAlumno) {
    foreach ($resultadosAlumno as $resultado) {
        $totalResultados++;
        $sumaCalificaciones += (float) $resultado["calificacion"];
    }
} else {
    foreach ($examenes as $examen) {
        foreach ($examen["resultados"] as $resultado) {
            $totalResultados++;
            $sumaCalificaciones += (float) $resultado["calificacion"];
        }
    }
}
$promedio = $totalResultados > 0 ? $sumaCalificaciones / $totalResultados : null;
$escapar = static fn($valor): string => htmlspecialchars((string) $valor, ENT_QUOTES, "UTF-8");