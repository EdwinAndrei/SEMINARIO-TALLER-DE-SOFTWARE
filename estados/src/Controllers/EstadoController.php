<?php

namespace Controllers;

use Dao\EstadoDAO;
use Views\Renderer;
use Utilities\Site;

class EstadoController extends PublicController
{
    public function run(): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = (int) ($_POST["id"] ?? 0);
            $estado = $_POST["estado"] ?? "";
            $version = (int) ($_POST["version"] ?? 0);

            EstadoDAO::cambiarEstado($id, $estado, $version);

            Site::redirectTo("index.php?page=Estado");
        }

        $pedidos = EstadoDAO::obtenerPedidos();

        Renderer::render("estado", [
            "pedidos" => $pedidos
        ]);
    }
}