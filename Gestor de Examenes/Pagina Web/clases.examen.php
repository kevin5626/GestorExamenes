<?php

session_start();
if (!isset($_SESSION["idUsuario"])) {
    header("Location: principal.php");
    exit;
}
if ($_SESSION["rol"] !== "profesor") {
    header("Location: alumno.php");
    exit;
}

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









