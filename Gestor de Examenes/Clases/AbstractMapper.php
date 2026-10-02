<?php
abstract class AbstractMapper {
    protected string $servidor;
    protected string $usuario;
    protected string $contrasena;
    protected string $basededatos;
    protected string $charset;

    public function __construct() {
        $config = require __DIR__ . '/../PHP/config.php';
        $this->servidor    = $config['servidor'];
        $this->usuario     = $config['usuario'];
        $this->contrasena = $config['contrasena'];
        $this->basededatos = $config['basededatos'];
        $this->charset     = $config['charset'] ?? 'utf8mb4';
    }
    protected function conectar() {
        $dsn = "mysql:host={$this->servidor};dbname={$this->basededatos};charset={$this->charset}";
        try{
            $conexion = new PDO($dsn, $this->usuario, $this->contrasena);

            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conexion;
        } catch(PDOException $e) {
            die("Error de conexión: " .$e->getMessage());
        }
        
    }

    abstract protected function insert($objeto);
    abstract protected function get(): array;
}    
?>