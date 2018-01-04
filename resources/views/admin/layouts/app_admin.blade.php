<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <title>Bipolar Administrador</title>
    <!-- Custom CSS -->
    <link href="{{ mix('css/app-admin-styles.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('public/favicon-bipolar.jpg') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('public/favicon-bipolar.jpg') }}" type="image/x-icon">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://use.fontawesome.com/d71cf672b2.js"></script>
</head>

<body class="fix-sidebar">
<div id="wrapper">
    <!-- Top Navigation -->
    <nav class="navbar navbar-default navbar-static-top m-b-0">
        <div class="navbar-header"><a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)"
                                      data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
            <!-- Logo -->
            <div class="top-left-part">
                <a class="logo" href="{{ route('admin.dashboard') }}">
                    <span class="hidden-xs">
                        <img src="{{ asset('images/logo-linea.png') }}" class="image-logo" alt="home"/>
                    </span>
                </a>
            </div>
            <!-- /Logo -->
            <!-- This is the message dropdown -->
            <ul class="nav navbar-top-links navbar-right pull-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#">
                        <i class="fa fa-user"></i>
                        <b class="hidden-xs">{{ Auth::user()->name }}</b>
                    </a>
                    <ul class="dropdown-menu dropdown-user scale-up">
                        <li><a href="#"><i class="fa fa-user"></i> Mi perfil</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#"><i class="fa fa-power-off"></i> Cerrar sesión</a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
        </div>
        <!-- /.navbar-header -->
        <!-- /.navbar-top-links -->
        <!-- /.navbar-static-side -->
    </nav>
    <!-- End Top Navigation -->
    <!-- Left navbar-header -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse slimscrollsidebar">
            <ul class="nav" id="side-menu">
                <li class="nav-small-cap m-t-10">--- Menú</li>
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                        <i class="fa fa-dashboard"></i> <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="fa fa-user"></i>
                        <span class="hide-menu"> Usuarios<span class="fa arrow"></span></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li><a href="{{ route('users.index') }}">Listar usuarios</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="fa fa-archive"></i>
                        <span class="hide-menu"> Productos<span class="fa arrow"></span></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li><a href="{{ route('products.create') }}">Nuevo producto</a></li>
                        <li><a href="{{ route('products.index') }}">Listar productos</a></li>
                        <li><a href="{{ route('products.trashed') }}">Papelera</a></li>
                        <li><a href="{{ route('products.order') }}">Ordenar</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="fa fa-h-square"></i>
                        <span class="hide-menu"> Publicaciones Home <span class="fa arrow"></span></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li><a href="{{ route('homepost.create') }}">Nueva publicación</a></li>
                        <li><a href="{{ route('homepost.index') }}">Listar publicaciones</a></li>
                        <li><a href="{{ route('homepost.order') }}">Ordenar</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="fa fa-picture-o"></i>
                        <span class="hide-menu"> Banners <span class="fa arrow"></span></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li><a href="{{ route('banners.create') }}">Nuevo banner</a></li>
                        <li><a href="{{ route('banners.index') }}">Listar banners</a></li>
                        <li><a href="{{ route('banners.order') }}">Ordenar</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="fa fa-cog"></i>
                        <span class="hide-menu"> Configuraciones<span class="fa arrow"></span></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li><a href="{{ route('settings.general') }}">General</a></li>
                        <li><a href="{{ route('settings.sizes') }}">Tallas</a></li>
                        <li><a href="{{ route('settings.colors') }}">Colores</a></li>
                        <li><a href="{{ route('settings.types') }}">Tipos</a></li>
                        <li><a href="{{ route('admin.logs') }}">Logs (Desarrollador)</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- Left navbar-header end -->
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Bipolar</h4>
                </div>
                <!-- /.col-lg-12 -->
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
        <footer class="footer text-center"> {{ date('Y') }} &copy; Bipolar</footer>
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
@stack('before_scripts')
<script src="{{ mix('js/app-admin-scripts.js') }}"></script>
<script src="{{ mix('js/bipolar-admin-app.js') }}"></script>
@stack('after_scripts')
</body>

</html>
