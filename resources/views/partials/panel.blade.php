<nav class="main-header navbar navbar-expand navbar-dark" style="background-color:#4030A3;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button" style="text-decoration: none; color:white;"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
      </li>
      <li class="nav-item d-none d-sm-inline-block">
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
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
            <i class="fas fa-user mr-2"></i><p class="float-right">Profil Saya</p>
          </a>
          <a href="{{ route('logout') }}" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i><p class="float-right"> Log Out</p>
          </a>
          @else
          <a href="{{ route('logout') }}" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i></i><p class="float-right"> Log Out</p>
          </a>
          @endif
        </div>
        </li>
      </ul>
    </ul>
  </nav>