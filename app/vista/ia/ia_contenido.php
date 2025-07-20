<div class="container mt-4">
    <h2 class="main-title mb-3"><i class="bi bi-robot"></i> Asesor Virtual para Bodega</h2>

    <div class="chat-box border rounded p-3 mb-3 overflow-auto" id="chatBox">
        <div class="chat-message bot">
            <i class="bi bi-chat-dots"></i> Hola, soy tu asesor. Pregúntame sobre productos, inventario o proveedores.
        </div>
    </div>

    <form id="formAsesor" class="form-ia mt-3" onsubmit="enviarPregunta(event)">
        <div class="input-group">
            <textarea id="inputPregunta" name="pregunta" class="form-control auto-expand" required
                placeholder="Ej: ¿Qué producto tiene más rotación?" rows="1" maxlength="300"
                style="resize: none; max-height: 150px; overflow-y: auto;"></textarea>
            <button type="submit" class="btn btn-secondary">Enviar</button>
        </div>
    </form>

    <div class="preguntas-rapidas mt-2">
        <button type="button" class="btn btn-outline-info btn-sm"
            onclick="setPregunta('¿Qué debo mejorar en mis ventas?')">¿Qué debo mejorar?</button>
        <button type="button" class="btn btn-outline-info btn-sm"
            onclick="setPregunta('¿Cómo optimizo el stock?')">¿Cómo optimizo el stock?</button>
        <button type="button" class="btn btn-outline-info btn-sm"
            onclick="setPregunta('¿Qué proveedor es más rentable?')">¿Proveedor rentable?</button>
    </div>
</div>
<script>
    const URL_BASE = "<?= URL_BASE ?>"; 
</script>
<script src="<?= URL_BASE ?>/js/asesor.js?v=<?= time() ?>"></script>