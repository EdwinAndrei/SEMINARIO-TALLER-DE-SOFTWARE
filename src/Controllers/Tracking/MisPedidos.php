<?php
 
namespace Controllers\Tracking;
 
use Controllers\PrivateController;
use Dao\Tracking\Pedidos as PedidosDAO;
use Utilities\Security;
use Views\Renderer;
 
class MisPedidos extends PrivateController
{
    private array $pedidos = [];
 
    public function run(): void
    {
        $this->requireAuth(true);
 
        $usuario_id = Security::getUserId();
 
        $this->pedidos = PedidosDAO::getPedidosByUser($usuario_id);
 
        foreach ($this->pedidos as &$pedido) {
            $pedido["total"] = number_format(
                (float)$pedido["cantidad"] * (float)$pedido["precio"], 2
            );
 
            switch ($pedido["estado"]) {
                case "pendiente":
                    $pedido["estadoDsc"]     = "Pendiente";
                    $pedido["estadoClass"]   = "estado-pendiente";
                    $pedido["puedeCancelar"] = true;
                    break;
                case "en_proceso":
                    $pedido["estadoDsc"]     = "En Proceso";
                    $pedido["estadoClass"]   = "estado-proceso";
                    $pedido["puedeCancelar"] = false;
                    break;
                case "listo":
                    $pedido["estadoDsc"]     = "Listo";
                    $pedido["estadoClass"]   = "estado-listo";
                    $pedido["puedeCancelar"] = false;
                    break;
                case "entregado":
                    $pedido["estadoDsc"]     = "Entregado";
                    $pedido["estadoClass"]   = "estado-entregado";
                    $pedido["puedeCancelar"] = false;
                    break;
                case "cancelado":
                    $pedido["estadoDsc"]     = "Cancelado";
                    $pedido["estadoClass"]   = "estado-cancelado";
                    $pedido["puedeCancelar"] = false;
                    break;
                default:
                    $pedido["estadoDsc"]     = $pedido["estado"];
                    $pedido["estadoClass"]   = "";
                    $pedido["puedeCancelar"] = false;
            }
        }
 
        Renderer::render(
            "tracking/mispedidos",
            ["pedidos" => $this->pedidos]
        );
    }
}
 