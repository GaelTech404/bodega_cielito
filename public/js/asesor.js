function renderMarkdownIA(texto) {
    // Negrita: **texto**
    texto = texto.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');

    // Títulos Markdown: ### Título
    texto = texto.replace(/^### (.*)$/gm, '<h3>$1</h3>');
    texto = texto.replace(/^## (.*)$/gm, '<h2>$1</h2>');
    texto = texto.replace(/^# (.*)$/gm, '<h1>$1</h1>');

    // Listas con guiones o asteriscos
    texto = texto.replace(/(^|\n)([-*]) (.*)/g, '$1<ul><li>$3</li></ul>');
    texto = texto.replace(/<\/ul>\s*<ul>/g, ''); // Junta listas continuas

    // Saltos de línea
    texto = texto.replace(/\n/g, '<br>');

    return texto;
}

function setPregunta(texto) {
    const input = document.getElementById('inputPregunta');
    if (input) {
        input.value = texto;
        input.focus();
        input.dispatchEvent(new Event('input')); // Para expandir el textarea automáticamente
    }
}

function agregarMensaje(tipo, texto) {
    const chatBox = document.getElementById('chatBox');
    const div = document.createElement('div');
    div.className = 'chat-message ' + tipo;

    if (tipo === 'bot') {
        texto = renderMarkdownIA(texto); // Aplicamos formato Markdown mejorado
        div.innerHTML = texto;
    } else {
        div.textContent = texto;
    }

    chatBox.appendChild(div);
    chatBox.scrollTop = chatBox.scrollHeight;
}


function enviarPregunta(e) {
    e.preventDefault();

    const input = document.getElementById('inputPregunta');
    const pregunta = input?.value.trim();
    if (!pregunta) return;

    agregarMensaje('user', pregunta);
    input.value = '';
    input.disabled = true;

    // Mostrar mensaje "escribiendo..."
    const chatBox = document.getElementById('chatBox');
    const typingIndicator = document.createElement('div');
    typingIndicator.className = 'chat-message bot';
    typingIndicator.textContent = '🤖 Escribiendo...';
    typingIndicator.id = 'bot-typing';
    chatBox.appendChild(typingIndicator);
    chatBox.scrollTop = chatBox.scrollHeight;

    fetch(`${URL_BASE}/ia/procesar`, {
        method: "POST",
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `pregunta=${encodeURIComponent(pregunta)}`
    })
        .then(res => {
            if (!res.ok) throw new Error("HTTP status: " + res.status);
            return res.json();
        })

        .then(data => {
            input.disabled = false;
            const typing = document.getElementById('bot-typing');
            if (typing) typing.remove();

            agregarMensaje('bot', data.respuesta || '⚠️ Sin respuesta.');
        })
        .catch(async err => {
            input.disabled = false;
            const typing = document.getElementById('bot-typing');
            if (typing) typing.remove();

            console.error("Error en fetch:", err);

            try {
                const res = await err.response?.text();
                console.warn("Contenido recibido (texto no JSON):", res);
            } catch { }

            agregarMensaje('bot', '⚠️ Error al contactar IA');
        });

}
document.addEventListener('input', function (e) {
    if (e.target.id === 'inputPregunta') {
        e.target.style.height = 'auto';
        e.target.style.height = Math.min(e.target.scrollHeight, 150) + 'px';
    }
});
document.getElementById('inputPregunta').addEventListener('keydown', function (e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault(); // Evita el salto de línea normal
        document.getElementById('formAsesor').requestSubmit(); // Envia el formulario
    }
});

