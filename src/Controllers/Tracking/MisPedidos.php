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
        if ($usercod <= 0) {
            $usercod = 1; // ID del "Cliente Demo"
        }

        $this->pedidos = PedidosDAO::getPedidosByUser($usercod);

        foreach ($this->pedidos as &$pedido) {

            switch ($pedido["pedidoEstado"]) {

                case "PEN":
                    $pedido["pedidoEstadoDsc"] = "Pendiente";
                    $pedido["estadoClass"] = "estado-pendiente";
                    $pedido["puedeCancelar"] = true;
                    break;

                case "PRO":
                    $pedido["pedidoEstadoDsc"] = "En Proceso";
                    $pedido["estadoClass"] = "estado-proceso";
                    $pedido["puedeCancelar"] = false;
                    break;

                case "LIS":
                    $pedido["pedidoEstadoDsc"] = "Listo";
                    $pedido["estadoClass"] = "estado-listo";
                    $pedido["puedeCancelar"] = false;
                    break;

                case "ENT":
                    $pedido["pedidoEstadoDsc"] = "Entregado";
                    $pedido["estadoClass"] = "estado-entregado";
                    $pedido["puedeCancelar"] = false;
                    break;

                case "CAN":
                    $pedido["pedidoEstadoDsc"] = "Cancelado";
                    $pedido["estadoClass"] = "estado-cancelado";
                    $pedido["puedeCancelar"] = false;
                    break;

                default:
                    $pedido["pedidoEstadoDsc"] = $pedido["pedidoEstado"];
                    $pedido["puedeCancelar"] = false;
            }
        }

        $pedido["puedeCancelar"] = ($pedido["pedidoEstado"] === "PEN");

        Renderer::render(
            "tracking/mispedidos",
            [
                "pedidos" => $this->pedidos
            ]
        );
    }
}
