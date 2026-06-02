<?php
namespace Controllers\Cocina;

class ActualizarEstado extends \Controllers\PublicController
{
    public function run(): void
    {
        $id      = (int) ($_POST['id']      ?? 0);
        $version = (int) ($_POST['version'] ?? 0);
        $estado  = $_POST['estado'] ?? '';

        $estados = ['pendiente', 'en_proceso', 'listo', 'entregado'];
        $idx     = array_search($estado, $estados);
        $siguiente = $estados[$idx + 1] ?? 'entregado';

        $ok = \Dao\PedidoDao::actualizarEstado($id, $siguiente, $version);

        if (!$ok) {
            // Conflicto de concurrencia
            \Utilities\Site::redirectTo('index.php?page=Cocina.Cocina&error=conflicto');
        } else {
            \Utilities\Site::redirectTo('index.php?page=Cocina.Cocina');
        }
    }
}