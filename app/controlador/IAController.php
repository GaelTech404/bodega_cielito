<?php

class IAController
{
    private $db;

    public function __construct()
    {
        AuthHelper::verificarAcceso(); // Asegura sesión
        $this->db = Database::conectar(); // Guarda conexión en propiedad
    }

    public function index()
    {
        $titulo = "Asesor Virtual";
        $contenido = VIEW_PATH . '/ia/ia_contenido.php';
        require_once VIEW_PATH . '/layout/layout.php';
    }

    public function procesar()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['respuesta' => '❌ Método no permitido.']);
            return;
        }

        $pregunta = trim($_POST['pregunta'] ?? '');
        if ($pregunta === '') {
            echo json_encode(['respuesta' => '❌ Pregunta vacía.']);
            return;
        }

        try {
            // ✅ Obtener rol desde sesión correctamente
            $usuario = AuthHelper::getUsuario();
            $rol = $usuario['rol'] ?? 'cajero';

            // ✅ Generar contexto
            $contextService = new IAContextService($this->db, $usuario);
            $contexto = $contextService->generarContexto();

            // ✅ Armar prompt con pregunta del usuario
            $prompt = "$contexto\n\nPregunta del usuario: $pregunta";

            // ✅ Obtener respuesta de IA
            $respuesta = IAHelper::consultarIA($prompt);

            echo json_encode(['respuesta' => $respuesta]);
        } catch (Exception $e) {
            echo json_encode(['respuesta' => "❌ Error: " . $e->getMessage()]);
        }
    }
}
