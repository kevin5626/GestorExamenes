<?php

require_once __DIR__ . "/conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = $_POST["nombre"] ?? "";
    $apellido = $_POST["apellido"] ?? "";
    $email = $_POST["email"] ?? "";
    $contrasena = $_POST["contrasena"] ?? "";
    $tipoUsuario = $_POST["tipoUsuario"] ?? "";

    if ($tipoUsuario !== "profesor" && $tipoUsuario !== "alumno") {
        die("Debe seleccionar si es profesor o alumno.");
    }

    $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, apellido, email, contrasena)
            VALUES (?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);

    $stmt->bind_param(
        "ssss",
        $nombre,
        $apellido,
        $email,
        $contrasenaHash
    );

    if ($stmt->execute()) {

        // Obtenemos el ID del usuario recién creado
        $idUsuario = $conexion->insert_id;

        // Asignamos el usuario a su tipo
        if ($tipoUsuario === "profesor") {

            $sqlRol = "INSERT INTO profesores (idUsuario)
                       VALUES (?)";

        } else {

            $sqlRol = "INSERT INTO alumnos (idUsuario)
                       VALUES (?)";
        }

        $stmtRol = $conexion->prepare($sqlRol);

        $stmtRol->bind_param("i", $idUsuario);

        if ($stmtRol->execute()) {

            echo "Usuario creado correctamente.";
            echo "<br>";
            echo "<a href='principal.html'>Iniciar sesión</a>";

        } else {

            echo "Error al asignar el tipo de usuario: " . $stmtRol->error;
        }

        $stmtRol->close();

    } else {

        echo "Error al crear el usuario: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear cuenta</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card p-4">

                <h1 class="text-center mb-4">
                    Crear cuenta
                </h1>

                <form method="POST">

                    <div class="mb-3">
                        <label class="form-label">
                            Nombre:
                        </label>

                        <input
                            type="text"
                            name="nombre"
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Apellido:
                        </label>

                        <input
                            type="text"
                            name="apellido"
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Email:
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Contraseña:
                        </label>

                        <input
                            type="password"
                            name="contrasena"
                            class="form-control"
                            required
                        >
                    </div>

                    <!-- Tipo de usuario -->
                    <div class="mb-3">

                        <label class="form-label">
                            Tipo de usuario:
                        </label>

                        <select
                            name="tipoUsuario"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Seleccione una opción
                            </option>

                            <option value="alumno">
                                Alumno
                            </option>

                            <option value="profesor">
                                Profesor
                            </option>

                        </select>

                    </div>

                    <div class="d-grid">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Crear cuenta
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

</body>

</html>