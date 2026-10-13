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
                <option value="Algoritmos"> Algoritmos </option>
                <option value="Logica"> Lógica </option>
                <option value="Clases"> Clases </option>
                <option value="JavaScript"> JavaScript </option>
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