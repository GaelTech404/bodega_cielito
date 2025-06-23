document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("productos-container");
    const addBtn = document.getElementById("agregar-producto");
    const totalVisible = document.getElementById("total-mostrado");
    const totalOculto = document.getElementById("total-hidden");

    // Función para calcular el total
    function calcularTotal() {
        let total = 0;
        const filas = container.querySelectorAll(".producto-row");

        filas.forEach(fila => {
            const cantidad = parseFloat(fila.querySelector('input[name="cantidad[]"]').value) || 0;
            const precio = parseFloat(fila.querySelector('input[name="precio_unitario[]"]').value) || 0;
            total += cantidad * precio;
        });

        totalVisible.value = total.toFixed(2);
        totalOculto.value = total.toFixed(2);
    }

    // Botón para agregar fila de producto
    addBtn.addEventListener("click", function () {
        const nuevaFila = container.querySelector(".producto-row").cloneNode(true);
        nuevaFila.querySelectorAll("input").forEach(input => input.value = "");
        nuevaFila.querySelector("select").selectedIndex = 0;
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

    // Recalcular total cuando se edite cantidad o precio
    container.addEventListener("input", function (e) {
        if (
            e.target.name === "cantidad[]" ||
            e.target.name === "precio_unitario[]"
        ) {
            calcularTotal();
        }
    });

    calcularTotal(); // Cálculo inicial por si hay datos precargados
});
