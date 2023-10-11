<nav class="main-header navbar navbar-expand navbar-dark" style="background-color:#4030A3;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button" style="text-decoration: none; color:white;"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="" class="nav-link"  style="text-decoration: none; color:white;">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link"  style="text-decoration: none; color:white;">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
       <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <li class="nav-item dropdown">
        <a class="nav-link {{ ($active === 'profile') ? 'active' : '' }}" data-toggle="dropdown" href="#">
          <p class="fas mr-2"></p><b>{{ Auth::user()->name }}</b>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          @if(auth()->user()->id_opd_fk == '3')
          <a href="/profilepengadu" class="dropdown-item">
            <i class="fas fa-user mr-2"></i><p class="float-right"> My Profile</p>
          </a>
          <a href="{{ route('logout') }}" class="dropdown-item">
            <i class="fas fa-power-off mr-2"></i><p class="float-right"> Log Out</p>
          </a>
          @else
          <a href="{{ route('logout') }}" class="dropdown-item">
            <i class="fas fa-power-off mr-2"></i><p class="float-right"> Log Out</p>
          </a>
          @endif
        </div>
        </li>
      </ul>
    </ul>
  </nav>