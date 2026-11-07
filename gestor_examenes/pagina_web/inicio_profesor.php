<?php
session_start();
if (!isset($_SESSION["idUsuario"])) {
    header("Location: index.php");
    exit;
}
if ($_SESSION["rol"] !== "profesor") {
    header("Location: inicio_alumno.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/style.css">
    <title>Profesor</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid px-4">
        <div class="d-flex">
            <h4 class="me-3" style="font-family: 'Cal Sans', sans-serif;">Gestor de Examenes</h4>
            <img src="../imagenes/icono_examen.png" width="30" height="30">
        </div>
        </ul>
            <div class="d-flex">
                <div class="align-items-center justify-content-center text-center me-4 p-0">
                    <img src="../imagenes/icono_persona.png" alt="Usuario" width="30" height="30">
                    <h6><?php echo $_SESSION["nombre"]. " ". $_SESSION["apellido"]; ?></h6>
                </div>
                <div class="mt-2">
                    <a href="../php/cerrar_sesion.php" class="btn btn-danger">
                        <img src="../imagenes/icono_puerta.png" alt="Cerrar sesión" width="20" height="20">
                    </a>
                </div>
            </div>
        </div>
    </div>
    </nav>

    <div>
    </div>
    <div class="container mt-5">
        <!-- Título -->
        <div class="mb-4">
            <h2>Materias</h2>
        </div>
        <!-- Temas -->
        <div class="row g-3">
            <div class="col-md-4 zoom">
                <form action="crear_examen.php" method="get">
                    <button type="submit" name="materia" value="Programación" class="btn btn-outline-dark w-100" style="font-family: 'Mulish', sans-serif;">Programación</button>
                </form>
            </div>
            <div class="col-md-4 zoom">
                <form action="crear_examen.php" method="get">
                    <button type="submit" name="materia" value="Lenguaje" class="btn btn-outline-dark w-100" style="font-family: 'Mulish', sans-serif;">Lenguaje</button>
                </form>
            </div>
            <div class="col-md-4 zoom">
                <form action="crear_examen.php" method="get">
                    <button type="submit" name="materia" value="Historia" class="btn btn-outline-dark w-100" style="font-family: 'Mulish', sans-serif;">Historia</button>
                </form>
            </div>
            <div class="col-md-4 zoom">
                <form action="crear_examen.php" method="get">
                    <button type="submit" name="materia" value="Geografia" class="btn btn-outline-dark w-100" style="font-family: 'Mulish', sans-serif;">Geografia</button>
                </form>
            </div>
            <div class="col-md-4 zoom">
                <form action="crear_examen.php" method="get">
                    <button type="submit" name="materia" value="Ingles" class="btn btn-outline-dark w-100" style="font-family: 'Mulish', sans-serif;">Ingles</button>
                </form>
            </div>
            <div class="col-md-4 zoom">
                <form action="crear_examen.php" method="get">
                    <button type="submit" name="materia" value="Biologia" class="btn btn-outline-dark w-100" style="font-family: 'Mulish', sans-serif;">Biologia</button>
                </form>
            </div>
        </div>
        <hr class="mt-4">
        <!-- Mis exámenes -->
        <div class="mb-4">
            <h2>Mis exámenes</h2>
        </div>
        <div class="row justify-content-center g-4">
            <!-- Carpeta 1 -->
            <div class="col-md-4 zoom">
                <a href="pruebas_recientes.php" class="text-decoration-none text-dark">
                    <div class="card text-center p-4">
                        <div class="fs-1">
                            <img src="../imagenes/icono_carpeta1.png" width="50" height="50">
                        </div>
                        <h5 class="mt-3">Mis examenes</h5>
                    </div>
                </a>
            </div>
            <!-- Carpeta 2 -->
            <div class="col-md-4 zoom">
                <a href="pruebas_recientes.php" class="text-decoration-none text-dark">
                    <div class="card text-center p-4">
                        <div class="fs-1">
                            <img src="../imagenes/icono_carpeta2.png" width="53" height="53">
                        </div>
                        <h5 class="mt-3">Examenes recientes</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>