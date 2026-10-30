<?php
require_once(__DIR__ . "/../examen_y_preguntas.php");
require_once(__DIR__ . "/../abstract_mapper.php");

class ExamenYPreguntaDAL extends AbstractMapper {
    public function insert($examenYPregunta) {
        $pdo = $this->conectar();
        $stmt = $pdo->prepare("INSERT INTO examenesYPreguntas (idExamen, idPregunta) VALUES(:idExamen, :idPregunta);");
        $stmt->execute([
            ':idExamen'   => $examenYPregunta->getIdExamen(),
            ':idPregunta' => $examenYPregunta->getIdPregunta(),
        ]);
    }

    public function get(): array {
        $pdo = $this->conectar();
        $stmt = $pdo->query("SELECT * FROM examenesYPreguntas");
        $registros = array();

        while($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $examenYPregunta = new ExamenYPregunta($registro["idExamen"], $registro["idPregunta"]);

            $registros[] = $examenYPregunta;
        }
        return $registros;
    }
}
?>
