<?php
class Resultado {
    private int $idResultado;
    private DateTime $fechaResultado;
    private int $calificacion;
    private int $cantidadErrores;
    private int $cantidadAciertos;

    public function __construct($idResultado, $fechaResultado, $calificacion, $cantidadErrores, $cantidadAciertos) {
        $this->idResultado = $idResultado;
        $this->fechaResultado = $fechaResultado;
        $this->calificacion = $calificacion;
        $this->cantidadErrores = $cantidadErrores;
        $this->cantidadAciertos = $cantidadAciertos;
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

    public function calcularCalificacion() {
    }

    public function calcularErrores() {
    }

    public function calcularAciertos() {
    }
}

?>