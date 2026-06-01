<section class="menu-page">

<h1 class="menu-title">Menú del Restaurante</h1>

<div class="caps-table-topbar">
    <a href="index.php?page=Tracking_MisPedidos" class="btn-mis-pedidos">
        MIS PEDIDOS
    </a>
</div>

<div class="menu-grid">

    {{foreach platos}}

    <div class="menu-card">

        <h3>{{platoNombre}}</h3>

        <p>Disponibles: {{platoStock}}</p>

        {{if platoDisponible}}
        <form action="index.php?page=Tracking_Pedido" method="POST">
            <input type="hidden" name="platoId" value="{{platoId}}" />
            <input type="number" name="cantidad" min="1" max="{{platoStock}}" value="1" />
            <button type="submit">Realizar Pedido</button>
        </form>
        {{endif platoDisponible}}

        {{ifnot platoDisponible}}
        <strong>Agotado</strong>
        {{endifnot platoDisponible}}

    </div>

    {{endfor platos}}

</div>

</section>