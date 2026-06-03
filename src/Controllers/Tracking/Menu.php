<?php
 
namespace Controllers\Tracking;
 
use Controllers\PublicController;
use Dao\Tracking\Platos as PlatosDAO;
use Utilities\Site;
use Views\Renderer;
 
class Menu extends PublicController
{
    private array $platos = [];
 
    public function run(): void
    {
        $this->platos = PlatosDAO::getAll();
 
        foreach ($this->platos as &$plato) {
            $plato["platoDisponible"] = ($plato["stock"] > 0);
        }
 
        Site::addLink('public/css/style.css');
 
        Renderer::render(
            "tracking/menu",
            ["platos" => $this->platos]
        );
    }
}
 