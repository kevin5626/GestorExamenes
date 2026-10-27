function actualizarNumerosTemas() {
    const temas = document.querySelectorAll(".tema");

    temas.forEach(function (tema, indice) {

        tema.querySelector("h4").textContent = "Tema " + (indice + 1);

        const selectTema = tema.querySelector('[data-role="tema"]');
        const selectSubtema = tema.querySelector('[data-role="subtema"]');
        const selectCantidad = tema.querySelector('[data-role="cantidad"]');
        const selectDificultad = tema.querySelector('[data-role="dificultad"]');

        selectTema.name = "temas[" + indice + "][tema]";
        selectSubtema.name = "temas[" + indice + "][subtema]";
        selectCantidad.name = "temas[" + indice + "][cantidad]";
        selectDificultad.name = "temas[" + indice + "][dificultad]";
    });
}

let temasDisponibles = [];

function actualizarOpcionesTema(selectTema) {
    const temaActual = selectTema.value;
    selectTema.replaceChildren(new Option("Seleccionar tema", ""));

    temasDisponibles.forEach(function (tema) {
        selectTema.add(new Option(tema, tema));
    });

    selectTema.value = temasDisponibles.includes(temaActual) ? temaActual : "";
}

async function cargarTemas() {
    const selectoresTema = document.querySelectorAll('[data-role="tema"]');
    selectoresTema.forEach(function (selectTema) {
        selectTema.disabled = true;
        selectTema.replaceChildren(new Option("Cargando temas...", ""));
    });

    try {
        const respuesta = await fetch("../PHP/obtenerTemas.php");
        if (!respuesta.ok) {
            throw new Error("No se pudieron cargar los temas");
        }

        temasDisponibles = await respuesta.json();
        document.querySelectorAll('[data-role="tema"]').forEach(actualizarOpcionesTema);
    } catch (error) {
        document.querySelectorAll('[data-role="tema"]').forEach(function (selectTema) {
            selectTema.replaceChildren(new Option("Error al cargar temas", ""));
        });
    } finally {
        document.querySelectorAll('[data-role="tema"]').forEach(function (selectTema) {
            selectTema.disabled = false;
        });
    }
}

cargarTemas();

async function cargarSubtemas(selectTema) {
    const selectSubtema = selectTema.closest(".tema").querySelector('[data-role="subtema"]');
    const temaSeleccionado = selectTema.value;

    selectSubtema.innerHTML = '<option value="">Seleccionar subtema</option>';
    selectSubtema.disabled = true;

    if (!temaSeleccionado) {
        return;
    }

    try {
        const respuesta = await fetch("../PHP/obtenerSubtemas.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: new URLSearchParams({ tema: temaSeleccionado })
        });
        if (!respuesta.ok) {
            throw new Error("No se pudieron cargar los subtemas");
        }

        const subtemas = await respuesta.json();
        if (selectTema.value !== temaSeleccionado) {
            return;
        }

        subtemas.forEach(function (subtema) {
            const opcion = document.createElement("option");
            opcion.value = subtema;
            opcion.textContent = subtema;
            selectSubtema.appendChild(opcion);
        });

        selectSubtema.disabled = subtemas.length === 0;
    } catch (error) {
        selectSubtema.innerHTML = '<option value="">Error al cargar subtemas</option>';
    }
}

document.getElementById("contenedorTemas").addEventListener("change", function (evento) {
    if (evento.target.matches('[data-role="tema"]')) {
        cargarSubtemas(evento.target);
    }
});

const formularioGenerar = document.getElementById("generarExamenForm");
const contenedorPreguntas = document.getElementById("preguntas");

formularioGenerar.addEventListener("submit", async function(evento) {
    evento.preventDefault();

    const botonGenerar = formularioGenerar.querySelector('button[type="submit"]');
    const textoOriginal = botonGenerar.textContent;
    botonGenerar.disabled = true;
    botonGenerar.textContent = "Generando...";

    try {
        const respuesta = await fetch(formularioGenerar.action, {
            method: "POST",
            body: new FormData(formularioGenerar),
            headers: { "X-Requested-With": "XMLHttpRequest" }
        });

        if (!respuesta.ok) {
            throw new Error("No se pudo generar el examen.");
        }

        const html = await respuesta.text();
        const documento = new DOMParser().parseFromString(html, "text/html");
        const tarjetaModelo = documento.querySelector(".container .card");

        if (!tarjetaModelo) {
            throw new Error("La respuesta del servidor no contiene el modelo del examen.");
        }

        contenedorPreguntas.replaceChildren();
        Array.from(tarjetaModelo.children).forEach(function(elemento) {
            if (!elemento.querySelector("h2")) {
                contenedorPreguntas.appendChild(elemento.cloneNode(true));
            }
        });

        contenedorPreguntas.scrollIntoView({ behavior: "smooth", block: "start" });
    } catch (error) {
        contenedorPreguntas.innerHTML = '<div class="alert alert-danger" role="alert"></div>';
        contenedorPreguntas.querySelector(".alert").textContent = error.message;
    } finally {
        botonGenerar.disabled = false;
        botonGenerar.textContent = textoOriginal;
    }
});

const boton = document.getElementById('agregarTema');

boton.addEventListener('click', function() {
    const indice = document.querySelectorAll(".tema").length;
    const nuevoTema = document.createElement("div");

    nuevoTema.classList.add("tema", "border", "rounded", "p-3", "mb-3");

    nuevoTema.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="m-0">
                Tema ${indice + 1}
            </h4>

            <button type="button" class="btn btn-danger btn-sm eliminarTema" onclick="eliminarTema(this)">
                X
            </button>
        </div>

        <div class="mb-3">
            <label class="form-label"> Tema: </label>

            <select class="form-select" data-role="tema" name="temas[${indice}][tema]">
                <option value=""> Cargando temas... </option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label"> Subtema: </label>

            <select class="form-select" data-role="subtema" name="temas[${indice}][subtema]" disabled>
                <option value=""> Seleccionar subtema </option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Cantidad de preguntas:</label>

            <select class="form-select" data-role="cantidad" name="temas[${indice}][cantidad]">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="10">10</option>
            </select>
        </div>

        <div>
            <label class="form-label"> Dificultad: </label>

            <select class="form-select" data-role="dificultad" name="temas[${indice}][dificultad]">
                <option value="Facil"> Fácil </option>
                <option value="Intermedio"> Intermedio </option>
                <option value="Dificil"> Difícil </option>
            </select>
        </div>
    `;

    document.getElementById("contenedorTemas").appendChild(nuevoTema);
    const selectTema = nuevoTema.querySelector('[data-role="tema"]');
    if (temasDisponibles.length > 0) {
        actualizarOpcionesTema(selectTema);
    } else {
        cargarTemas();
    }
});

function eliminarTema(boton) {
    const temas = document.querySelectorAll(".tema");

    if (temas.length <= 1) {
        alert("Debe existir al menos un tema.");
        return;
    }

    const tema = boton.closest(".tema");
    tema.remove();

    actualizarNumerosTemas();
}