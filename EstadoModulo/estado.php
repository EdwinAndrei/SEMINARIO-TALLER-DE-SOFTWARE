<?php
$pedidos = [
    ["id" => 1, "cliente_nombre" => "Juan Perez", "plato_nombre" => "Pizza", "cantidad" => 2, "estado" => "pendiente"],
    ["id" => 2, "cliente_nombre" => "Maria Lopez", "plato_nombre" => "Hamburguesa", "cantidad" => 1, "estado" => "en_proceso"],
    ["id" => 3, "cliente_nombre" => "Carlos Ruiz", "plato_nombre" => "Tacos", "cantidad" => 3, "estado" => "listo"],
    ["id" => 4, "cliente_nombre" => "Ana Martinez", "plato_nombre" => "Pollo Frito", "cantidad" => 2, "estado" => "pendiente"],
    ["id" => 5, "cliente_nombre" => "Luis Gomez", "plato_nombre" => "Nachos", "cantidad" => 1, "estado" => "en_proceso"],
    ["id" => 6, "cliente_nombre" => "Sofia Reyes", "plato_nombre" => "Burrito", "cantidad" => 4, "estado" => "listo"],
    ["id" => 7, "cliente_nombre" => "Pedro Santos", "plato_nombre" => "Hot Dog", "cantidad" => 2, "estado" => "pendiente"],
    ["id" => 8, "cliente_nombre" => "Karla Lopez", "plato_nombre" => "Hamburguesa Doble", "cantidad" => 1, "estado" => "en_proceso"]
];

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mensaje = "Estado actualizado correctamente. Esta es una demostracion visual.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modulo Estado de Pedidos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
        }
        .contenedor {
            background: white;
            padding: 25px;
            border-radius: 10px;
            max-width: 1000px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
        }
        h1 {
            text-align: center;
        }
        .mensaje {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 12px;
            margin-bottom: 20px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #180155;
            color: white;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        select, button {
            padding: 7px;
        }
        button {
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="contenedor">
    <h1>Modulo Estado de Pedidos</h1>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Plato</th>
                <th>Cantidad</th>
                <th>Estado actual</th>
                <th>Cambiar estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?php echo $pedido["id"]; ?></td>
                    <td><?php echo $pedido["cliente_nombre"]; ?></td>
                    <td><?php echo $pedido["plato_nombre"]; ?></td>
                    <td><?php echo $pedido["cantidad"]; ?></td>
                    <td><?php echo $pedido["estado"]; ?></td>
                    <td>
                        <form method="POST">
                            <select name="estado">
                                <option value="pendiente">Pendiente</option>
                                <option value="en_proceso">En proceso</option>
                                <option value="listo">Listo</option>
                                <option value="entregado">Entregado</option>
                            </select>
                            <button type="submit">Actualizar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
