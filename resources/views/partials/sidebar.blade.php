  <!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-light elevation-4" style="background-color:#4030A3;">
    <!-- Brand Logo -->
    <a href="/admininspektorat" class="brand-link">
      <img src="{{asset('/')}}dist/img/gumas.png" alt="AdminLTE Logo" class="img mr-2" style="opacity: .8; height:70px; width:70;">
      <span class="brand-text text-xl font-weight-light">SIPEMAS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      @if(auth()->user()->jenis_kelamin == 'Laki-laki')
        <div class="image">
          <img src="{{asset('/')}}dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
        </div>
      @else
        <div class="image">
            <img src="{{asset('/')}}dist/img/avatar3.png" class="img-circle elevation-2" alt="User Image">
        </div>
      @endif
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
            <a href="/admininspektorat" class="nav-link {{ ($active === 'beranda') ? 'active' : '' }}">
              <p>
              <i class="nav-icon fas fa-home"></i>
                Home
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link {{ ($active === 'manajemenlaporan' || $active === 'laporanselesai') ? 'active' : '' }}">
              <i class="nav-icon fas fa-folder-open"></i>
              <p>
                Manajemen Laporan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/laporanmasuk" class="nav-link {{ ($active === 'manajemenlaporan' ) ? 'active' : '' }}">
                  <p class="ml-5">Laporan Masuk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/laporanselesai" class="nav-link {{ ($active === 'laporanselesai') ? 'active' : '' }}">
                  <p class="ml-5">Laporan Selesai</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link {{ ($active === 'usermanajemen' || $active === 'useradmin') ? 'active' : '' }} ">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Manajemen User
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/userpengadu" class="nav-link {{ ($active === 'usermanajemen') ? 'active' : '' }}">
                  <p class="ml-5">User Pengadu</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/useradmin" class="nav-link {{ ($active === 'useradmin') ? 'active' : '' }}">
                  <p class="ml-5">User Admin</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="/kategori" class="nav-link {{ ($active === 'kategori') ? 'active' : '' }}">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>
              Kategori Pengaduan
              </p>
            </a>
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

