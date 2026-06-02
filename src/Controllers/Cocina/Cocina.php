<?php
namespace Controllers\Cocina;

class Cocina extends \Controllers\PublicController
{
    public function run(): void
    {
        \Utilities\Nav::setNavContext();
        $pedidos = \Dao\PedidoDao::getAll();
        \Views\Renderer::render('cocina/cocina', ['pedidos' => $pedidos]);
    }
}