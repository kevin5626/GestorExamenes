<?php
require_once(__DIR__ . "/../pregunta.php");
require_once(__DIR__ . "/../abstract_mapper.php");

class PreguntaDAL extends AbstractMapper {

    public function obtenerTemas(): array {
        $pdo = $this->conectar();
        $stmt = $pdo->query("SELECT DISTINCT tema FROM preguntas WHERE tema <> '' ORDER BY tema");

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    public function obtenerSubtemasPorTema(string $tema): array {
        $pdo = $this->conectar();
        $stmt = $pdo->prepare("SELECT DISTINCT subtema FROM preguntas WHERE tema = :tema AND subtema <> '' ORDER BY subtema");
        $stmt->execute([':tema' => $tema]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function insert($pregunta) {
        $pdo = $this->conectar();
        $stmt = $pdo->prepare("INSERT INTO preguntas (tema, subtema, dificultad, textoPregunta, respuestas, respuestaCorrecta, apariciones) VALUES(:tema, :subtema, :dificultad, :textoPregunta, :respuestas, :respuestaCorrecta, :apariciones);");
        $stmt->execute([
            ':tema'               => $pregunta->getTema(),
            ':subtema'            => $pregunta->getSubtema(),
            ':dificultad'         => $pregunta->getDificultad(),
            ':textoPregunta'      => $pregunta->getTextoPregunta(),
            ':respuestas'         => $pregunta->getRespuestas(),
            ':respuestaCorrecta'  => $pregunta->getRespuestaCorrecta(),
            ':apariciones'        => $pregunta->getApariciones(),
        ]);

        $idPregunta = $pdo->lastInsertId(); 
        $pregunta->setIdPregunta($idPregunta);
    }

    public function get(): array {
        $pdo = $this->conectar();
        $stmt = $pdo->query("SELECT * FROM preguntas");
        $registros = array();

        while($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pregunta = new Pregunta($registro["idPregunta"], $registro["tema"], $registro["subtema"], $registro["dificultad"], $registro["textoPregunta"], $registro["respuestas"], $registro["respuestaCorrecta"], $registro["apariciones"]);

            $registros[] = $pregunta;
        }
        return $registros;
    }

    public function obtenerPorId(int $idPregunta): ?Pregunta {
        $pdo = $this->conectar();
        $stmt = $pdo->prepare("SELECT * FROM preguntas WHERE idPregunta = :idPregunta");
        $stmt->execute([
            ':idPregunta' => $idPregunta,
        ]);
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$registro) {
            return null;
        }

        return new Pregunta($registro["idPregunta"], $registro["tema"], $registro["subtema"], $registro["dificultad"], $registro["textoPregunta"], $registro["respuestas"], $registro["respuestaCorrecta"], $registro["apariciones"]);
    }

    public function obtenerPorTemaSubtemaDificultad($tema, $subtema, $dificultad, $cantidad): array {
        $pdo = $this->conectar();
        $cantidad = max(1, (int) $cantidad);

        $stmt = $pdo->prepare("
                        SELECT *
                        FROM preguntas
                        WHERE tema = :tema
                            AND subtema = :subtema
                            AND dificultad = :dificultad
            ORDER BY RAND()
            LIMIT " . $cantidad . "
        ");
        $stmt->execute([
            ':tema'        => $tema,
            ':subtema'     => $subtema,
            ':dificultad'  => $dificultad,
        ]);

        $registros = array();
        while ($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pregunta = new Pregunta($registro["idPregunta"], $registro["tema"], $registro["subtema"], $registro["dificultad"], $registro["textoPregunta"], $registro["respuestas"], $registro["respuestaCorrecta"], $registro["apariciones"]);
            $registros[] = $pregunta;
        }
        return $registros;
    }

    public function obtenerPorIdExamen(int $idExamen): array {
        $pdo = $this->conectar();
        $stmt = $pdo->prepare("
            SELECT p.*
            FROM preguntas p
            INNER JOIN examenesYPreguntas ep ON p.idPregunta = ep.idPregunta
            WHERE ep.idExamen = :idExamen
            ORDER BY p.idPregunta
        ");
        $stmt->execute([
            ':idExamen' => $idExamen,
        ]);

        $registros = array();
        while ($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pregunta = new Pregunta($registro["idPregunta"], $registro["tema"], $registro["subtema"], $registro["dificultad"], $registro["textoPregunta"], $registro["respuestas"], $registro["respuestaCorrecta"], $registro["apariciones"]);
            $registros[] = $pregunta;
        }
        return $registros;
    }
}
?>