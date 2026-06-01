<?php

namespace Controllers\Tracking;

use Controllers\PublicController;
use Dao\Tracking\Platos as PlatosDAO;
use Views\Renderer;

class Menu extends PublicController
{
    private array $platos = [];

    public function run(): void
    {
        $this->platos = PlatosDAO::getAll();

        foreach ($this->platos as &$plato) {
            $plato["platoDisponible"] = ($plato["platoStock"] > 0);
        }

        Renderer::render(
            "tracking/menu",
            [
                "platos" => $this->platos
            ]
        );
    }
}
