<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="caffeinated" content="false">
    <!-- Favicon icon -->
    <title>@yield('title') - Bipolar Administrador</title>
    <!-- Custom CSS -->
    <link href="{{ mix('css/app-admin-styles.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('favicon-bipolar.jpg') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon-bipolar.jpg') }}" type="image/x-icon">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://kit.fontawesome.com/0511df7dc2.js" crossorigin="anonymous"></script>
  </head>

  <body class="skin-red fixed-layout">
    <div class="preloader">
      <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">Bipolar</p>
      </div>
    </div>
    <div id="main-wrapper">
      <!-- ============================================================== -->
      <!-- Topbar header - style you can find in pages.scss -->
      <!-- ============================================================== -->
      <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
          <div class="navbar-header d-none d-sm-block">
            <div class="navbar-brand">
              <span>
                <img src="{{ asset('images/logo-linea.png') }}" class="light-logo" alt="home" style="max-width: 100%;"/>
              </span>
            </div>
          </div>

          <div class="navbar-collapse">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav mr-auto">
              <!-- This is  -->
              <li class="nav-item">
                <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)">
                  <i class="fas fa-fw fa-bars"></i>
                </a>
              </li>
              <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark">
                  <i class="fas fa-fw fa-bars"></i>
                </a>
              </li>
            </ul>
            <ul class="navbar-nav my-lg-0">
              <li class="nav-item dropdown u-pro">
                <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="hidden-md-down">{{ Auth::user()->name }} &nbsp;<i class="fas fa-angle-down"></i></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right animated flipInY">
                  <a href="{{ route('admin.dashboard') }}" class="dropdown-item"><i class="fas fa-fw fa-tachometer-alt"></i> Dashboard</a>
                  <a href="{{ route('settings.passwords') }}" class="dropdown-item"><i class="fas fa-fw fa-lock"></i> Seguridad</a>
                  <div class="dropdown-divider"></div>
                  <a href="javascript:void(0)" onclick="document.getElementById('logout-form').submit()" class="dropdown-item"><i class="fas fa-fw fa-power-off"></i> Cerrar sesi??n</a>
                  {!! Form::open(['id' => 'logout-form', 'url' => '/logout', 'method' => 'post', 'style' => 'display:none']) !!}
                  {!! Form::close() !!}
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- ============================================================== -->
      <!-- End Topbar header -->
      <!-- ============================================================== -->

      <aside class="left-sidebar">
        <div class="scroll-sidebar">
          <div class="sidebar-nav">
            <ul id="sidebarnav">
              <li class="nav-small-cap">--- SECCIONES</li>
              <li>
                <a class="waves-effect waves-dark" href="{{ route('admin.dashboard') }}" aria-expanded="false">
                  <i class="fas fa-fw fa-tachometer-alt"></i>
                  <span class="hide-menu"> Dashboard</span>
                </a>
              </li>
              <li>
                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fas fa-fw fa-shopping-cart"></i>
                  <span class="hide-menu"> Compras</span>
                </a>
                <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('buys.index') }}">Listar compras</a></li>
                </ul>
              </li>
              <li>
                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fas fa-fw fa-users"></i>
                  <span class="hide-menu"> Usuarios</span>
                </a>
                <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('users.index') }}">Listar usuarios</a></li>
                  <li><a href="{{ route('users.with-carts') }}">Usuarios sin comprar</a></li>
                </ul>
              </li>
              <li>
                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fas fa-fw fa-boxes"></i>
                  <span class="hide-menu"> Productos</span>
                </a>
                <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('products.create') }}">Nuevo producto</a></li>
                  <li><a href="{{ route('products.index') }}">Listar productos</a></li>
                  <li><a href="{{ route('products.trashed') }}">Papelera</a></li>
                  <li><a href="{{ route('products.order') }}">Ordenar</a></li>
                  <li><a href="{{ route('products.massive-publication') }}">Publicaci??n masiva</a></li>
                  <li><a href="{{ route('products.text-conditions') }}">Texto Condiciones</a></li>
                </ul>
              </li>
              <li>
                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fas fa-fw fa-play"></i>
                  <span class="hide-menu"> Tareas</span>
                </a>
                <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('products.multiple-discounts') }}">Descuentos</a></li>
                  <li><a href="{{ route('products.multiple-2x1') }}">2x1</a></li>
                  <li><a href="{{ route('products.premium-links') }}">Enlaces</a></li>
                </ul>
              </li>
              <li>
                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fas fa-fw fa-warehouse"></i>
                  <span class="hide-menu"> Publicaciones Home</span>
                </a>
                <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('homepost.create') }}">Nueva publicaci??n</a></li>
                  <li><a href="{{ route('homepost.index') }}">Listar publicaciones</a></li>
                  <li><a href="{{ route('homepost.order') }}">Ordenar</a></li>
                  <li><a href="{{ route('homepost.types') }}">Tipos de publicaci??n</a></li>
                </ul>
              </li>
              <li>
                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fab fa-fw fa-blogger-b"></i>
                  <span class="hide-menu"> Blog</span>
                </a>
                <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('blog.create') }}">Nueva publicaci??n</a></li>
                  <li><a href="{{ route('blog.index') }}">Listar publicaciones</a></li>
                </ul>
              </li>
              <li>
                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fas fa-fw fa-history"></i>
                  <span class="hide-menu"> Hist??rico</span>
                </a>
                <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('historics.create') }}">Nuevo hist??rico</a></li>
                  <li><a href="{{ route('historics.index') }}">Listar hist??ricos</a></li>
                  <li><a href="{{ route('historics.order') }}">Ordenar</a></li>
                  <li><a href="{{ route('historics.trashed') }}">Eliminados</a></li>
                </ul>
              </li>
              <li>
                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fas fa-fw fa-tags"></i>
                  <span class="hide-menu"> Cupones</span>
                </a>
                <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('coupons.create') }}">Nuevo cup??n</a></li>
                  <li><a href="{{ route('coupons.index') }}">Listar cupones</a></li>
                </ul>
              </li>
              <li>
                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fas fa-fw fa-images"></i>
                  <span class="hide-menu"> Banners</span>
                </a>
                <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('banners.create') }}">Nuevo banner</a></li>
                  <li><a href="{{ route('banners.index') }}">Listar banners</a></li>
                  <li><a href="{{ route('banners.order') }}">Ordenar</a></li>
                </ul>
              </li>
              <li>
                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fad fa-fw fa-palette"></i>
                  <span class="hide-menu"> Color Banners</span>
                </a>
                <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('banners_colors.create') }}">Nuevo banner</a></li>
                  <li><a href="{{ route('banners_colors.index') }}">Listar banners</a></li>
                  <li><a href="{{ route('banners_colors.order') }}">Ordenar</a></li>
                </ul>
              </li>

              <li>
                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fas fa-fw fa-file"></i>
                  <span class="hide-menu"> P??ginas</span>
                </a>
                <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('page_admin.create') }}">Nueva p??gina</a></li>
                  <li><a href="{{ route('page_admin.index') }}">Listar p??ginas</a></li>
                </ul>
              </li>
              <li>
                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fas fa-fw fa-cogs"></i>
                  <span class="hide-menu"> Configuraciones</span>
                </a>
                <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('settings.general') }}">General</a></li>
                  <li><a href="{{ route('backgrounds.all') }}">Fondos</a></li>
                  <li><a href="{{ route('settings.sizes') }}">Tallas</a></li>
                  <li><a href="{{ route('settings.colors') }}">Colores</a></li>
                  <li><a href="{{ route('settings.labels.index') }}">Labels</a></li>
                  <li><a href="{{ route('settings.types') }}">Tipos</a></li>
                  <li><a href="{{ route('settings.shipping.index') }}">Shipping rates</a></li>
                </ul>
              </li>
              <li>
                <a class="waves-effect waves-dark" href="{{ route('admin.activity_log') }}" aria-expanded="false">
                  <i class="fas fa-fw fa-list-alt"></i>
                  <span class="hide-menu"> Logs</span>
                </a>
              </li>
              @if((\Auth::guard('admin')->user()->email === 'info@helmerdavila.com') || 
                  (\Auth::guard('admin')->user()->email === 'info@devmarcoestrada.com') || 
                  (\Auth::guard('admin')->user()->email === 'samuelgonzales90@gmail.com'))
              <li>
                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fas fa-fw fa-code"></i>
                  <span class="hide-menu"> Desarrollador</span>
                </a>
                <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ url('/horizon') }}" target="_blank">Horizon</a></li>
                  <li><a href="{{ url('/admin/telescope') }}" target="_blank">Telescope</a></li>
                  <li><a href="{{ url('/admin/graphql') }}" target="_blank">GraphQL</a></li>
                  <li><a href="{{ route('admin.logs') }}" target="_blank">Logs (Desarrollador)</a></li>
                </ul>
              </li>
              @endif
            </ul>
          </div>
        </div>
      </aside>

      <!-- Page Content -->
      <div class="page-wrapper">
        <div class="container-fluid">
          <div class="row page-titles">
            <div class="col-md-5 align-self-center">
              <h4 class="text-themecolor">@yield('title')</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
              <div class="d-flex justify-content-end align-items-center">
                @yield('superior-buttons')
              </div>
            </div>
          </div>
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          @include('flash::message')
          @yield('content')
        </div>
        <!-- /.container-fluid -->
      </div>
      <footer class="footer text-center"> &copy; {{ date('Y') }} Bipolar</footer>
      <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    @stack('before_scripts')
    <script src="{{ mix('js/app-admin-scripts.js') }}"></script>
    <script src="{{ mix('js/bipolar-admin-app.js') }}"></script>
    @stack('after_scripts')
  </body>
</html>
