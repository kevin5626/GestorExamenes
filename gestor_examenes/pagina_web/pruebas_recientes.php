<?php require_once __DIR__ . "/../php/cargar_pruebas_recientes.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $esAlumno ? "Exámenes realizados" : "Exámenes recientes"; ?></title>

    <link rel="icon" type="image/png" href="../imagenes/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="mb-4"><?php echo $esAlumno ? "Mis exámenes realizados" : "Exámenes recientes"; ?></h1>
            <div class="mb-4">
                <a href="inicio_profesor.php" class="btn btn-danger">
                    <img src="../imagenes/icono_flecha.png" alt="Volver" width="20" height="20">
                </a>
            </div>
        </div>
        <?php if ($errorCarga): ?>
            <div class="alert alert-danger" role="alert">No se pudieron cargar tus exámenes. Inténtalo de nuevo más tarde.</div>
        <?php elseif ($esAlumno): ?>
            <div class="row g-3 mb-4">
                <div class="col-sm-6"><div class="border rounded p-3 h-100"><div class="text-muted">Exámenes Realizados</div><strong class="fs-4"><?php echo $totalResultados; ?></strong></div></div>
                <div class="col-sm-6"><div class="border rounded p-3 h-100"><div class="text-muted">Promedio</div><strong class="fs-4"><?php echo $promedio !== null ? number_format($promedio, 1, ",", ".") . "/10" : "Sin calificaciones"; ?></strong></div></div>
            </div>
            <?php if (empty($resultadosAlumno)): ?>
                <p class="text-muted">Todavía no has realizado ningún examen.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead><tr><th>Prueba</th><th>Calificación</th><th>Aciertos</th><th>Errores</th><th>Fecha</th></tr></thead>
                        <tbody>
                            <?php foreach ($resultadosAlumno as $resultado): ?>
                                <tr>
                                    <td><?php echo $escapar($resultado["tema"] ?: "Prueba sin tema"); ?></td>
                                    <td><strong><?php echo $escapar($resultado["calificacion"]); ?>/10</strong></td>
                                    <td><?php echo (int) $resultado["cantidadAciertos"]; ?></td>
                                    <td><?php echo (int) $resultado["cantidadErrores"]; ?></td>
                                    <td><?php echo $escapar($resultado["fechaResultado"]); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="row g-3 mb-4">
                <div class="col-sm-4"><div class="border rounded p-3 h-100"><div class="text-muted">Examenes creados</div><strong class="fs-4"><?php echo count($examenes); ?></strong></div></div>
                <div class="col-sm-4"><div class="border rounded p-3 h-100"><div class="text-muted">Entregas recibidas</div><strong class="fs-4"><?php echo $totalResultados; ?></strong></div></div>
                <div class="col-sm-4"><div class="border rounded p-3 h-100"><div class="text-muted">Promedio general</div><strong class="fs-4"><?php echo $promedio !== null ? number_format($promedio, 1, ",", ".") . "/10" : "Sin calificaciones"; ?></strong></div></div>
            </div>

            <?php if (empty($examenes)): ?>
                <p class="text-muted">Todavía no has creado exámenes.</p>
            <?php else: ?>
                <?php foreach ($examenes as $idExamen => $examen): ?>
                    <section class="border rounded mb-4">
                        <div class="p-3 border-bottom d-flex flex-wrap justify-content-between gap-2">
                            <div>
                                <h2 class="h5 mb-1"><?php echo $escapar($examen["tema"] ?: "Examen sin tema"); ?></h2>
                                <span class="text-muted">Examen #<?php echo (int) $idExamen; ?> · Creada <?php echo $escapar($examen["fechaExamen"]); ?></span>
                            </div>
                            <span class="badge text-bg-secondary align-self-start"><?php echo count($examen["resultados"]);?>entregas</span>
                        </div>
                        <?php if (empty($examen["resultados"])): ?>
                            <p class="p-3 mb-0 text-muted">Aún no hay alumnos que hayan completado este examen.</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-striped mb-0 align-middle">
                                    <thead><tr><th>Alumno</th><th>Calificación</th><th>Aciertos</th><th>Errores</th><th>Fecha de entrega</th></tr></thead>
                                    <tbody>
                                        <?php foreach ($examen["resultados"] as $resultado): ?>
                                            <tr>
                                                <td><?php echo $escapar(trim($resultado["nombreAlumno"] . " " . $resultado["apellidoAlumno"])); ?></td>
                                                <td><strong><?php echo $escapar($resultado["calificacion"]); ?>/10</strong></td>
                                                <td><?php echo (int) $resultado["cantidadAciertos"]; ?></td>
                                                <td><?php echo (int) $resultado["cantidadErrores"]; ?></td>
                                                <td><?php echo $escapar($resultado["fechaResultado"]); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </section>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
