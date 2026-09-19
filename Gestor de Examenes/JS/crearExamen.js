function actualizarNumerosSubtemas() {
    const subtemas = document.querySelectorAll(".subtema");

    subtemas.forEach(function (subtema, indice) {

        subtema.querySelector("h4").textContent = "Subtema " + (indice + 1);

        const selectSubtema = subtema.querySelector('[data-role="subtema"]');
        const selectCantidad = subtema.querySelector('[data-role="cantidad"]');
        const selectDificultad = subtema.querySelector('[data-role="dificultad"]');

        selectSubtema.name = "subtemas[" + indice + "][subtema]";
        selectCantidad.name = "subtemas[" + indice + "][cantidad]";
        selectDificultad.name = "subtemas[" + indice + "][dificultad]";
    });
}
const boton = document.getElementById('agregarSubtema');

boton.addEventListener('click', function() {
    const indice = document.querySelectorAll(".subtema").length;
    const nuevoSubtema = document.createElement("div");

    nuevoSubtema.classList.add("subtema", "border", "rounded", "p-3", "mb-3");

    nuevoSubtema.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="m-0">
                Subtema ${indice + 1}
            </h4>

            <button type="button" class="btn btn-danger btn-sm eliminarSubtema" onclick="eliminarSubtema(this)">
                X
            </button>
        </div>

        <div class="mb-3">
            <label class="form-label"> Subtema: </label>

            <select class="form-select" data-role="subtema" name="subtemas[${indice}][subtema]">
                <option value=""> Seleccionar subtema </option>
                <option value="Algoritmos"> Algoritmos </option>
                <option value="Logica"> Lógica </option>
                <option value="Clases"> Clases </option>
                <option value="JavaScript"> JavaScript </option>
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
            <label class="form-label"> Dificultad: </label>

            <select class="form-select" data-role="dificultad" name="subtemas[${indice}][dificultad]">
                <option value="Facil"> Fácil </option>
                <option value="Intermedio"> Intermedio </option>
                <option value="Dificil"> Difícil </option>
            </select>
        </div>
    `;

    document.getElementById("contenedorSubtemas").appendChild(nuevoSubtema);
});

function eliminarSubtema(boton) {
    const subtemas = document.querySelectorAll(".subtema");

    if (subtemas.length <= 1) {
        alert("Debe existir al menos un tema.");
        return;
    }

    const subtema = boton.closest(".subtema");
    subtema.remove();

    actualizarNumerosSubtemas();
}