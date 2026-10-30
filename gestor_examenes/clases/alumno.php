<?php
class Alumno {
    private ?int $idAlumno;
    private int $idUsuario;

    public function __construct(?int $idAlumno, int $idUsuario) {
        $this->idAlumno = $idAlumno;
        $this->idUsuario = $idUsuario;
    }

    public function getIdAlumno(): int {
        return $this -> idAlumno;
    }

    public function getIdUsuario(): int {
        return $this -> idUsuario;
    }

    public function setIdAlumno(?int $idAlumno): void {
        $this -> idAlumno = $idAlumno;
    }

    public function setIdUsuario(int $idUsuario): void {
        $this -> idUsuario = $idUsuario;
    }

    public function ingresarAlExamen() {
    }

    public function verResultado() {
    }
}
?>