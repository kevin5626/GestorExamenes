<?php
class Profesor extends Usuario {
    private int $idProfesor;

    public function __construct($idProfesor) {
        $this->idProfesor = $idProfesor;
    }

    public function getIdProfesor(): int {
        return $this -> idProfesor;
    }

    public function setIdProfesor(int $idProfesor): void {
        $this -> idProfesor = $idProfesor;
    }

    public function generarExamen() {
    }

    public function verResultado() {
    }

    public function descargarListaResultados() {
    }
}
?>