<?php

class PerfilController
{
    private $db;
    private $usuarioModel;

    public function __construct()
    {
        $this->db = Database::conectar();
        $this->usuarioModel = new UsuarioModel($this->db);
    }

    public function index()
    {
        session_start();
        $nombreUsuario = $_SESSION['nombre_usuario'] ?? 'Invitado';
        require_once '../app/vista/perfil/index.php';
    }

    public function apariencia()
    {
        require_once '../app/vista/perfil/apariencia.php';
    }
    public function guardarTema()
    {
        session_start();
        $tema = $_POST['tema'] ?? 'light'; // Valor por defecto

        if (in_array($tema, ['light', 'dark', 'system'])) {
            $_SESSION['tema'] = $tema;
        }

        header("Location: " . URL_BASE . "/perfil/apariencia");
        exit;
    }

}
