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
        $url = self::API_URL;

        $mensajes = [];

        $mensajes[] = [
            "role" => "system",
            "content" => "Eres un asesor experto en ventas e inventario para bodegas. Tu función es brindar información, no ejecutar acciones. Nunca debes registrar ventas, modificar stock o realizar operaciones en el sistema; solo puedes describir cómo hacerlo o responder preguntas basadas en los datos proporcionados. Si el usuario solicita registrar una venta, indícale que debe hacerlo desde el módulo correspondiente o pide confirmación externa."
        ];

        $db = Database::conectar();
        $fechaReal = (new self())->responderFecha();

        $usuario = $_SESSION['usuario'] ?? ['rol' => 'cajero', 'id_usuario' => 0]; // o de donde venga
        $ventasHoy = self::obtenerVentasDeHoy($db, $usuario);
        $mensajes[] = ["role" => "system", "content" => $ventasHoy];

        $mensajes[] = [
            "role" => "system",
            "content" => $fechaReal
        ];
        $mensajes[] = [
            "role" => "system",
            "content" => $ventasHoy
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
    public static function obtenerVentasDeHoy(mysqli $db, array $usuario): string
    {
        $hoy = date('Y-m-d');
        $rol = strtolower($usuario['rol']);
        $idUsuario = $usuario['id_usuario'];

        if ($rol === 'admin') {
            $query = "
            SELECT v.id_venta, v.total, u.nombre_usuario
            FROM ventas v
            JOIN usuarios u ON v.id_usuario = u.id_usuario
            WHERE DATE(v.fecha_venta) = ?
        ";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $hoy);
        } else {
            // solo sus ventas
            $query = "
            SELECT v.id_venta, v.total
            FROM ventas v
            WHERE v.id_usuario = ? AND DATE(v.fecha_venta) = ?
        ";
            $stmt = $db->prepare($query);
            $stmt->bind_param("is", $idUsuario, $hoy);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return $rol === 'admin'
                ? "Hoy ($hoy) no se han registrado ventas."
                : "No has registrado ventas hoy ($hoy).";
        }

        $texto = $rol === 'admin'
            ? "🗓️ Ventas registradas el $hoy:\n"
            : "🗓️ Tus ventas de hoy ($hoy):\n";

        while ($venta = $result->fetch_assoc()) {
            if ($rol === 'admin') {
                $texto .= "- Venta ID {$venta['id_venta']} por {$venta['nombre_usuario']}: S/.{$venta['total']}\n";
            } else {
                $texto .= "- Venta ID {$venta['id_venta']}: S/.{$venta['total']}\n";
            }
        }

        return $texto;
    }


    public function responderFecha()
    {
        $fecha = date('d \d\e F \d\e Y');
        $diaIngles = date('l');
        $dias = [
            'Monday' => 'lunes',
            'Tuesday' => 'martes',
            'Wednesday' => 'miércoles',
            'Thursday' => 'jueves',
            'Friday' => 'viernes',
            'Saturday' => 'sábado',
            'Sunday' => 'domingo'
        ];
        $dia = $dias[$diaIngles] ?? $diaIngles;

        return "Hoy es $dia, $fecha.";
    }


}
