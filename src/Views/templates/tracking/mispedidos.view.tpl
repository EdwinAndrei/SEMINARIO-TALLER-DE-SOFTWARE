<h1>Mis Pedidos</h1>

<section class="WWList">

    <table class="caps-products-table">

        <thead>
            <tr>
                <th>Acción</th>
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
                <td>
                    {{if puedeCancelar}}
                    <form action="index.php?page=Tracking_CancelarPedido" method="POST">
                        <input type="hidden" name="pedidoId" value="{{pedidoId}}" />

                        <button type="submit">
                            Cancelar
                        </button>
                    </form>
                    {{endif puedeCancelar}}
                </td>

                <td>{{pedidoId}}</td>

                <td>{{platoNombre}}</td>

                <td>{{cantidad}}</td>

                <td class="{{estadoClass}}">
                    {{pedidoEstadoDsc}}
                </td>

                <td>{{pedidoFecha}}</td>

            </tr>

            {{endfor pedidos}}

        </tbody>

    </table>


    <div class="row my-4 flex-end">
        <button type="button" id="btnRegresar" class="caps-secondary-btn">
            Regresar
        </button>
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