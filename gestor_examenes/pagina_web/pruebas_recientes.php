<?php require_once __DIR__ . "/../php/cargar_pruebas_recientes.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pruebas recientes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Pruebas recientes</h1>
        <?php if ($errorCarga): ?>
            <div class="alert alert-danger" role="alert">No se pudieron cargar tus pruebas. Inténtalo de nuevo más tarde.</div>
        <?php else: ?>
            <div class="row g-3 mb-4">
                <div class="col-sm-4"><div class="border rounded p-3 h-100"><div class="text-muted">Pruebas creadas</div><strong class="fs-4"><?php echo count($examenes); ?></strong></div></div>
                <div class="col-sm-4"><div class="border rounded p-3 h-100"><div class="text-muted">Entregas recibidas</div><strong class="fs-4"><?php echo $totalResultados; ?></strong></div></div>
                <div class="col-sm-4"><div class="border rounded p-3 h-100"><div class="text-muted">Promedio general</div><strong class="fs-4"><?php echo $promedio !== null ? number_format($promedio, 1, ",", ".") . "/10" : "Sin calificaciones"; ?></strong></div></div>
            </div>

            <?php if (empty($examenes)): ?>
                <p class="text-muted">Todavía no has creado pruebas.</p>
            <?php else: ?>
                <?php foreach ($examenes as $idExamen => $examen): ?>
                    <section class="border rounded mb-4">
                        <div class="p-3 border-bottom d-flex flex-wrap justify-content-between gap-2">
                            <div>
                                <h2 class="h5 mb-1"><?php echo $escapar($examen["tema"] ?: "Prueba sin tema"); ?></h2>
                                <span class="text-muted">Prueba #<?php echo (int) $idExamen; ?> · Creada <?php echo $escapar($examen["fechaExamen"]); ?></span>
                            </div>
                            <span class="badge text-bg-secondary align-self-start"><?php echo count($examen["resultados"]); ?> entregas</span>
                        </div>
                        <?php if (empty($examen["resultados"])): ?>
                            <p class="p-3 mb-0 text-muted">Aún no hay alumnos que hayan completado esta prueba.</p>
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
        <a href="inicio_profesor.php" class="btn btn-secondary">Volver al panel del profesor</a>
    </div>
</body>
</html>
