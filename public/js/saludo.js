document.addEventListener("DOMContentLoaded", () => {
    const fechaEl = document.getElementById("fecha");
    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const hoy = new Date().toLocaleDateString('es-ES', opciones);
    fechaEl.textContent = hoy;
});
