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
                <option value=""> Seleccionar tema </option>
                <option value="Algoritmos"> Algoritmos </option>
                <option value="Logica"> Lógica </option>
                <option value="Clases"> Clases </option>
                <option value="JavaScript"> JavaScript </option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label"> Subtema: </label>

            <select class="form-select" data-role="subtema" name="temas[${indice}][subtema]">
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