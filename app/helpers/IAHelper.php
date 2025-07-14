<?php
require_once __DIR__ . '/../config/config.php';

class IAHelper
{
    private const API_URL = 'https://api.groq.com/openai/v1/chat/completions';
    private const MODEL = 'llama-3.1-8b-instant';
    private const TIMEOUT = 10;
    private const CONNECT_TIMEOUT = 3;

    public static function consultarIA(string $pregunta, string $contextoExtra = ''): string
    {
        if (!defined('IA_API_KEY')) {
            throw new Exception("⚠️ La constante IA_API_KEY no está definida.");
        }

        $apiKey = IA_API_KEY;
        $url = 'https://api.groq.com/openai/v1/chat/completions';

        $mensajes = [];

        // 🧠 Instrucción base
        $mensajes[] = [
            "role" => "system",
            "content" => "Eres un asesor experto en ventas e inventario para bodegas. Analiza la información proporcionada y responde con un tono profesional pero accesible. Evita lenguaje técnico excesivo como '5x producto', y prefiere frases como '5 unidades de arroz'. Sé claro, humano y útil."
        ];


        // 🔁 Agrega el contexto dinámico
        if ($contextoExtra) {
            $mensajes[] = [
                "role" => "system",
                "content" => $contextoExtra
            ];
        }

        // 📩 Pregunta del usuario
        $mensajes[] = [
            "role" => "user",
            "content" => $pregunta
        ];

        $data = [
            "model" => "llama-3.1-8b-instant",
            "messages" => $mensajes,
            "temperature" => 0.5,
            "max_tokens" => 1500
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $apiKey"
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new Exception("Error de conexión: $error");
        }

        if ($httpCode !== 200) {
            throw new Exception("Error HTTP: $httpCode\n$response");
        }


        $resultado = json_decode($response, true);
        return $resultado['choices'][0]['message']['content'] ?? 'No se pudo obtener respuesta.';
    }



}
