<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');

if (!isset($_SESSION['idUsuario']) || ($_SESSION['rol'] ?? '') !== 'profesor') {
    http_response_code(403);
    echo json_encode(['error' => 'Acceso no autorizado']);
    exit;
}

require_once __DIR__ . '/../clases/dal/pregunta_dal.php';

try {
    $preguntaDAL = new PreguntaDAL();
    $materia = trim((string) ($_SESSION['materia'] ?? ''));
    echo json_encode($preguntaDAL->obtenerTemasPorMateria($materia), JSON_UNESCAPED_UNICODE);
} catch (Throwable $error) {
    http_response_code(500);
    echo json_encode(['error' => 'No se pudieron cargar los temas']);
}