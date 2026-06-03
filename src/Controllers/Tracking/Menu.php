<?php
 
namespace Controllers\Tracking;
 
use Controllers\PrivateController;
use Dao\Tracking\Platos as PlatosDAO;
use Views\Renderer;
 
class Menu extends PrivateController
{
    private array $platos = [];
 
    public function run(): void
    {
        $this->requireAuth(true);
 
        $this->platos = PlatosDAO::getAll();
 
        foreach ($this->platos as &$plato) {
            $plato["platoDisponible"] = ($plato["stock"] > 0);
        }
 
        Renderer::render(
            "tracking/menu",
            ["platos" => $this->platos]
        );
    }
}
 