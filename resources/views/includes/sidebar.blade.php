<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin <sup>SINEASHUB</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="{{ url('/') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Interface
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item {{ request()->routeIs('genre.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('genre.index') }}">
          <i class="fas fa-dna  "></i>
          <span>Genre</span></a>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item {{ request()->routeIs('film.index') || request()->routeIs('aktor.create') || request()->routeIs('creator.create') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#fillmCollapse" aria-expanded="true" aria-controls="fillmCollapse">
          <i class="fas fa-film"></i>
          <span>Film</span>
        </a>
        <div id="fillmCollapse" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('film.index') }}">Semua Film</a>
            <a class="collapse-item" href="{{ route('aktor.create') }}">Nambah Aktor</a>
            <a class="collapse-item" href="{{ route('creator.create') }}">Nambah Creator</a>
          </div>
        </div>
      </li>

       <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item {{ request()->routeIs('transaction.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('transaction.index') }}">
          <i class="fas fa-traffic-light"></i>
          <span>Transaction</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
