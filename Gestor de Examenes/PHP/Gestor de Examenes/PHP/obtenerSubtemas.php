<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');


$tema = trim((string) ($_POST['tema'] ?? ''));
if ($tema === '') {
    echo json_encode([]);
    exit;
}

require_once __DIR__ . '/../Clases/DAL/PreguntaDAL.php';

try {
    $preguntaDAL = new PreguntaDAL();
    echo json_encode($preguntaDAL->obtenerSubtemasPorTema($tema), JSON_UNESCAPED_UNICODE);
} catch (Throwable $error) {
    http_response_code(500);
    echo json_encode(['error' => 'No se pudieron cargar los subtemas']);
}