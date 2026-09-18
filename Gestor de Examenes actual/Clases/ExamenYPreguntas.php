<?php
class ExamenYPregunta {
    private int $idExamen;
    private int $idPregunta;

    public function __construct($idExamen, $idPregunta) {
        $this->idExamen = $idExamen;
        $this->idPregunta = $idPregunta;
    }

    public function getIdExamen(): int {
        return $this -> idExamen;
    }

    public function getIdPregunta(): int {
        return $this -> idPregunta;
    }

    public function setIdExamen(int $idExamen): void {
        $this -> idExamen = $idExamen;
    }

    public function setIdPregunta(int $idPregunta): void {
        $this -> idPregunta = $idPregunta;
    }
}
?>