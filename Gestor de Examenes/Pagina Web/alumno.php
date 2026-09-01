<?php

session_start();

if (!isset($_SESSION["idUsuario"])) {
    header("Location: principal.html");
    exit;
}

if ($_SESSION["rol"] !== "alumno") {
    header("Location: profesor.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ingresar a examen</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card p-4">

                    <h1 class="text-center mb-4">
                        Ingresar a examen
                    </h1>

                    <p class="text-center mb-4">
                        Ingrese el código del examen proporcionado por el profesor.
                    </p>

                    <form action="alumnoexamen.html" method="get">

                        <div class="mb-4">

                            <label for="codigo" class="form-label">
                                Código del examen:
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="codigo"
                                name="codigo"
                                placeholder="Ingrese el código"
                                required
                            >

                        </div>

                        <div class="d-flex justify-content-between">

                            <a href="principal2.html">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                >
                                    Cancelar
                                </button>
                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Aceptar
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</body>

</html>