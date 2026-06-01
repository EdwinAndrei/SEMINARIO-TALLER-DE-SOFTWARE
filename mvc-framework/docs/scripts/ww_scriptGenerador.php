<?php

/**
 * Generador CRUD completo para la tabla peliculas
 * Ejecutar con:
 * php docs/scripts/ww_scriptGenerador.php
 */

$tabla = "peliculas";
$Clase = "Peliculas";

// ==========================
// CONFIGURACIÓN DB
// ==========================
$host = "host.docker.internal";
$db   = "ecommerce";
$user = "ecommerce";
$pass = "ecommerce";
$port = 3306;

try {
    $conn = new PDO(
        "mysql:host=$host;port=$port;dbname=$db;charset=utf8",
        $user,
        $pass
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}

// ==========================
// OBTENER ESTRUCTURA TABLA
// ==========================
$stmt = $conn->query("DESC $tabla");
$columnas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pk = "";
$fields = [];

foreach ($columnas as $col) {
    if ($col["Key"] === "PRI") $pk = $col["Field"];
    $fields[] = $col["Field"];
}

if (!$pk) {
    echo "No se encontró clave primaria\n";
    exit;
}

// ==========================
// GENERAR DAO
// ==========================
$daoPath = __DIR__ . "/../../src/Dao/Mantenimientos/{$Clase}.php";

$dao = "<?php
namespace Dao\\Mantenimientos;

use Dao\\Table;

class {$Clase} extends Table {

    public static function getAll(): array {
        \$sql = 'SELECT * FROM {$tabla};';
        return self::obtenerRegistros(\$sql, []);
    }

    public static function getById(\$id): array {
        \$sql = 'SELECT * FROM {$tabla} WHERE {$pk} = :id;';
        return self::obtenerUnRegistro(\$sql, ['id'=>\$id]);
    }

    public static function crear(";

foreach ($fields as $f) {
    if ($f !== $pk) $dao .= '$' . $f . ', ';
}
$dao = rtrim($dao, ', ');
$dao .= "): int {\n";
$cols = '';
$params = '';
foreach ($fields as $f) if ($f !== $pk) {
    $cols .= $f . ', ';
    $params .= ':' . $f . ', ';
}
$cols = rtrim($cols, ', ');
$params = rtrim($params, ', ');
$dao .= "        \$sql = 'INSERT INTO {$tabla} ({$cols}) VALUES ({$params});';\n";
$dao .= "        return self::executeNonQuery(\$sql, [";
foreach ($fields as $f) if ($f !== $pk) $dao .= "'$f' => \$$f, ";
$dao = rtrim($dao, ', ');
$dao .= "]);\n    }\n";

$dao .= "    public static function actualizar(\$$pk";
foreach ($fields as $f) if ($f !== $pk) $dao .= ", \$$f";
$dao .= "): int {\n";
$dao .= "        \$sql = 'UPDATE {$tabla} SET ";
foreach ($fields as $f) if ($f !== $pk) $dao .= "$f = :$f, ";
$dao = rtrim($dao, ', ');
$dao .= " WHERE $pk = :$pk;';\n";
$dao .= "        return self::executeNonQuery(\$sql, [";
foreach ($fields as $f) $dao .= "'$f' => \$$f, ";
$dao = rtrim($dao, ', ');
$dao .= "]);\n    }\n";

$dao .= "    public static function eliminar(\$$pk): int {\n";
$dao .= "        \$sql = 'DELETE FROM {$tabla} WHERE $pk = :$pk;';\n";
$dao .= "        return self::executeNonQuery(\$sql, ['$pk' => \$$pk]);\n    }\n";

$dao .= "}\n";

@mkdir(dirname($daoPath), 0777, true);
file_put_contents($daoPath, $dao);

// ==========================
// CONTROLADOR LISTADO
// ==========================
$ctrlListPath = __DIR__ . "/../../src/Controllers/Mantenimientos/{$Clase}/Listado.php";

$ctrlList = "<?php
namespace Controllers\\Mantenimientos\\{$Clase};

use Controllers\\PublicController;
use Dao\\Mantenimientos\\{$Clase} as {$Clase}DAO;
use Views\\Renderer;

class Listado extends PublicController {
    public function run(): void {
        \$viewData = [];
        \$viewData['records'] = {$Clase}DAO::getAll();

        // Si necesitas transformar campos, hazlo así:
        foreach (\$viewData['records'] as &\$rec) {
            // Ejemplo:
            // if (\$rec['genero'] === 'ACC') \$rec['genero'] = 'Acción';
        }

        Renderer::render('mantenimientos/{$tabla}/listado', \$viewData);
    }
}
";

@mkdir(dirname($ctrlListPath), 0777, true);
file_put_contents($ctrlListPath, $ctrlList);

// ==========================
// CONTROLADOR FORMULARIO
// ==========================
$ctrlFormPath = __DIR__ . "/../../src/Controllers/Mantenimientos/{$Clase}/Formulario.php";

$ctrlForm = "<?php
namespace Controllers\\Mantenimientos\\{$Clase};

use Controllers\\PublicController;
use Views\\Renderer;
use Dao\\Mantenimientos\\{$Clase} as {$Clase}DAO;
use Utilities\\Site;

const {$Clase}_FORMULARIO_URL = 'index.php?page=Mantenimientos-{$Clase}-Formulario';
const {$Clase}_LISTADO_URL = 'index.php?page=Mantenimientos-{$Clase}-Listado';
const XSRF_KEY = 'Mantenimientos_{$Clase}_Formulario';

class Formulario extends PublicController {

    private array \$viewData = [];
    private array \$modes = [
        'INS' => 'Nuevo {$Clase}',
        'UPD' => 'Actualizar %s',
        'DSP' => 'Detalle de %s',
        'DEL' => 'Eliminando %s'
    ];
    private \$mode;
    private \$xsrfToken = '';
";

foreach ($fields as $f) $ctrlForm .= "    private \$$f;\n";

$ctrlForm .= "
    public function run(): void {
        \$this->LoadPage();
        if (\$this->isPostBack()) {
            \$this->CapturarDatos();
            if (\$this->ValidarDatos()) {
                switch (\$this->mode) {
                    case 'INS':
                        if ({$Clase}DAO::crear(";
foreach ($fields as $f) if ($f !== $pk) $ctrlForm .= "\$this->$f, ";
$ctrlForm = rtrim($ctrlForm, ', ');
$ctrlForm .= ") !== 0) {
                            Site::redirectToWithMsg({$Clase}_LISTADO_URL, 'Registro creado satisfactoriamente');
                        }
                        break;
                    case 'UPD':
                        if ({$Clase}DAO::actualizar(\$this->$pk, ";
foreach ($fields as $f) if ($f !== $pk) $ctrlForm .= "\$this->$f, ";
$ctrlForm = rtrim($ctrlForm, ', ');
$ctrlForm .= ") !== 0) {
                            Site::redirectToWithMsg({$Clase}_LISTADO_URL, 'Registro actualizado satisfactoriamente');
                        }
                        break;
                    case 'DEL':
                        if ({$Clase}DAO::eliminar(\$this->$pk) !== 0) {
                            Site::redirectToWithMsg({$Clase}_LISTADO_URL, 'Registro eliminado satisfactoriamente');
                        }
                        break;
                }
            }
        }
        \$this->GenerarViewData();
        Renderer::render('mantenimientos/{$tabla}/formulario', \$this->viewData);
    }

    private function LoadPage() {
        \$this->mode = \$_GET['mode'] ?? 'INS';
        if (!isset(\$this->modes[\$this->mode])) {
            Site::redirectToWithMsg({$Clase}_LISTADO_URL, 'Error al cargar formulario');
        }
        \$this->$pk = intval(\$_GET['id'] ?? 0);
        if (\$this->mode !== 'INS' && \$this->$pk <= 0) {
            Site::redirectToWithMsg({$Clase}_LISTADO_URL, 'Se requiere Id');
        } elseif (\$this->mode !== 'INS') {
            \$this->CargarDatos();
        }
    }

    private function CargarDatos() {
        \$tmp = {$Clase}DAO::getById(\$this->$pk);
        if (count(\$tmp) <= 0) {
            Site::redirectToWithMsg({$Clase}_LISTADO_URL, 'No se encontró registro');
        }
";

foreach ($fields as $f) $ctrlForm .= "        \$this->$f = \$tmp['$f'];\n";

$ctrlForm .= "
    }

    private function CapturarDatos() {
";
foreach ($fields as $f) $ctrlForm .= "        \$this->$f = \$_POST['$f'] ?? '';\n";
$ctrlForm .= "        \$this->xsrfToken = \$_POST['uuid'] ?? '';\n    }\n";

$ctrlForm .= "
    private function ValidarDatos(): bool {
        if (\$this->xsrfToken !== (\$_SESSION[XSRF_KEY] ?? '')) {
            Site::redirectToWithMsg({$Clase}_LISTADO_URL, 'Error de seguridad');
        }
        if (\$this->mode === 'INS') return true;
        return intval(\$this->$pk) > 0;
    }

    private function GenerarViewData() {
        \$isReadOnly = in_array(\$this->mode, ['DSP','DEL']);
        \$showConfirm = (\$this->mode !== 'DSP');
        \$readonlyCod = (\$this->mode !== 'INS');

        \$this->viewData['mode'] = \$this->mode;
        \$this->viewData['modeDsc'] = sprintf(\$this->modes[\$this->mode], \$this->$pk);
";

foreach ($fields as $f) $ctrlForm .= "        \$this->viewData['$f'] = \$this->$f;\n";

$ctrlForm .= "
        \$this->viewData['readonly'] = \$isReadOnly;
        \$this->viewData['readonlyCod'] = \$readonlyCod;
        \$this->viewData['showConfirm'] = \$showConfirm;
        \$this->viewData['xsrf_token'] = \$this->GenerateXSRFToken();
    }

    private function GenerateXSRFToken(): string {
        \$tmpStr = '$Clase' . time() . rand(10000,99999);
        \$this->xsrfToken = md5(\$tmpStr);
        \$_SESSION[XSRF_KEY] = \$this->xsrfToken;
        return \$this->xsrfToken;
    }
}
";

@mkdir(dirname($ctrlFormPath), 0777, true);
file_put_contents($ctrlFormPath, $ctrlForm);

// ==========================
// VISTAS
// ==========================

// Listado
$viewListPath = __DIR__ . "/../../src/Views/templates/mantenimientos/{$tabla}/listado.view.tpl";

// Cabecera de la tabla
$thead = '';
foreach ($fields as $f) {
    $label = ucfirst(str_replace('_', ' ', $f));
    $thead .= "<th>$label</th>\n";
}

// Filas de la tabla
$tbody = '';
foreach ($fields as $f) {
    $tbody .= "<td>{{" . $f . "}}</td>\n";
}

$viewList = <<<HTML
<h1>Listado {$Clase}</h1>
<section class="container">
    <table>
        <thead>
            <tr>
$thead
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            {{foreach records}}
            <tr>
$tbody
                <td>
                    <a href="index.php?page=Mantenimientos-{$Clase}-Formulario&mode=DSP&id={{{$pk}}}">Ver</a>
                    <br />
                    <a href="index.php?page=Mantenimientos-{$Clase}-Formulario&mode=UPD&id={{{$pk}}}">Editar</a>
                    <br />
                    <a href="index.php?page=Mantenimientos-{$Clase}-Formulario&mode=DEL&id={{{$pk}}}">Eliminar</a>
                </td>
            </tr>
            {{endfor records}}
        </tbody>
    </table>
    <br>
    <a href="index.php?page=Mantenimientos-{$Clase}-Formulario&mode=INS&id=0">Nuevo Registro</a>
</section>
HTML;

@mkdir(dirname($viewListPath), 0777, true);
file_put_contents($viewListPath, $viewList);


// ==========================
// VISTA FORMULARIO WW
// ==========================
$viewFormPath = __DIR__ . "/../../src/Views/templates/mantenimientos/{$tabla}/formulario.view.tpl";

$form = <<<HTML
<h1>{{modeDsc}}</h1>
<section class="grid row">
    <form class="depth-0 offset-3 col-6"
        action="index.php?page=Mantenimientos-Peliculas-Formulario&mode={{mode}}&id={{peliculaId}}" method="POST">

        <div class="row my-3 align-center">
            <div class="col-4"><label for="id">ID</label></div>
            <div class="col-8">
                <input type="text" id="peliculaId" value="{{peliculaId}}" disabled/>
                <input type="hidden" name="peliculaId" value="{{peliculaId}}" />
                <input type="hidden" name="uuid" value="{{xsrf_token}}" />
            </div>
        </div>
HTML;

// Campos dinámicos
foreach ($fields as $f) {
    if ($f === $pk) continue;
    $label = ucfirst(str_replace('_', ' ', $f));
    $form .= <<<HTML

        <div class="row my-3 align-center">
            <div class="col-4"><label for="{$f}">{$label}</label></div>
            <div class="col-8">
                <input type="text" name="{$f}" id="{$f}" value="{{{$f}}}" placeholder="{$label}" required {{if ~readonly}} readonly disabled {{endif ~readonly}} />
            </div>
        </div>
HTML;
}

$form .= <<<HTML

        <div class="row my-4 right">
            {{if showConfirm}}
            <button type="submit" name="btnEnviar">Confirmar</button>
            {{endif showConfirm}}
            &nbsp;
            <button id="btnCancelar">Cancelar</button>
        </div>
    </form>
</section>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.getElementById("btnCancelar").addEventListener("click", e => {
            e.preventDefault();
            window.location.assign("index.php?page=Mantenimientos-{$Clase}-Listado");
        });
    });
</script>
HTML;

@mkdir(dirname($viewFormPath), 0777, true);
file_put_contents($viewFormPath, $form);

echo "CRUD completo generado para la tabla $tabla \n";
