<section class="admin-page">
  <h1>Panel de administración</h1>

  <div class="kpi-grid">
    <div class="kpi-card">
      <div class="kpi-label">Total pedidos</div>
      <div class="kpi-value">{{totalPedidos}}</div>
    </div>
    <div class="kpi-card warn">
      <div class="kpi-label">Pendientes</div>
      <div class="kpi-value">{{pendientes}}</div>
    </div>
    <div class="kpi-card">
      <div class="kpi-label">En proceso</div>
      <div class="kpi-value">{{enProceso}}</div>
    </div>
    <div class="kpi-card ok">
      <div class="kpi-label">Listos</div>
      <div class="kpi-value">{{listos}}</div>
    </div>
    <div class="kpi-card">
      <div class="kpi-label">Clientes registrados</div>
      <div class="kpi-value">{{totalClientes}}</div>
    </div>
    <div class="kpi-card warn">
      <div class="kpi-label">Platos stock bajo</div>
      <div class="kpi-value">{{stockBajo}}</div>
    </div>
  </div>

  <div class="admin-card-grid">
    <a href="index.php?page=Admin.GestionUsuarios" class="admin-card">
      <i class="fas fa-users"></i>
      <div class="admin-card-title">Gestión de usuarios</div>
      <div class="admin-card-desc">Cambia roles o elimina cuentas del sistema.</div>
    </a>
    <a href="index.php?page=Admin.GestionPlatos" class="admin-card">
      <i class="fas fa-utensils"></i>
      <div class="admin-card-title">Gestión de platos</div>
      <div class="admin-card-desc">Controla disponibilidad y stock del menú.</div>
    </a>
  </div>
</section>