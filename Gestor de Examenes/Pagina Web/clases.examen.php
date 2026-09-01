<?php

class Usuario
{
    private string $nombre;
    private string $apellido;
    private string $email;

    public function __construct($nombre, $apellido, $email)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
    }

    public function iniciarSesion()
    {
    }

    public function cerrarSesion()
    {
    }
}


class Profesor extends Usuario
{
    public function generarExamen()
    {
    }

    public function verResultado()
    {
    }

    public function descargarListaResultados()
    {
    }
}


class Alumno extends Usuario
{
    public function ingresarAlExamen()
    {
    }

    public function verResultado()
    {
    }
}


class Examen
{
    private int $id_examen;
    private string $tema;
    private DateTime $fecha;
    private string $enlaceAcceso;

    public function __construct($id_examen, $tema, $fecha, $enlaceAcceso)
    {
        $this->id_examen = $id_examen;
        $this->tema = $tema;
        $this->fecha = $fecha;
        $this->enlaceAcceso = $enlaceAcceso;
    }

    public function generarExamen()
    {
    }

    public function finalizarExamen()
    {
    }
}


class Pregunta
{
    private int $id_pregunta;
    private string $tema;
    private string $dificultad;
    private array $respuesta;
    private string $texto;
    private int $apariciones;

    public function __construct(
        $id_pregunta,
        $tema,
        $dificultad,
        $respuesta,
        $texto,
        $apariciones
    ) {
        $this->id_pregunta = $id_pregunta;
        $this->tema = $tema;
        $this->dificultad = $dificultad;
        $this->respuesta = $respuesta;
        $this->texto = $texto;
        $this->apariciones = $apariciones;
    }
}


class Resultado
{
    private int $id_resultado;
    private DateTime $fecha;
    private int $calificacion;
    private int $cantidadErrores;
    private int $cantidadAciertos;

    public function __construct($id_resultado, $fecha)
    {
        $this->id_resultado = $id_resultado;
        $this->fecha = $fecha;
        $this->calificacion = 0;
        $this->cantidadErrores = 0;
        $this->cantidadAciertos = 0;
    }

    public function calcularCalificacion()
    {
    }

    public function calcularErrores()
    {
    }

    public function calcularAciertos()
    {
    }
}

?>
