  <!-- Main Sidebar Container -->
  </style>

  <aside class="main-sidebar sidebar-dark-light elevation-4" style="background-color:#4030A3;">
    <!-- Brand Logo -->
    <a href="berandapengadu" class="brand-link">
      <img src="{{asset('/')}}dist/img/gumas.png" alt="AdminLTE Logo" class="img" style="opacity: .8; height:70px; width:70;">
      <span class="brand-text font-weight-light" style="font-size:45px;">SIPEMAS</span> 
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          @if(auth()->user()->jenis_kelamin == 'Laki-Laki')
              <img src="{{ asset('storage/' . auth()->user()->foto_wajah) }}" class="img-circle img-bordered-sm" alt="User Image">
          @else
              <img src="{{ asset('storage/' . auth()->user()->foto_wajah) }}" class="img-circle img-bordered-sm" alt="User Image">
          @endif
        </div>
        <div class="info">
          <a href="/profilepengadu" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="/berandapengadu" class="nav-link {{ ($active === 'beranda') ? 'active' : '' }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Beranda
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/formpengaduan" class="nav-link {{ ($active === 'formlaporan') ? 'active' : '' }}">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Buat Laporan
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
                <a href="/laporanterkirim" class="nav-link {{ ($active === 'manajemenlaporan') ? 'active' : '' }}">
                  <p class="ml-5">Laporan Terkirim</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/laporanselesaipengadu" class="nav-link {{ ($active === 'selesai') ? 'active' : '' }}">
                  <p class="ml-5">Laporan Selesai</p>
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