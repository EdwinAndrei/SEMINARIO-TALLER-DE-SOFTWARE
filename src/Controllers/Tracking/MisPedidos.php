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
        $usuario_id = Security::getUserId();

        if ($usuario_id <= 0) {
            $usuario_id = 3;
        }

        $this->pedidos = PedidosDAO::getPedidosByUser(
            $usuario_id
        );

        foreach ($this->pedidos as &$pedido) {

            switch ($pedido["estado"]) {

                case "PEN":
                    $pedido["estadoDsc"] = "Pendiente";
                    $pedido["estadoClass"] = "estado-pendiente";
                    $pedido["puedeCancelar"] = true;
                    break;

                case "PRO":
                    $pedido["estadoDsc"] = "En Proceso";
                    $pedido["estadoClass"] = "estado-proceso";
                    $pedido["puedeCancelar"] = false;
                    break;

                case "LIS":
                    $pedido["estadoDsc"] = "Listo";
                    $pedido["estadoClass"] = "estado-listo";
                    $pedido["puedeCancelar"] = false;
                    break;

                case "ENT":
                    $pedido["estadoDsc"] = "Entregado";
                    $pedido["estadoClass"] = "estado-entregado";
                    $pedido["puedeCancelar"] = false;
                    break;

                case "CAN":
                    $pedido["estadoDsc"] = "Cancelado";
                    $pedido["estadoClass"] = "estado-cancelado";
                    $pedido["puedeCancelar"] = false;
                    break;
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