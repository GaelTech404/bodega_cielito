// public/js/tema.js

function setTheme(theme) {
    document.cookie = "tema=" + theme + "; path=/; max-age=" + (60 * 60 * 24 * 30);
    if (theme === 'dark') {
        document.body.classList.add('dark', 'bg-dark', 'text-light');
    } else if (theme === 'light') {
        document.body.classList.remove('dark', 'bg-dark', 'text-light');
    } else {
        if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
            document.body.classList.add('dark', 'bg-dark', 'text-light');
        } else {
            document.body.classList.remove('dark', 'bg-dark', 'text-light');
        }
    }
}

// Ejecutar al cargar la página
(function () {
    const tema = document.cookie.split('; ').find(row => row.startsWith('tema='));
    if (tema) setTheme(tema.split('=')[1]);
})();
