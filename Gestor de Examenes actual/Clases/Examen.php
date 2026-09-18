<?php
class Examen {
    private int $idExamen;
    private string $tema;
    private DateTime $fechaExamen;
    private string $enlaceAcceso;
    private int $idProfesor;

    public function __construct($idExamen, $tema, DateTime $fechaExamen, $enlaceAcceso, $idProfesor) {
        $this->idExamen = (int) $idExamen;
        $this->tema = (string) $tema;
        $this->fechaExamen = $fechaExamen;
        $this->enlaceAcceso = (string) $enlaceAcceso;
        $this->idProfesor = (int) $idProfesor;
    }

    public function getIdExamen(): int {
        return $this->idExamen;
    }

    public function getTema(): string {
        return $this->tema;
    }

    public function getFechaExamen(): DateTime {
        return $this->fechaExamen;
    }

    public function getEnlaceAcceso(): string {
        return $this->enlaceAcceso;
    }

    public function getIdProfesor(): int {
        return $this->idProfesor;
    }

    public function setIdExamen(int $idExamen): void {
        $this->idExamen = $idExamen;
    }

    public function setTema(string $tema): void {
        $this->tema = $tema;
    }

    public function setFechaExamen(DateTime $fechaExamen): void {
        $this->fechaExamen = $fechaExamen;
    }

    public function setEnlaceAcceso(string $enlaceAcceso): void {
        $this->enlaceAcceso = $enlaceAcceso;
    }

    public function setIdProfesor(int $idProfesor): void {
        $this->idProfesor = $idProfesor;
    }

    public function generarExamen(): void {
    }

    public function finalizarExamen(): void {
    }
}
?>