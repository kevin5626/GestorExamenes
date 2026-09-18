<?php
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$email = $_POST["email"];
$contrasena = $_POST["contrasena"];
$tipoUsuario = $_POST["tipoUsuario"];

require_once(__DIR__ . "/../Clases/Usuario.php");
require_once(__DIR__ . "/../Clases/DAL/UsuarioDAL.php");

require_once(__DIR__ . "/../Clases/Alumno.php");
require_once(__DIR__ . "/../Clases/DAL/AlumnoDAL.php");

require_once(__DIR__ . "/../Clases/Profesor.php");
require_once(__DIR__ . "/../Clases/DAL/ProfesorDAL.php");

$dalUsuario = new UsuarioDAL();
$dalAlumno = new AlumnoDAL();
$dalProfesor = new ProfesorDAL();


if ($tipoUsuario !== "profesor" && $tipoUsuario !== "alumno") {
    die("Debe seleccionar si es profesor o alumno.");
}

$contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

$usuario = new Usuario(null, $nombre, $apellido, $email, $contrasenaHash);
$dalUsuario -> insertUsuario($usuario);

// Asignamos el usuario a su tipo
if ($tipoUsuario === "profesor") {
    $profesor = new Profesor(null, $usuario -> getIdUsuario());
    $dalProfesor -> insertProfesor($profesor);
} else {
    $alumno = new Alumno(null, $usuario -> getIdUsuario());
    $dalAlumno -> insertAlumno($alumno);
}


// Intentamos registrar el rol (profesor/alumno)
if ($tipoUsuario) {
    echo "<div id='mensaje' class='row justify-content-center w-100'>";
    echo "<div class='col-7 col-sm-6 col-lg-3 alert alert-success mx-5 text-center mt-3' role='alert'>";
    echo "¡Usuario registrado!";
    echo "<br>";
    echo "<a href='../Pagina Web/index.php' class='btn btn-outline-dark mt-2'>Iniciar Sesion</a>";
    echo "</div>";
    echo "</div>";
    echo "<script>
        setTimeout(function() {
        const mensaje = document.getElementById('mensaje');
        if(mensaje) {
            mensaje.style.transition = 'opacity 1s';
            mensaje.style.opacity = '0';
            setTimeout(function() { mensaje.style.display = 'none'; }, 1000);
        }
        }, 3000);
        </script>";
    } else {
        echo "Error al asignar el tipo de usuario";
    }
?>