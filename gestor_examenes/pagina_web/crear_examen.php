<?php
session_start();

$materia = trim((string) ($_GET['materia'] ?? ''));
$materiasPermitidas = ['Programación', 'Lenguaje', 'Historia', 'Geografia', 'Ingles', 'Biologia'];
if (!in_array($materia, $materiasPermitidas, true)) {
    header('Location: inicio_profesor.php');
    exit;
}

$_SESSION['materia'] = $materia;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear examen</title>
    <link rel="icon" type="image/png" href="../imagenes/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/style.css">
</head>
<body>
    <div class="container mt-3">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="mb-4" style="font-family: 'Momo Trust Display', sans-serif;"><?php echo htmlspecialchars($materia, ENT_QUOTES, 'UTF-8'); ?></h1>
            <div class="mb-4">
                <a href="inicio_profesor.php" class="btn btn-danger">
                    <img src="../imagenes/icono_flecha.png" alt="Volver" width="20" height="20">
                </a>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-5">
                <form id="generarExamenForm" method="post" action="../php/crear_examen.php">
                    <div class="card p-4">
                        <p>Seleccione los temas que desea incluir en el examen.</p>

                        <button type="button" class="btn btn-primary mb-4" id="agregarTema">Agregar tema
                                <img src="../imagenes/icono_mas.png" class="mb-1" alt="Agregar" width="16" height="16">
                        </button>

                        <div id="contenedorTemas">
                            <div class="tema border rounded p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="m-0" style="font-family: 'Dm-Sans', sans-serif;">Tema 1</h4>
                                </div>

                                <div class="mb-3">
                                    <select class="form-select" data-role="tema" name="temas[0][tema]">
                                        <option value="">Seleccionar tema</option>
                                        
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Subtema</label>
                                    <select class="form-select" data-role="subtema" name="temas[0][subtema]" disabled>
                                        <option value="">Seleccionar subtema</option>
                                
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Cantidad de preguntas</label>
                                    <select class="form-select" data-role="cantidad" name="temas[0][cantidad]">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="form-label">Dificultad</label>
                                    <select class="form-select" data-role="dificultad" name="temas[0][dificultad]">
                                        <option value="Facil">Fácil</option>
                                        <option value="Intermedio">Intermedio</option>
                                        <option value="Dificil">Difícil</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-success">Generar examen
                                <img src="../imagenes/icono_verificacion.png" alt="Verificacion" width="16" height="17">
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-7">
                <div class="card p-3">
                    <h2 class="text-center">Modelo de examen</h2>
                    <p class="text-center">Aquí se muestran las preguntas seleccionadas para el examen.</p>
                    <div id="preguntas">
                        <p class="text-muted text-center">Aún no se han generado preguntas.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/crear_examen.js"></script>
</body>
</html>
