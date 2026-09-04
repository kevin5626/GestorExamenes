<?php
$usuario = 'root';
$contrasena = '1234';
$servidor = "localhost";
$basededatos = 'gestor_examenes';
$charset = 'utf8mb4';

$conexion = new mysqli($servidor, $usuario, $contrasena, $basededatos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8");


?>