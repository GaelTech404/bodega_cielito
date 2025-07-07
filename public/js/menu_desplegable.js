document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    const menuBtn = document.getElementById('menu-btn');

    // Leer estado guardado
    const isMinimized = localStorage.getItem('sidebarMinimized') === 'true';
    if (isMinimized) {
        sidebar.classList.add('minimize');
    }

    // Evento del botón
    menuBtn.addEventListener('click', () => {
        sidebar.classList.toggle('minimize');
        localStorage.setItem('sidebarMinimized', sidebar.classList.contains('minimize'));
    });

    // Evitar que el sidebar se expanda al hacer clic en el mismo módulo
    const navLinks = document.querySelectorAll('.nav-link-custom');
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            if (href === window.location.href || href === window.location.pathname) {
                e.preventDefault(); // No hacer nada si ya estás ahí
            }
        });
    });
});
