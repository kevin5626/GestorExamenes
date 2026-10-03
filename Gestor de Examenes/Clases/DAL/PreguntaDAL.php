<?php
require_once(__DIR__ . "/../Pregunta.php");
require_once(__DIR__ . "/../AbstractMapper.php");

class PreguntaDAL extends AbstractMapper {
    public function insert($pregunta) {
        $pdo = $this->conectar();
        $stmt = $pdo->prepare("INSERT INTO preguntas (materia, tema, subtema, dificultad, textoPregunta, respuestas, respuestaCorrecta, apariciones) VALUES(:tema, :subtema, :dificultad, :textoPregunta, :respuestas, :respuestaCorrecta, :apariciones);");
        $stmt->execute([
            ':materia'            => $pregunta->getMateria(),
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
            $pregunta = new Pregunta($registro["idPregunta"], $registro["materia"], $registro["tema"], $registro["subtema"], $registro["dificultad"], $registro["textoPregunta"], $registro["respuestas"], $registro["respuestaCorrecta"], $registro["apariciones"]);

            $registros[] = $pregunta;
        }
        return $registros;
    }
}
?>