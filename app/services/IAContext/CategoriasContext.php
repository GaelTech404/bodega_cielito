<?php

class CategoriasContext
{
    public static function generar(mysqli $db, array $usuario): string
    {
        $categoriaModel = new CategoriaModel($db);
        $categorias = $categoriaModel->obtenerTodas();

        if (empty($categorias)) {
            return "📁 No hay categorías registradas actualmente.";
        }

        $resumen = array_map(fn($cat) => $cat['nombre'], $categorias);

        return "📁 Categorías disponibles en la bodega: " . implode(', ', $resumen);
    }
}
