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
                <a class="logo" href="index.html">
                    <!-- Logo icon image, you can use font-icon also -->
                    <b><img src="https://placekitten.com/g/60/60" alt="home"/></b>
                    <!-- Logo text image you can use text also -->
                    <span class="hidden-xs"><img src="https://placekitten.com/g/108/21" alt="home"/></span> </a>
            </div>
            <!-- /Logo -->
            <!-- This is the message dropdown -->
            <ul class="nav navbar-top-links navbar-right pull-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img
                                src="https://placekitten.com/g/128/128" alt="user-img" width="36" class="img-circle"><b
                                class="hidden-xs">Steave</b> </a>
                    <ul class="dropdown-menu dropdown-user scale-up">
                        <li><a href="#"><i class="ti-user"></i> My Profile</a></li>
                        <li><a href="#"><i class="ti-wallet"></i> My Balance</a></li>
                        <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#"><i class="fa fa-power-off"></i> Logout</a></li>
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
                    <a href="#" class="waves-effect">
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
                <li><a href="login.html" class="waves-effect"><i class="zmdi zmdi-power zmdi-hc-fw fa-fw"></i> <span
                                class="hide-menu">Log out</span></a></li>
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
            @yield('content')
        </div>
        <!-- /.container-fluid -->
        <footer class="footer text-center"> {{ date('Y') }} &copy; Bipolar</footer>
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<script src="{{ mix('js/app-admin-scripts.js') }}"></script>
</body>

</html>
