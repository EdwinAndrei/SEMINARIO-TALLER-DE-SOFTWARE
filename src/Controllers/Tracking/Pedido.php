<?php

namespace Controllers\Tracking;

use Controllers\PublicController;
use Dao\Tracking\Pedidos as PedidosDAO;
use Dao\Tracking\Platos as PlatosDAO;
use Utilities\Security;
use Utilities\Site;

class Pedido extends PublicController
{
    public function run(): void
    {
        if (!$this->isPostBack()) {
            Site::redirectTo(
                "index.php?page=Tracking_Menu"
            );
            return;
        }

        $platoId = intval(
            $_POST["platoId"] ?? 0
        );

        $cantidad = intval(
            $_POST["cantidad"] ?? 1
        );

        $usuario_id = Security::getUserId();

        if ($usuario_id <= 0) {
            $usuario_id = 3;
        }

        $plato = PlatosDAO::getById(
            $platoId
        );

        if (!$plato) {
            Site::redirectToWithMsg(
                "index.php?page=Tracking_Menu",
                "Plato no encontrado"
            );
            return;
        }

        if ($plato["stock"] < $cantidad) {
            Site::redirectToWithMsg(
                "index.php?page=Tracking_Menu",
                "Stock insuficiente"
            );
            return;
        }

        PedidosDAO::insertPedido(
            $usuario_id,
            $platoId,
            $cantidad
        );

        PlatosDAO::reducirStock(
            $platoId,
            $cantidad
        );

        Site::redirectToWithMsg(
            "index.php?page=Tracking_MisPedidos",
            "Pedido realizado correctamente"
        );
    }
}