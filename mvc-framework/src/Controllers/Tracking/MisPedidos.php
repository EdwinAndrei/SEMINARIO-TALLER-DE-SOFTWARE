<?php

namespace Controllers\Tracking;

use Controllers\PublicController;
use Dao\Tracking\Pedidos as PedidosDAO;
use Utilities\Security;
use Views\Renderer;

class MisPedidos extends PublicController
{
    private array $pedidos = [];

    public function run(): void
    {
        $usercod = Security::getUserId();

        $this->pedidos = PedidosDAO::getPedidosByUser($usercod);

        foreach ($this->pedidos as &$pedido) {

            switch ($pedido["pedidoEstado"]) {

                case "pendiente":
                    $pedido["pedidoEstadoDsc"] = "Pendiente";
                    break;

                case "en_proceso":
                    $pedido["pedidoEstadoDsc"] = "En Proceso";
                    break;

                case "listo":
                    $pedido["pedidoEstadoDsc"] = "Listo";
                    break;

                case "entregado":
                    $pedido["pedidoEstadoDsc"] = "Entregado";
                    break;

                case "cancelado":
                    $pedido["pedidoEstadoDsc"] = "Cancelado";
                    break;

                default:
                    $pedido["pedidoEstadoDsc"] = $pedido["pedidoEstado"];
            }
        }

        Renderer::render(
            "tracking/mispedidos",
            [
                "pedidos" => $this->pedidos
            ]
        );
    }
}
