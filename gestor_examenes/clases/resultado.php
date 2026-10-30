<?php
class Resultado {
    private int $idResultado;
    private DateTime $fechaResultado;
    private int $calificacion;
    private int $cantidadErrores;
    private int $cantidadAciertos;
    private int $idExamen;
    private int $idAlumno;

    public function __construct($idResultado, DateTime $fechaResultado, $calificacion, $cantidadErrores, $cantidadAciertos, $idExamen, $idAlumno) {
        $this->idResultado = (int) $idResultado;
        $this->fechaResultado = $fechaResultado;
        $this->calificacion = (int) $calificacion;
        $this->cantidadErrores = (int) $cantidadErrores;
        $this->cantidadAciertos = (int) $cantidadAciertos;
        $this->idExamen = (int) $idExamen;
        $this->idAlumno = (int) $idAlumno;
    }

    public function getIdResultado(): int {
        return $this -> idResultado;
    }

    public function getFechaResultado(): DateTime {
        return $this -> fechaResultado;
    }

    public function getCalificacion(): int {
        return $this -> calificacion;
    }

    public function getCantidadErrores(): int {
        return $this -> cantidadErrores;
    }

    public function getCantidadAciertos(): int {
        return $this -> cantidadAciertos;
    }

    public function getIdExamen(): int {
        return $this -> idExamen;
    }

    public function getIdAlumno(): int {
        return $this -> idAlumno;
    }

    public function setIdResultado(int $idResultado): void {
        $this -> idResultado = $idResultado;
    }

    public function setFechaResultado(DateTime $fechaResultado): void {
        $this -> fechaResultado = $fechaResultado;
    }

    public function setCalificacion(int $calificacion): void {
        $this -> calificacion = $calificacion;
    }

    public function setCantidadErrores(int $cantidadErrores): void {
        $this -> cantidadErrores = $cantidadErrores;
    }

    public function setCantidadAciertos(int $cantidadAciertos): void {
        $this -> cantidadAciertos = $cantidadAciertos;
    }

    public function setIdExamen(int $idExamen): void {
        $this -> idExamen = $idExamen;
    }

    public function setIdAlumno(int $idAlumno): void {
        $this -> idAlumno = $idAlumno;
    }

    public function calcularCalificacion() {
    }

    public function calcularErrores() {
    }

    public function calcularAciertos() {
    }
}

?>