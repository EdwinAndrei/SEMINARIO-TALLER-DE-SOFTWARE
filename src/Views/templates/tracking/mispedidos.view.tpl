<section class="pedidos-page">

    <h1>Mis Pedidos</h1>

    <table class="caps-products-table">

        <thead>
            <tr>
                <th>ID</th>
                <th>Plato</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Acción</th>
            </tr>
        </thead>

        <tbody>

            {{foreach pedidos}}

            <tr>

                <td>{{id}}</td>

                <td>{{nombre}}</td>

                <td>{{cantidad}}</td>

                <td>L. {{precio}}</td>
                
                <td>L. {{total}}</td>

                <td class="{{estadoClass}}">
                    {{estadoDsc}}
                </td>

                <td>{{creado_en}}</td>

                <td>

                    {{if puedeCancelar}}

                    <form action="index.php?page=Tracking_CancelarPedido" method="POST">

                        <input type="hidden" name="pedidoId" value="{{id}}" />
                        <button type="submit">Cancelar</button>

                    </form>

                    {{endif puedeCancelar}}

                </td>

            </tr>

            {{endfor pedidos}}

        </tbody>

    </table>

    <div class="row my-4 flex-end">

        <button type="button" id="btnRegresar" class="caps-secondary-btn">Volver al Menú </button>

    </div>

</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("btnRegresar")
        .addEventListener("click", () => {
            window.location.assign(
                "index.php?page=Tracking_Menu"
            );
        });
});
</script>