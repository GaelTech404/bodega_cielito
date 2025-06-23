document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("productos-container");
    const addBtn = document.getElementById("agregar-producto");

    addBtn.addEventListener("click", function () {
        const row = container.querySelector(".producto-row").cloneNode(true);
        row.querySelectorAll("input").forEach(input => input.value = "");
        row.querySelector("select").selectedIndex = 0;
        container.appendChild(row);
    });
    function calcularTotal() {
        const rows = document.querySelectorAll(".producto-row");
        let total = 0;

        rows.forEach(row => {
            const cantidad = parseFloat(row.querySelector('input[name="cantidad[]"]').value) || 0;
            const precio = parseFloat(row.querySelector('input[name="precio_unitario[]"]').value) || 0;
            total += cantidad * precio;
        });

        document.getElementById("total_mostrado").value = total.toFixed(2);
    }

    // Ejecutar cada vez que cambie cantidad o precio
    document.addEventListener("input", function (e) {
        if (e.target.matches('input[name="cantidad[]"], input[name="precio_unitario[]"]')) {
            calcularTotal();
        }
    });

    // También al agregar o quitar filas
    document.getElementById("agregar-producto").addEventListener("click", () => {
        setTimeout(calcularTotal, 100); // espera a que se cree la fila
    });

    document.getElementById("productos-container").addEventListener("click", function (e) {
        if (e.target.classList.contains("btn-remove")) {
            setTimeout(calcularTotal, 100); // espera a que se elimine la fila
        }
    });

    container.addEventListener("click", function (e) {
        if (e.target.classList.contains("btn-remove")) {
            const rows = container.querySelectorAll(".producto-row");
            if (rows.length > 1) {
                e.target.closest(".producto-row").remove();
            }
        }
    });
});
