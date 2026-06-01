<?php

namespace Controllers\Tracking;

use Controllers\PrivateController;
use Dao\Tracking\Pedidos as PedidosDAO;
use Dao\Tracking\Platos as PlatosDAO;
use Utilities\Security;
use Utilities\Site;

class Pedido extends PrivateController
{
    public function run(): void
    {
        if (!$this->isPostBack()) {
            Site::redirectTo("index.php?page=Tracking_Menu");
        }

        $platoId = intval($_POST["platoId"] ?? 0);
        $cantidad = intval($_POST["cantidad"] ?? 1);

        $usercod = Security::getUserId();

        if ($platoId <= 0 || $cantidad <= 0) {
            Site::redirectToWithMsg(
                "index.php?page=Tracking_Menu",
                "Datos inválidos."
            );
        }


        PlatosDAO::reducirStock(
            $platoId,
            $cantidad
        );

        PedidosDAO::insertPedido(
            $usercod,
            $platoId,
            $cantidad
        );

        Site::redirectToWithMsg(
            "index.php?page=Tracking_Menu",
            "Pedido realizado correctamente."
        );
    }
}
