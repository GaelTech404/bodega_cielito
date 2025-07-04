document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("productos-container");
    const addBtn = document.getElementById("agregar-producto");
    const totalVisible = document.getElementById("total_mostrado") || document.getElementById("total-visible");
    const totalOculto = document.getElementById("total-hidden");

    function calcularTotal() {
        let total = 0;
        const filas = container.querySelectorAll(".producto-row");

        filas.forEach(fila => {
            const cantidad = parseFloat(fila.querySelector('input[name="cantidad[]"]').value) || 0;
            const precio = parseFloat(fila.querySelector('input[name="precio_unitario[]"]').value) || 0;
            total += cantidad * precio;
        });

        if (totalVisible) totalVisible.value = total.toFixed(2);
        if (totalOculto) totalOculto.value = total.toFixed(2);
    }

    // Agregar nueva fila
    addBtn.addEventListener("click", function () {
        const nuevaFila = container.querySelector(".producto-row").cloneNode(true);
        nuevaFila.querySelectorAll("input").forEach(input => input.value = "");

        const select = nuevaFila.querySelector("select");
        if (select) {
            select.selectedIndex = 0;
        }

        container.appendChild(nuevaFila);
        calcularTotal();
    });


    // Eliminar fila
    container.addEventListener("click", function (e) {
        if (e.target.classList.contains("btn-remove")) {
            const filas = container.querySelectorAll(".producto-row");
            if (filas.length > 1) {
                e.target.closest(".producto-row").remove();
                calcularTotal();
            }
        }
    });

    // Recalcular en cada input
    container.addEventListener("input", function (e) {
        if (
            e.target.name === "cantidad[]" ||
            e.target.name === "precio_unitario[]"
        ) {
            calcularTotal();
        }
    });

    calcularTotal(); // inicial
});
