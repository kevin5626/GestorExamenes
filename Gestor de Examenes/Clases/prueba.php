<?php
$nombre = "Kevin";
$apellido = "Veron";
$email = "kevin@gmail.com";
$contrasena = "profesora67";
$tipoUsuario = "profesor";

require_once(__DIR__ . '/Usuario.php');
require_once(__DIR__ . "/DAL/UsuarioDAL.php");

$dalUsuario = new UsuarioDAL();

$contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

$usuario = new Usuario(null, $nombre, $apellido, $email, $contrasenaHash);
$dalUsuario -> insert($usuario);

$usuarioArray = $dalUsuario -> get();
foreach($usuarioArray as $u) {
    echo "Nombre: " . $u->getNombre() . "\n";
}
?>