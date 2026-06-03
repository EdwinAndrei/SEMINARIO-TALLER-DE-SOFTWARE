<?php
namespace Controllers\Admin;

class GestionPlatos extends \Controllers\PrivateController
{
    public function run(): void
    {
        $this->requireAuth(\Utilities\Security::getUserRole() === 'admin');

        $mensaje = '';

        if ($this->isPostBack()) {
            $accion = $_POST['accion'] ?? '';
            $id     = (int)($_POST['id'] ?? 0);

            if ($accion === 'toggle' && $id > 0) {
                $disponible = (int)($_POST['disponible'] ?? 0);
                \Dao\AdminDao::toggleDisponible($id, $disponible);
                $mensaje = 'Disponibilidad actualizada.';
            } elseif ($accion === 'stock' && $id > 0) {
                $stock = (int)($_POST['stock'] ?? 0);
                \Dao\AdminDao::actualizarStock($id, $stock);
                $mensaje = 'Stock actualizado.';
            }
        }

        $platos = \Dao\AdminDao::getAllPlatos();

        foreach ($platos as &$plato) {
            $plato['disponible_texto']     = $plato['disponible'] ? 'si' : 'no';
            $plato['disponible_btn_texto'] = $plato['disponible'] ? 'Deshabilitar' : 'Habilitar';
            $plato['disponible_btn_clase'] = $plato['disponible'] ? '' : 'btn-success';
        }
        unset($plato);

        \Utilities\Site::addLink('public/css/admin.css');
        \Views\Renderer::render('admin/platos', ['platos' => $platos, 'mensaje' => $mensaje]);
    }
}