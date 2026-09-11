<?php
class Profesor extends Usuario {
    private int $idProfesor;
    private int $idUsuario;

    public function __construct($idProfesor, $idUsuario) {
        $this->idProfesor = $idProfesor;
        $this->idUsuario = $idUsuario;
    }

    public function getIdProfesor(): int {
        return $this -> idProfesor;
    }

    public function getIdUsuario(): int {
        return $this -> idUsuario;
    }

    public function setIdProfesor(int $idProfesor): void {
        $this -> idProfesor = $idProfesor;
    }

    public function setIdUsuario(int $idUsuario): void {
        $this -> idUsuario = $idUsuario;
    }

    public function generarExamen() {
    }

    public function verResultado() {
    }

    public function descargarListaResultados() {
    }
}
?>