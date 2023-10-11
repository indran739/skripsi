<nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#4030A3; height:80px;" >
  <div class="container">
    <a class="navbar-brand fw-bold fs-1" style="font-family:'Pacifico'" href="/">SIPEMAS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse d-flex justify-content-center" style="margin-left:200px;"id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item px-4">
          <a class="nav-link  {{ ($active === 'beranda') ? 'active' : '' }} fs-5" href="/berandapengadu">Beranda</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link {{ ($active === 'pengaduan') ? 'active' : '' }} fs-5" href="/listpengaduan">List Pengaduan</a>
        </li>
        <li class="nav-item dropdown px-4">
            <a class="nav-link dropdown-toggle fs-5" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Laporan Anda
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li style="font-family: 'Pacifico', cursive;">
                  <a class="dropdown-item" href="">Laporan Belum Ditanggapi </a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li style="font-family: 'Pacifico', cursive;">
                  <a class="dropdown-item" href="">Laporan Selesai </a></li>
              </li>
            </ul>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        @auth
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fs-5" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           {{ auth()->user()->name }}
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li style="font-family: 'Pacifico', cursive;"><a class="dropdown-item" href=""><i class="bi bi-layout-text-sidebar-reverse"></i> Profile </a></li>
            <li><hr class="dropdown-divider"></li>
            <li style="font-family: 'Pacifico', cursive;">
              <form action="/logout" method="post">
                @csrf
                <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Logout</button>
              </form>
            </li>
          </ul>
        </li>
        @else
        <li class="nav-item" style="font-family: 'Pacifico', cursive;">
            <a href="/login" class="nav-link {{ ($active === 'login') ? 'active' : '' }}"><i class="bi bi-box-arrow-in-right"></i> Login</a>
        </li>
      </ul>
      @endauth
    </div>
  </div>
</nav>