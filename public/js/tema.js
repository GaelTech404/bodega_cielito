function setTheme(theme) {
    document.cookie = "tema=" + theme + "; path=/; max-age=" + (60 * 60 * 24 * 30);
    location.reload(); // ✅ Refrescar para que PHP aplique el nuevo tema
}
