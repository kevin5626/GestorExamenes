<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Crear examen</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>


<body>
    <div class="container mt-4">
        <h1 class="mb-4">
            Matemática
        </h1>
        <div class="row">
            <div class="col-md-5">
                <div class="card p-4">
                    <h2>
                        Subtemas
                    </h2>

                    <p>
                        Seleccione los subtemas que desea incluir
                        en el examen.
                    </p>

                    <button type="button" class="btn btn-primary mb-4" id="agregarSubtema">
                        + Agregar subtema
                    </button>

                    <div id="contenedorSubtemas">
                        <div class="subtema border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="m-0">
                                    Subtema 1
                                </h4>

                                <button type="button" class="btn btn-danger btn-sm eliminarSubtema">
                                    X
                                </button>

                            </div>

                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label">
                                    Subtema:
                                </label>

                                <select class="form-select" name="subtema">
                                    <option value="">
                                        Seleccionar subtema
                                    </option>

                                    <option value="numeros">
                                        Números
                                    </option>

                                    <option value="algebra">
                                        Álgebra
                                    </option>

                                    <option value="geometria">
                                        Geometría
                                    </option>

                                    <option value="Logica">
                                        Logica
                                    </option>

                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Cantidad de preguntas:
                                </label>


                                <select class="form-select" name="cantidad">
                                    <option value="1">
                                        1
                                    </option>

                                    <option value="2">
                                        2
                                    </option>

                                    <option value="3">
                                        3
                                    </option>

                                    <option value="4">
                                        4
                                    </option>

                                    <option value="5">
                                        5
                                    </option>

                                    <option value="10">
                                        10
                                    </option>
                                </select>

                            </div>

                            <div>
                                <label class="form-label">
                                    Dificultad:
                                </label>


                                <select class="form-select" name="dificultad">
                                    <option value="Facil">
                                        Fácil
                                    </option>

                                    <option value="Intermedio">
                                        Intermedio
                                    </option>

                                    <option value="Dificil">
                                        Difícil
                                    </option>

                                </select>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <input type="submit" class="btn btn-primary mb-4 center" value="Confirmar">
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
                        <?php
        $tema_elegido = "Programación";
        $subtema_elegido = $_POST['subtema'];
        $cantidad = $_POST['cantidad'];
        $dificultad = $_POST['dificultad'];

        // 1. Configuración de la conexión a la base de datos
        $usuario = 'root';
        $contrasena = '1234';
        $servidor = "localhost";
        $basededatos = 'gestor_examenes';
        $charset = 'utf8mb4';

        $conexion = "mysql:host=$servidor;dbname=$basededatos;charset=$charset";

        try {
            $pdo = new PDO($conexion, $usuario, $contrasena);
        } catch (\PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }

        // 2. Capturar y validar los datos enviados por el usuario

        if ($tema_elegido && $subtema_elegido) {
            
            // 3. Tu consulta SQL con marcadores de posición seguros (:tema y :subtema)
            $sql = "SELECT idPregunta, tema, subtema, dificultad, textoPregunta, respuestas, apariciones
                    FROM preguntas
                    WHERE tema = :tema AND subtema = :subtema AND dificultad = :dificultad
                    ORDER BY apariciones ASC, RAND()
                    LIMIT $cantidad";
            
            // 4. Preparar y ejecutar la consulta de forma segura
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'tema'    => $tema_elegido,
                'subtema' => $subtema_elegido,
                'dificultad' => $dificultad
            ]);
            
            // 5. Obtener los resultados
            $preguntas = $stmt->fetchAll();
            
            // 6. Mostrar los resultados al usuario
            echo "<h2>Preguntas encontradas para: $tema_elegido - $subtema_elegido</h2>";
            if (empty($preguntas)) {
                echo "<p>No se encontraron preguntas que coincidan con la selección.</p>";
            } else {
                echo "<ul>";
                foreach ($preguntas as $preg) {
                    echo "<li>";
                    echo "<strong>Pregunta:</strong> " . $preg['textoPregunta'] . "<br>";
                    $datos = json_decode($preg['respuestas']);
                    $listaRespuestas = $datos -> respuesta;
                    echo "Opción 1: ". "<br><input class='form-check-input' type='radio'>". implode("<br><input class='form-check-input' type='radio'>", $listaRespuestas) . "<br>";
                    echo "<small>Apariciones: " . $preg['apariciones'] . "</small>";
                    echo "</li><br>";
                }
                echo "</ul>";
            }
        } else {
            echo "Por favor, selecciona un tema y un subtema válidos.";
        }
        ?>
            </div>

            <div class="col-md-7">
                <div class="card p-4">
                    <h2>
                        Modelo de examen
                    </h2>

                    <p>
                        Aquí se muestran las preguntas
                        seleccionadas para el examen.
                    </p>

                    <div id="preguntas">
                        <div class='pregunta border rounded p-3 mb-3'><div class='d-flex justify-content-between'><h5>Pregunta 1</h5><p></p></div></div>
                        <div class="pregunta border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <h5>
                                    Pregunta 1
                                </h5>

                                <button type="button" class="btn btn-danger btn-sm eliminarPregunta">
                                    X
                                </button>

                            </div>

                            <p>
                                ¿Cuál es el resultado de 5 + 7?
                            </p>
                        </div>

                        <div class="pregunta border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <h5>
                                    Pregunta 2
                                </h5>


                                <button
                                    type="button"
                                    class="btn btn-danger btn-sm eliminarPregunta"
                                >
                                    X
                                </button>

                            </div>


                            <p>
                                Resolver la siguiente ecuación:
                                2x + 4 = 10.
                            </p>


                        </div>


                        <div class="pregunta border rounded p-3 mb-3">


                            <div
                                class="d-flex justify-content-between"
                            >

                                <h5>
                                    Pregunta 3
                                </h5>


                                <button
                                    type="button"
                                    class="btn btn-danger btn-sm eliminarPregunta"
                                >
                                    X
                                </button>

                            </div>


                            <p>
                                ¿Cuál es el área de un cuadrado
                                de 5 cm de lado?
                            </p>
                        </div>
                    </div>



                    <div class="d-flex justify-content-between">
                        <p>Código de acceso: 1</p>
                        <a href="profesor.html">
                            <button type="button" class="btn btn-success">
                                Enviar examen
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let numeroSubtema = 1;

        document.getElementById("agregarSubtema")
            .addEventListener(
                "click",
                function () {
                    numeroSubtema++;

                    let nuevoSubtema = document.createElement("div");
                    nuevoSubtema.classList.add(
                        "subtema",
                        "border",
                        "rounded",
                        "p-3",
                        "mb-3"
                    );


                    nuevoSubtema.innerHTML = `

                        <div
                            class="d-flex justify-content-between align-items-center mb-3"
                        >

                            <h4 class="m-0">
                                Subtema ${numeroSubtema}
                            </h4>

                            <button
                                type="button"
                                class="btn btn-danger btn-sm eliminarSubtema"
                            >
                                X
                            </button>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Subtema:
                            </label>

                            <select class="form-select">

                                <option value="">
                                    Seleccionar subtema
                                </option>

                                <option value="numeros">
                                    Números
                                </option>

                                <option value="algebra">
                                    Álgebra
                                </option>

                                <option value="geometria">
                                    Geometría
                                </option>

                                <option value="funciones">
                                    Funciones
                                </option>

                            </select>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Cantidad de preguntas:
                            </label>

                            <select class="form-select">

                                <option value="1">
                                    1
                                </option>

                                <option value="2">
                                    2
                                </option>

                                <option value="3">
                                    3
                                </option>

                                <option value="4">
                                    4
                                </option>

                                <option value="5">
                                    5
                                </option>

                                <option value="10">
                                    10
                                </option>

                            </select>

                        </div>


                        <div>

                            <label class="form-label">
                                Dificultad:
                            </label>

                            <select class="form-select">

                                <option value="facil">
                                    Fácil
                                </option>

                                <option value="intermedio">
                                    Intermedio
                                </option>

                                <option value="dificil">
                                    Difícil
                                </option>

                            </select>

                        </div>

                    `;


                    document
                        .getElementById("contenedorSubtemas")
                        .appendChild(nuevoSubtema);


                }
            );



        document
            .getElementById("contenedorSubtemas")
            .addEventListener(
                "click",
                function(evento) {


                    if (
                        evento.target.classList.contains(
                            "eliminarSubtema"
                        )
                    ) {


                        evento.target
                            .closest(".subtema")
                            .remove();


                        actualizarNumerosSubtemas();


                    }

                }
            );



        function actualizarNumerosSubtemas() {


            let subtemas =
                document.querySelectorAll(
                    ".subtema"
                );


            subtemas.forEach(
                function(subtema, indice) {


                    subtema
                        .querySelector("h4")
                        .textContent =
                        "Subtema " + (indice + 1);


                }
            );


            numeroSubtema =
                subtemas.length;


        }




        document
            .getElementById("preguntas")
            .addEventListener(
                "click",
                function(evento) {


                    if (
                        evento.target.classList.contains(
                            "eliminarPregunta"
                        )
                    ) {


                        evento.target
                            .closest(".pregunta")
                            .remove();


                        actualizarNumerosPreguntas();


                    }

                }
            );



        function actualizarNumerosPreguntas() {


            let preguntas =
                document.querySelectorAll(
                    ".pregunta"
                );


            preguntas.forEach(
                function(pregunta, indice) {


                    pregunta
                        .querySelector("h5")
                        .textContent =
                        "Pregunta " + (indice + 1);


                }
            );


        }


    </script>


</body>

</html>
