<?php
class Pregunta {
    private int $idPregunta;
    private string $materia;
    private string $tema;
    private string $subtema;
    private string $dificultad;
    private string $textoPregunta;
    private array $respuestas;
    private string $respuestaCorrecta;
    private int $apariciones;

    public function __construct($idPregunta, $materia, $tema, $subtema, $dificultad, $textoPregunta, $respuestas, $respuestaCorrecta, $apariciones) {
        $this->idPregunta = $idPregunta;
        $this->materia = $materia;
        $this->tema = $tema;
        $this->subtema = $subtema;
        $this->dificultad = $dificultad;
        $this->textoPregunta = $textoPregunta;
        $this->respuestas = $respuestas;
        $this->respuestaCorrecta = $respuestaCorrecta;
        $this->apariciones = $apariciones;
    }

    public function getIdPregunta(): int {
        return $this -> idPregunta;
    }

    public function getMateria(): string {
        return $this -> materia;
    }

    public function getTema(): string {
        return $this -> tema;
    }

    public function getSubtema(): string {
        return $this -> subtema;
    }

    public function getDificultad(): string {
        return $this -> dificultad;
    }

    public function getTextoPregunta(): string {
        return $this -> textoPregunta;
    }

    public function getRespuestas(): array {
        return $this -> respuestas;
    }

    public function getRespuestaCorrecta(): string {
        return $this -> respuestaCorrecta;
    }

    public function getApariciones(): int {
        return $this -> apariciones;
    }

    public function setIdPregunta(int $idPregunta): void {
        $this -> idPregunta = $idPregunta;
    }

    public function setMateria(string $materia): void {
        $this -> materia = $materia;
    }

    public function setTema(string $tema): void {
        $this -> tema = $tema;
    }

    public function setSubTema(string $subtema): void {
        $this -> subtema = $subtema;
    }

    public function setDificultad(string $dificultad): void {
        $this -> dificultad = $dificultad;
    }

    public function setTextoPregunta(string $textoPregunta): void {
        $this -> textoPregunta = $textoPregunta;
    }

    public function setRespuestas(array $respuestas): void {
        $this -> respuestas = $respuestas;
    }

    public function setRespuestaCorrecta(string $respuestaCorrecta): void {
        $this -> respuestaCorrecta = $respuestaCorrecta;
    }

    public function setApariciones(int $apariciones): void {
        $this -> apariciones = $apariciones;
    }
}
?>