<?php
// app/modelo/Database.php


class Database
{
    public static function conectar()
    {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($conn->connect_error) {
            // Mejor manejo de errores (no muestres detalles en producción)
            error_log("Conexión fallida: " . $conn->connect_error);
            die("❌ Error al conectar con la base de datos.");
        }

        // Opcional: Configurar charset y modo de errores
        $conn->set_charset('utf8mb4');

        return $conn;
    }
}
