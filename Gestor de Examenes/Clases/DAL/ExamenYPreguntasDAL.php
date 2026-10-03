<?php
require_once(__DIR__ . "/../ExamenYPregunta.php");
require_once(__DIR__ . "/../AbstractMapper.php");

class ExamenYPreguntaDAL extends AbstractMapper {
    public function insert($examenYPregunta) {
        $pdo = $this->conectar();
        $stmt = $pdo->prepare("INSERT INTO examenesYPreguntas (nombre, apellido) VALUES(:nombre, :apellido);");
        $stmt->execute([
            ':nombre'     => $examenYPregunta->getNombre(),
            ':apellido'   => $examenYPregunta->getApellido(),
        ]);

        $examenYPregunta = $pdo->lastInsertId(); 
        $examenYPregunta->setIdExamenYPregunta($examenYPregunta);
    }

    public function get(): array {
        $pdo = $this->conectar();
        $stmt = $pdo->query("SELECT * FROM examenesYPreguntas");
        $registros = array();

        while($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $examenYPregunta = new ExamenYPregunta ($registro["idExamenYPreguntas"], $registro["nombre"], $registro["apellido"]);

            $registros[] = $examenYPregunta;
        }
        return $registros;
    }
}
?>