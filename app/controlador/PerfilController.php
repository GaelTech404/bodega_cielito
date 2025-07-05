<?php

class PerfilController
{
    private $db;
    private $model;

    public function __construct()
    {
        $this->db = Database::conectar();
        $this->model = new UsuarioModel($this->db);
    }

    public function index()
    {
        ViewHelper::render('perfil/index');

    }

    public function apariencia()
    {
        require_once '../app/vista/perfil/apariencia.php';
    }
    public function guardarTema()
    {
        $tema = $_POST['tema'] ?? 'light'; // Valor por defecto

        if (in_array($tema, ['light', 'dark', 'system'])) {
            $_SESSION['tema'] = $tema;
        }

        header("Location: " . URL_BASE . "/perfil/apariencia");
        exit;
    }

}
