<?php
// 1. Configuración de la conexión a la base de datos
$usuario = 'root';
$contrasena = '1234';
$servidor = "localhost";
$basededatos = 'gestor_examenes';
$charset = 'utf8mb4';

$conexion = "mysql:host=$servidor;dbname=$basededatos;charset=$charset";

try {
    $pdo = new PDO($conexion, $usuario, $contrasena);
} catch (\PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// 2. Capturar y validar los datos enviados por el usuario
$tema_elegido    = "Programación";
$subtema_elegido = "Logica";
$cantidad = 2;

if ($tema_elegido && $subtema_elegido) {
    
    // 3. Tu consulta SQL con marcadores de posición seguros (:tema y :subtema)
    $sql = "SELECT idPregunta, tema, subtema, textoPregunta, respuestas, apariciones
            FROM preguntas
            WHERE tema = :tema AND subtema = :subtema
            ORDER BY apariciones ASC, RAND()
            LIMIT $cantidad";
    
    // 4. Preparar y ejecutar la consulta de forma segura
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'tema'    => $tema_elegido,
        'subtema' => $subtema_elegido
    ]);
    
    // 5. Obtener los resultados
    $preguntas = $stmt->fetchAll();
    
    // 6. Mostrar los resultados al usuario
    echo "<h2>Preguntas encontradas para: $tema_elegido - $subtema_elegido</h2>";
    if (empty($preguntas)) {
        echo "<p>No se encontraron preguntas que coincidan con la selección.</p>";
    } else {
        echo "<ul>";
        foreach ($preguntas as $preg) {
            echo "<li>";
            echo "<strong>Pregunta:</strong> " . $preg['textoPregunta'] . "<br>";
            $datos = json_decode($preg['respuestas']);
            $listaRespuestas = $datos -> respuesta;
            echo "Opción 1: ". "<br><input class='form-check-input' type='radio'>". implode("<br><input class='form-check-input' type='radio'>", $listaRespuestas) . "<br>";
            echo "<small>Apariciones: " . $preg['apariciones'] . "</small>";
            echo "</li><br>";
        }
        echo "</ul>";
    }
} else {
    echo "Por favor, selecciona un tema y un subtema válidos.";
}
?>