  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-light elevation-4" style="background-color:#4030A3;">
    <!-- Brand Logo -->
    <a href="adminopd" class="brand-link">
      <img src="{{asset('/')}}dist/img/gumas.png" alt="AdminLTE Logo" class="img" style="opacity: .8; height:70px; width:70;">
      <span class="brand-text text-xl font-weight-light">SIPEMAS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('/')}}dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="/adminopd" class="nav-link {{ ($active === 'beranda') ? 'active' : '' }}">
              <p>
              <i class="nav-icon fas fa-tachometer-alt"></i>
                Home
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link {{ ($active === 'manajemenlaporan' || $active === 'selesai' ) ? 'active' : '' }}">
              <i class="nav-icon fas fa-folder-open"></i>
              <p>
                Manajemen Laporan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/laporanterdisposisiopd" class="nav-link {{ ($active === 'manajemenlaporan') ? 'active' : '' }}">
                  <p class="ml-5">Laporan Terdisposisi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/laporanselesaiopd" class="nav-link {{ ($active === 'selesai') ? 'active' : '' }}">
                  <p class="ml-5">Laporan Selesai</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-print"></i>
              <p>
                Cetak Laporan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/charts/chartjs.html" class="nav-link">
                  <p class="ml-5">Cetak Laporan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/charts/flot.html" class="nav-link">
                  <p class="ml-5">Cetak Data Pengadu</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>