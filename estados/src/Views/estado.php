<h1>Estado de Pedidos</h1>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Plato</th>
            <th>Cantidad</th>
            <th>Estado</th>
            <th>Cambiar Estado</th>
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
                    <form method="POST" action="index.php?page=Estado">
                        <input type="hidden" name="id" value="<?php echo $pedido["id"]; ?>">
                        <input type="hidden" name="version" value="<?php echo $pedido["version"]; ?>">

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