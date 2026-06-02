<?php

namespace Controllers\Tracking;

use Controllers\PublicController;
use Dao\Tracking\Pedidos as PedidosDAO;
use Dao\Tracking\Platos as PlatosDAO;
use Utilities\Site;

class CancelarPedido extends PublicController
{
    public function run(): void
    {
        if (!$this->isPostBack()) {
            Site::redirectTo("index.php?page=Tracking_MisPedidos");
            return;
        }

        $pedidoId = intval($_POST["pedidoId"] ?? 0);

        if ($pedidoId <= 0) {
            Site::redirectToWithMsg(
                "index.php?page=Tracking_MisPedidos",
                "Pedido inválido"
            );
            return;
        }

        // 1. Obtener pedido
        $pedido = PedidosDAO::getPedidoById($pedidoId);

        if (!$pedido || $pedido["pedidoEstado"] !== "PEN") {
            Site::redirectToWithMsg(
                "index.php?page=Tracking_MisPedidos",
                "No se puede cancelar este pedido"
            );
            return;
        }

        // 2. Cambiar estado a cancelado
        PedidosDAO::cancelarPedido($pedidoId);

        // 3. Devolver stock al plato
        PlatosDAO::aumentarStock(
            $pedido["platoId"],
            $pedido["cantidad"]   // ✔ ahora es correcto
        );

        Site::redirectToWithMsg(
            "index.php?page=Tracking_MisPedidos",
            "Pedido cancelado y stock devuelto"
        );
    }
}
