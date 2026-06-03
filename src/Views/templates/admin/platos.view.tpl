<section class="admin-page">
  <h1>Menú — stock y disponibilidad</h1>

  {{with mensaje}}
  <div class="admin-alert">{{mensaje}}</div>
  {{endwith mensaje}}

  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Plato</th>
          <th>Precio</th>
          <th>Stock</th>
          <th>Disponible</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        {{foreach platos}}
        <tr>
          <td>{{id}}</td>
          <td>{{nombre}}</td>
          <td>${{precio}}</td>
          <td>
            <form method="POST" action="index.php?page=Admin.GestionPlatos">
              <input type="hidden" name="accion" value="stock">
              <input type="hidden" name="id" value="{{id}}">
              <input type="number" name="stock" value="{{stock}}" min="0">
              <button type="submit" class="btn-sm">Guardar</button>
            </form>
          </td>
          <td>
            <span class="badge badge-{{disponible_texto}}">{{disponible_texto}}</span>
          </td>
          <td>
            <form method="POST" action="index.php?page=Admin.GestionPlatos">
              <input type="hidden" name="accion" value="toggle">
              <input type="hidden" name="id" value="{{id}}">
              <input type="hidden" name="disponible" value="{{disponible}}">
              <button type="submit" class="btn-sm {{disponible_btn_clase}}">{{disponible_btn_texto}}</button>
            </form>
          </td>
        </tr>
        {{endfor platos}}
      </tbody>
    </table>
  </div>

  <a href="index.php?page=Admin.Admin" class="admin-back">← Volver al panel</a>
</section>