<?php

class Database
{
    public static function conectar()
    {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($conn->connect_error) {
            error_log("Conexión fallida: " . $conn->connect_error);
            die("Error al conectar con la base de datos.");
        }

        $conn->set_charset('utf8mb4');

        return $conn;
    }
}
