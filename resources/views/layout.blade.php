<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--User Auth-->
    <meta name="user" content="{{ Auth::user() }}">


  <title>Sistema de información geográfica</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

 <!-- Styles -->
 <link href="{{ asset('css/app.css') }}" rel="stylesheet">
 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
 integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
 crossorigin=""/>

 

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav ml-auto">
      <!-- Authentication Links -->
      @guest
          <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">{{ __('Entrar') }}</a>
          </li>
      @else
          <li class="nav-item dropdown">
            <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
             {{ __('Cerrar sesión') }}
         </a>

         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
             @csrf
         </form>

          </li>
      @endguest
  </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/perfil" class="brand-link">
      <img src="dist/img/SigLogo.png" alt="Sistema de información geográfica" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Admin SIG</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar user panel -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user_logo.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="/perfil" class="d-block">Datos personales</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          @if (auth()->user()->is_ventanilla)
          <!-- Users Option -->         
          <li class="nav-item">
            <a href="/solicitud" class="nav-link">
              <i class="nav-icon fas fa-map-marked-alt"></i>
              <p>
                Solicitar carta
              </p>
            </a>
          </li>
          @endIf

          @if (auth()->user()->is_cartografia)
          <!-- Users Option -->         
          <li class="nav-item">
            <a href="/cartas" class="nav-link">
              <i class="nav-icon fas fa-map-marked-alt"></i>
              <p>
                Gestionar cartas
              </p>
            </a>
          </li>
          @endIf

          @if (auth()->user()->is_cartografia) 
          <!-- Users Option -->         
          <li class="nav-item">
            <a href="/solicitudes" class="nav-link">
              <i class="nav-icon fas fa-tasks"></i>
              <p>
                Gestionar solicitudes
              </p>
            </a>
          </li>
          @endIf
          
          @if (auth()->user()->is_admin)
            <!-- Users Option -->         
            <li class="nav-item">
              <a href="/usuarios" class="nav-link">
                <i class="nav-icon fas fa-users-cog"></i>

                <p>
                  Administrar Usuarios
                </p>
              </a>
            </li>
          @endIf

           <!-- Sigs Option -->         
           <li class="nav-item">
            <a target="_blank" href="http://localhost/proyecto/public/sig" class="nav-link">
              <i class="fas fa-globe-americas"></i>
              <p>
                Sig
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
         @yield('content')
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Sistema de información geográfica
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2019.</strong> Todos los derechos reservados.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>

<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
