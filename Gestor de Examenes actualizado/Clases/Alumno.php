<?php
class Alumno extends Usuario {
    private int $idAlumno;

    public function __construct($idAlumno) {
        $this->idAlumno = $idAlumno;
    }

    public function getIdAlumno(): int {
            return $this -> idAlumno;
        }

    public function setIdAlumno(int $idAlumno): void {
        $this -> idAlumno = $idAlumno;
    }

    public function ingresarAlExamen() {
    }

    public function verResultado() {
    }
}
?>