<?php
require_once __DIR__ . '/../config/config.php'; 
class IAContextService
{
    private $db;
    private $usuario;

    public function __construct(mysqli $db, array $usuario)
    {
        $this->db = $db;
        $this->usuario = $usuario;
        
    }

    public function generarContexto(): string
    {
        $contextClasses = [
            UsuarioContext::class,
            VentasContext::class,
            ComprasContext::class,
            ProductosContext::class,
            ProveedoresContext::class,
            CategoriasContext::class
        ];

        $partes = [];

        foreach ($contextClasses as $class) {
            if (class_exists($class) && method_exists($class, 'generar')) {
                $partes[] = $class::generar($this->db, $this->usuario);
            }
        }

        return implode("\n\n", array_filter($partes));
    }


}
