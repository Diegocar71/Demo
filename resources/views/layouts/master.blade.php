<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
    </ul>

    {{--  fecha actual  --}}
    {{--  <div  class="col align-items-right">

        <script type="text/javascript">

            var d = new Date();
            var dia=new Array(7);
            dia[0]="Domingo";
            dia[1]="Lunes";
            dia[2]="Martes";
            dia[3]="Miercoles";
            dia[4]="Jueves";
            dia[5]="Viernes";
            dia[6]="Sabado";

            var mm=new Date();
            var m2 = mm.getMonth() + 1;
            var mesok = (m2 < 10) ? '0' + m2 : m2;
            var mesok=new Array(12);
            mesok[0]="Enero";
            mesok[1]="Febrero";
            mesok[2]="Marzo";
            mesok[3]="Abril";
            mesok[4]="Mayo";
            mesok[5]="Junio";
            mesok[6]="Julio";
            mesok[7]="Agosto";
            mesok[8]="Septiembre";
            mesok[9]="Octubre";
            mesok[10]="Noviembre";
            mesok[11]="Diciembre";

            document.write(" Hoy es " + dia[d.getDay()] + " " + d.getDate() + " de " + mesok[mm.getMonth()] + " del Año " + d.getFullYear());

        </script>

    </div>  --}}

    {{--  <!-- SEARCH FORM -->  --}}
    {{--  <form class="form-inline ml-3">  --}}
        {{--  <div class="input-group input-group-sm">  --}}
        {{--  <p> type="datetime" name="fecha"  value="<?php echo date("d-m-Y");?>"</p>  --}}
        {{--  Cuandro de Busqueda dentro del formulario
             <input class="form-control form-control-navbar" type="search" placeholder="Buscar" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>  --}}
      {{--  </div>  --}}
    {{--  </form>  --}}

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <router-link to="/dashboard" class="brand-link">
      <img src="{{ asset('/images/logo.png') }}" alt="The Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
    </router-link>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
        <router-link to="/profile">
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                <img src="{{ auth()->user()->photo }}" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                  {{ Auth::user()->name }}
                  <span class="d-block text-muted">
                    {{ Ucfirst(Auth::user()->type) }}
                  </span>
              </div>
          </div>
        </router-link>

      <!-- Sidebar Menu -->
      @include('layouts.sidebar-menu')
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  {{-- Content Wrapper. Contains page content --}}
  <div class="content-wrapper">
    {{-- Main content --}}

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        {{-- <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row --> --}}
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <router-view></router-view>

    <vue-progress-bar></vue-progress-bar>

    {{-- /.content --}}
  </div>
  {{-- /.content-wrapper --}}

  {{-- Main Footer --}}
  <footer class="main-footer">
    {{-- To the right --}}
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0.0
    </div>
    {{-- Default to the left --}}
    <strong>Copyright &copy; 2022 - <a href="https://www.argentina.gob.ar/psa"> Policía de Seguridad Aeroportuaria</a></strong> - Reservados todos los Derechos.
  </footer>
</div>
{{-- ./wrapper --}}

@auth
<script>
    window.user = @json(auth()->user())
</script>
@endauth
<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
