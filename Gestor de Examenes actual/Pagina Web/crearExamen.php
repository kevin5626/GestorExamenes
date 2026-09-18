<?php
session_start();

if (!isset($_SESSION["idUsuario"])) {
    header("Location: principal.php");
    exit;
}

if ($_SESSION["rol"] !== "profesor") {
    header("Location: alumno.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear examen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Programación</h1>

        <form method="post" action="../PHP/crearExamen.php">
            <div class="row">
                <div class="col-md-5">
                    <div class="card p-4">
                        <h2>Temas</h2>
                        <p>Seleccione los temas que desea incluir en el examen.</p>

                        <button type="button" class="btn btn-primary mb-4" id="agregarSubtema">+ Agregar tema</button>

                        <div id="contenedorSubtemas">
                            <div class="subtema border rounded p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="m-0">Subtema 1</h4>
                                    <button type="button" class="btn btn-danger btn-sm eliminarSubtema">X</button>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Subtema:</label>
                                    <select class="form-select" data-role="subtema" name="subtemas[0][subtema]">
                                        <option value="">Seleccionar subtema</option>
                                        <option value="Algoritmos">Algoritmos</option>
                                        <option value="Logica">Lógica</option>
                                        <option value="Clases">Clases</option>
                                        <option value="JavaScript">JavaScript</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Cantidad de preguntas:</label>
                                    <select class="form-select" data-role="cantidad" name="subtemas[0][cantidad]">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="form-label">Dificultad:</label>
                                    <select class="form-select" data-role="dificultad" name="subtemas[0][dificultad]">
                                        <option value="Facil">Fácil</option>
                                        <option value="Intermedio">Intermedio</option>
                                        <option value="Dificil">Difícil</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-success">Generar examen</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="card p-4">
                        <h2>Modelo de examen</h2>
                        <p>Aquí se muestran las preguntas seleccionadas para el examen.</p>
                        <div id="preguntas">
                            <p class="text-muted">Aún no se han generado preguntas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        let numeroSubtema = 1;

        function actualizarNumerosSubtemas() {
            const subtemas = document.querySelectorAll('.subtema');

            subtemas.forEach(function (subtema, indice) {
                subtema.querySelector('h4').textContent = 'Subtema ' + (indice + 1);

                const selectSubtema = subtema.querySelector('[data-role="subtema"]');
                const selectCantidad = subtema.querySelector('[data-role="cantidad"]');
                const selectDificultad = subtema.querySelector('[data-role="dificultad"]');

                selectSubtema.name = 'subtemas[' + indice + '][subtema]';
                selectCantidad.name = 'subtemas[' + indice + '][cantidad]';
                selectDificultad.name = 'subtemas[' + indice + '][dificultad]';
            });

            numeroSubtema = subtemas.length;
        }

        document.getElementById('agregarSubtema').addEventListener('click', function () {
            const indice = document.querySelectorAll('.subtema').length;
            const nuevoSubtema = document.createElement('div');
            nuevoSubtema.classList.add('subtema', 'border', 'rounded', 'p-3', 'mb-3');
            nuevoSubtema.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="m-0">Subtema ${indice + 1}</h4>
                    <button type="button" class="btn btn-danger btn-sm eliminarSubtema">X</button>
                </div>

                <div class="mb-3">
                    <label class="form-label">Subtema:</label>
                    <select class="form-select" data-role="subtema" name="subtemas[${indice}][subtema]">
                        <option value="">Seleccionar subtema</option>
                        <option value="Algoritmos">Algoritmos</option>
                        <option value="Logica">Lógica</option>
                        <option value="Clases">Clases</option>
                        <option value="JavaScript">JavaScript</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cantidad de preguntas:</label>
                    <select class="form-select" data-role="cantidad" name="subtemas[${indice}][cantidad]">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Dificultad:</label>
                    <select class="form-select" data-role="dificultad" name="subtemas[${indice}][dificultad]">
                        <option value="Facil">Fácil</option>
                        <option value="Intermedio">Intermedio</option>
                        <option value="Dificil">Difícil</option>
                    </select>
                </div>
            `;

            document.getElementById('contenedorSubtemas').appendChild(nuevoSubtema);
        });

        document.getElementById('contenedorSubtemas').addEventListener('click', function (evento) {
            if (evento.target.classList.contains('eliminarSubtema')) {
                evento.target.closest('.subtema').remove();
                actualizarNumerosSubtemas();
            }
        });
    </script>
</body>
</html>
