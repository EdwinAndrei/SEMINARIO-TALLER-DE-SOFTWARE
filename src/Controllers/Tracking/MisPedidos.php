<?php
 
namespace Controllers\Tracking;
 
use Controllers\PublicController;
use Dao\Tracking\Pedidos as PedidosDAO;
use Utilities\Security;
use Utilities\Site;
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
 
        Site::addLink('public/css/style.css');
 
        Renderer::render(
            "tracking/mispedidos",
            ["pedidos" => $this->pedidos]
        );
    }
}