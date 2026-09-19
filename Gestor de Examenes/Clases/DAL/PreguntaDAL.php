<?php
require_once __DIR__ . "/../Pregunta.php";

class PreguntaDAL {
    private string $usuario = 'root';
    private string $contrasena = '1234';
    private string $servidor = "localhost";
    private string $basededatos = 'gestor_examenes';

    public function insertPregunta(Pregunta $pregunta): void {
        $conexion = mysqli_connect($this->servidor, $this->usuario, $this->contrasena, $this->basededatos) or die("Error al conectar: ");
        mysqli_set_charset($conexion, 'utf8');

        $respuestas = is_array($pregunta->getRespuestas()) ? json_encode($pregunta->getRespuestas()) : $pregunta->getRespuestas();

        $consulta = sprintf(
            "INSERT INTO preguntas (tema, subtema, dificultad, textoPregunta, respuestas, respuestaCorrecta, apariciones) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s');",
            $pregunta->getTema(),
            $pregunta->getSubtema(),
            $pregunta->getDificultad(),
            $pregunta->getTextoPregunta(),
            mysqli_real_escape_string($conexion, $respuestas),
            $pregunta->getRespuestaCorrecta(),
            $pregunta->getApariciones()
        );

        mysqli_query($conexion, $consulta);
        $pregunta->setIdPregunta(mysqli_insert_id($conexion));
        mysqli_close($conexion);
    }

    public function getPreguntas(): array {
        $conexion = mysqli_connect($this->servidor, $this->usuario, $this->contrasena, $this->basededatos) or die("Error al conectar: ");
        mysqli_set_charset($conexion, 'utf8');

        $resultado = mysqli_query($conexion, "SELECT * FROM preguntas");
        $registros = [];

        while ($registro = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
            $pregunta = new Pregunta(
                $registro["idPregunta"],
                $registro["materia"] ?? '',
                $registro["tema"],
                $registro["subtema"],
                $registro["dificultad"],
                $registro["textoPregunta"],
                $registro["respuestas"],
                $registro["respuestaCorrecta"],
                $registro["apariciones"]
            );

            $registros[] = $pregunta;
        }

        mysqli_close($conexion);
        return $registros;
    }

    public function obtenerPorTemaSubtemaDificultad(string $tema, string $subtema, string $dificultad, int $cantidad): array {
        $conexion = mysqli_connect($this->servidor, $this->usuario, $this->contrasena, $this->basededatos) or die("Error al conectar: ");
        mysqli_set_charset($conexion, 'utf8');

        $consulta = "SELECT * FROM preguntas WHERE tema = ? AND subtema = ? AND dificultad = ? ORDER BY apariciones ASC, RAND() LIMIT ?";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt === false) {
            mysqli_close($conexion);
            return [];
        }

        mysqli_stmt_bind_param($stmt, 'sssi', $tema, $subtema, $dificultad, $cantidad);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        $registros = [];
        while ($registro = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
            $pregunta = new Pregunta(
                $registro["idPregunta"],
                $registro["materia"] ?? '',
                $registro["tema"],
                $registro["subtema"],
                $registro["dificultad"],
                $registro["textoPregunta"],
                $registro["respuestas"],
                $registro["respuestaCorrecta"],
                $registro["apariciones"]
            );

            $registros[] = $pregunta;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conexion);
        return $registros;
    }
}
?>