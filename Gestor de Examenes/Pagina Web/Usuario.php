<?php

class Usuario
{
    private string $nombre;
    private string $apellido;
    private string $email;
    private string $contrasena;

    public function __construct($nombre, $apellido, $email, $contrasena)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->contrasena = $contrasena;
    }

    public function iniciarSesion($email, $contrasena)
    {
        if ($email == $this->email && $contrasena == $this->contrasena) {
            return true;
        }

        return false;
    }

    public function cerrarSesion()
    {
        return true;
    }
}
?>