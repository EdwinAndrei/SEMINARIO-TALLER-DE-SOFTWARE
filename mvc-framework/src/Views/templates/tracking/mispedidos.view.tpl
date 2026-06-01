<h1>Mis Pedidos</h1>

<section class="WWList">

<table class="caps-products-table">

    <thead>
        <tr>
            <th>ID</th>
            <th>Plato</th>
            <th>Cantidad</th>
            <th>Estado</th>
            <th>Fecha</th>
        </tr>
    </thead>

    <tbody>

        {{foreach pedidos}}

        <tr>

            <td>{{pedidoId}}</td>

            <td>{{platoNombre}}</td>

            <td>{{pedidoCantidad}}</td>

            <td>{{pedidoEstadoDsc}}</td>

            <td>{{pedidoFecha}}</td>

        </tr>

        {{endfor pedidos}}

    </tbody>

</table>

</section>