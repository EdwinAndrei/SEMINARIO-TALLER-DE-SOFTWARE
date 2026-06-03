<section>

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">

        <h1 style="font-family:'Playfair Display',serif; font-size:2rem;">
            Menú del Restaurante
        </h1>

        <a href="index.php?page=Tracking_MisPedidos"
            style="
                background:var(--green);
                color:white;
                text-decoration:none;
                padding:.7rem 1.25rem;
                border-radius:2rem;
                font-weight:700;
            ">
            Mis Pedidos
        </a>

    </div>

    <div style="overflow-x:auto;">

        <table style="
            width:100%;
            border-collapse:collapse;
            background:var(--bg-surface);
            border-radius:8px;
            overflow:hidden;
        ">

            <thead>
                <tr style="border-bottom:2px solid var(--tomato);">

                    <th style="padding:.75rem 1rem; text-align:left;">
                        Plato
                    </th>

                    <th style="padding:.75rem 1rem; text-align:left;">
                        Descripción
                    </th>

                    <th style="padding:.75rem 1rem; text-align:left;">
                        Precio
                    </th>

                    <th style="padding:.75rem 1rem; text-align:left;">
                        Stock
                    </th>

                    <th style="padding:.75rem 1rem; text-align:left;">
                        Pedido
                    </th>

                </tr>
            </thead>

            <tbody>

                {{foreach platos}}

                <tr style="border-bottom:1px solid var(--border);">

                    <td style="padding:.75rem 1rem; font-weight:600;">
                        {{nombre}}
                    </td>

                    <td style="padding:.75rem 1rem; color:var(--text-muted);">
                        {{descripcion}}
                    </td>

                    <td style="padding:.75rem 1rem;">
                        L. {{precio}}
                    </td>

                    <td style="padding:.75rem 1rem;">

                        {{if platoDisponible}}

                        <span style="
                            background:rgba(92,143,34,.15);
                            color:var(--green);
                            padding:.25rem .75rem;
                            border-radius:999px;
                            font-size:.85rem;
                            font-weight:600;
                        ">
                            {{stock}} disponibles
                        </span>

                        {{endif platoDisponible}}

                        {{ifnot platoDisponible}}

                        <span style="
                            background:rgba(235,94,48,.15);
                            color:var(--tomato);
                            padding:.25rem .75rem;
                            border-radius:999px;
                            font-size:.85rem;
                            font-weight:600;
                        ">
                            Agotado
                        </span>

                        {{endifnot platoDisponible}}

                    </td>

                    <td style="padding:.75rem 1rem;">

                        {{if platoDisponible}}

                        <form action="index.php?page=Tracking_Pedido"
                            method="POST"
                            style="
                                display:flex;
                                align-items:center;
                                gap:.5rem;
                            ">

                            <input type="hidden" name="platoId" value="{{id}}" />

                            <input type="number"  name="cantidad" min="1" max="{{stock}}"value="1" style="
                            width:75px; margin:0; background:#2a2a2a; color:#f5f0e8; border:1px solid #444; border-radius:6px; padding:.35rem .5rem; text-align:center;"
                            />

                            <button type="submit" style="margin:0;" >Realizar Pedido</button>

                        </form>

                        {{endif platoDisponible}}

                    </td>

                </tr>

                {{endfor platos}}

            </tbody>

        </table>

    </div>

</section>