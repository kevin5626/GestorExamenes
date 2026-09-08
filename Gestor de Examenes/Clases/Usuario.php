<?php
class Usuario {
    private int $idUsuario;
    private string $nombre;
    private string $apellido;
    private string $email;
    private string $contrasena;

    public function __construct($idUsuario, $nombre, $apellido, $email, $contrasena){
        $this->idUsuario = $idUsuario;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->contrasena = $contrasena;
    }

    public function getIdUsuario(): int {
        return $this -> idUsuario;
    }

    public function getNombre(): string {
        return $this -> nombre;
    }

    public function getApellido(): string {
        return $this -> apellido;
    }

    public function getEmail(): string {
        return $this -> email;
    }

    public function getContrasena(): string {
        return $this -> contrasena;
    }

    public function setIdUsuario(string $idUsuario): void {
        $this -> $idUsuario = $idUsuario;
    }

    public function setNombre(string $nombre): void {
        $this -> nombre = $nombre;
    }

    public function iniciarSesion($email, $contrasena){
        if ($email == $this->email && $contrasena == $this->contrasena) {
            return true;
        }
        return false;
    }

    public function cerrarSesion(){
        return true;
    }
}
?>