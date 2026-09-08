<?php
class Examen {
    private int $idExamen;
    private string $tema;
    private DateTime $fechaExamen;
    private string $enlaceAcceso;

    public function __construct($idExamen, $tema, $fechaExamen, $enlaceAcceso) {
        $this->idExamen = $idExamen;
        $this->tema = $tema;
        $this->fechaExamen = $fechaExamen;
        $this->enlaceAcceso = $enlaceAcceso;
    }

    public function getIdExamen(): int {
        return $this -> idExamen;
    }

    public function getTema(): string {
        return $this -> tema;
    }

    public function getFechaExamen(): DateTime {
        return $this -> fechaExamen;
    }

    public function getEnlaceAcceso(): string {
        return $this -> enlaceAcceso;
    }

    public function setIdExamen(int $idExamen): void {
        $this -> idExamen = $idExamen;
    }

    public function setTema(string $tema): void {
        $this -> tema = $tema;
    }

    public function setFechaExamen(DateTime $idExamen): void {
        $this -> idExamen = $idExamen;
    }

    public function setIdEnlaceAcceso(string $enlaceAcceso): void {
        $this -> enlaceAcceso = $enlaceAcceso;
    }

    public function generarExamen(){
    }

    public function finalizarExamen(){
    }
}
?>