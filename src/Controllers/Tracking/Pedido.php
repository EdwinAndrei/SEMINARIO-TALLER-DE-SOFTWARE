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
            Site::redirectTo("index.php?page=Tracking_Menu");
            return;
        }

        $platoId = intval($_POST["platoId"] ?? 0);
        $cantidad = intval($_POST["cantidad"] ?? 1);

        $usercod = Security::getUserId();

        if ($usercod <= 0) {
            $usercod = 1; // ID del "Cliente Demo"
        }

        if ($platoId <= 0 || $cantidad <= 0) {
            Site::redirectToWithMsg(
                "index.php?page=Tracking_Menu",
                "Datos inválidos."
            );
            return;
        }

        // 1. Validar stock primero
        $plato = PlatosDAO::getById($platoId);

        if (!$plato || $plato["platoStock"] < $cantidad) {
            Site::redirectToWithMsg(
                "index.php?page=Tracking_Menu",
                "No hay suficiente stock."
            );
            return;
        }

        // 2. Crear pedido
        PedidosDAO::insertPedido($usercod);

        // 3. Obtener ID del pedido
        $pedidoId = PedidosDAO::getLastInsertId();

        // 4. Insertar detalle
        PedidosDAO::insertDetallePedido(
            $pedidoId,
            $platoId,
            $cantidad,
            $plato["platoPrecio"]
        );

        // 5. Descontar stock
        PlatosDAO::reducirStock($platoId, $cantidad);

        Site::redirectToWithMsg(
            "index.php?page=Tracking_MisPedidos",
            "Pedido realizado correctamente."
        );
    }
}
