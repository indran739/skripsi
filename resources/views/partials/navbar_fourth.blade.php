<nav class="main-header navbar navbar-expand-md navbar-dark navbar-white" style="background-color:#4030A3; height:80px;">
    <div class="container">
      <a href="../../index3.html" class="navbar-brand">
        <img src="{{asset('/')}}dist/img/gumas.png" alt="AdminLTE Logo" class="img mr-2 text-white" style="opacity: .8; height:70px; width:55px;"></a>
        <span class="brand-text text-xl text-white font-weight-bold-light">SIPEMAS</span>
      </a>
      
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3 d-flex justify-content-end" id="navbarCollapse">
        <!-- Left navbar links -->
        @auth
        <ul class="navbar-nav">
          <li class="nav-item">
              <button type="btn" class="btn text-white"><i class=""></i> {{ auth()->user()->name }} </button>
          </li>
          <li class="nav-item">
          <form action="/logout" method="post">
              @csrf
              <button type="submit" class="btn text-white"><i class="bi bi-box-arrow-right"></i> Login</button>
          </form>
          </li>
        </ul>
      @endauth
      </div>

    </div>
  </nav>