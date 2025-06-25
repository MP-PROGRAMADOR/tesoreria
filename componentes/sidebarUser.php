<nav class="sidebar sidebar-offcanvas shadow-sm" id="sidebar">
  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link <?= $page == 'inicio' ? 'active' : '' ?>" href="index.php">
        <i class="mdi mdi-view-dashboard menu-icon"></i>
        <span class="menu-title">Inicio</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link <?= $page == 'entradas' ? 'active' : '' ?>" href="entradas.php">
        <i class="mdi mdi-folder-open menu-icon"></i>
        <span class="menu-title">Entradas</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link <?= $page == 'salidas' ? 'active' : '' ?>" href="salidas.php">
        <i class="mdi mdi-folder menu-icon"></i>
        <span class="menu-title">Salidas</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link <?= $page == 'decretos' ? 'active' : '' ?>" href="decretos.php">
        <i class="mdi mdi-tag menu-icon"></i>
        <span class="menu-title">Decretos</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link <?= $page == 'reportes' ? 'active' : '' ?>" href="reportes.php">
        <i class="mdi mdi-chart-bar menu-icon"></i>
        <span class="menu-title">Reportes</span>
      </a>
    </li>
  </ul>
</nav>