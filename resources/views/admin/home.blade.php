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
    <title>Elite Admin - is a responsive admin template</title>
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
                <li class="dropdown"><a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown"
                                        href="#"><i class="icon-envelope"></i>
                        <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
                    </a>
                    <ul class="dropdown-menu mailbox scale-up">
                        <li>
                            <div class="drop-title">You have 4 new messages</div>
                        </li>
                        <li>
                            <div class="message-center">
                                <a href="#">
                                    <div class="user-img"><img src="../plugins/images/users/pawandeep.jpg" alt="user"
                                                               class="img-circle"> <span
                                                class="profile-status online pull-right"></span></div>
                                    <div class="mail-contnet">
                                        <h5>Pavan kumar</h5>
                                        <span class="mail-desc">Just see the my admin!</span> <span
                                                class="time">9:30 AM</span></div>
                                </a>
                                <a href="#">
                                    <div class="user-img"><img src="../plugins/images/users/sonu.jpg" alt="user"
                                                               class="img-circle"> <span
                                                class="profile-status busy pull-right"></span></div>
                                    <div class="mail-contnet">
                                        <h5>Sonu Nigam</h5>
                                        <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span>
                                    </div>
                                </a>
                                <a href="#">
                                    <div class="user-img"><img src="../plugins/images/users/arijit.jpg" alt="user"
                                                               class="img-circle"> <span
                                                class="profile-status away pull-right"></span></div>
                                    <div class="mail-contnet">
                                        <h5>Arijit Sinh</h5>
                                        <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span>
                                    </div>
                                </a>
                                <a href="#">
                                    <div class="user-img"><img src="../plugins/images/users/pawandeep.jpg" alt="user"
                                                               class="img-circle"> <span
                                                class="profile-status offline pull-right"></span></div>
                                    <div class="mail-contnet">
                                        <h5>Pavan kumar</h5>
                                        <span class="mail-desc">Just see the my admin!</span> <span
                                                class="time">9:02 AM</span></div>
                                </a>
                            </div>
                        </li>
                        <li>
                            <a class="text-center" href="javascript:void(0);"> <strong>See all notifications</strong> <i
                                        class="fa fa-angle-right"></i> </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown"><a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown"
                                        href="#"><i class="icon-note"></i>
                        <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks scale-up">
                        <li>
                            <a href="#">
                                <div>
                                    <p><strong>Task 1</strong> <span class="pull-right text-muted">40% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar"
                                             aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                                             style="width: 40%"><span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p><strong>Task 2</strong> <span class="pull-right text-muted">20% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar"
                                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"
                                             style="width: 20%"><span class="sr-only">20% Complete</span></div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p><strong>Task 3</strong> <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar"
                                             aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                             style="width: 60%"><span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p><strong>Task 4</strong> <span class="pull-right text-muted">80% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar"
                                             aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
                                             style="width: 80%"><span class="sr-only">80% Complete (danger)</span></div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#"> <strong>See All Tasks</strong> <i
                                        class="fa fa-angle-right"></i> </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
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
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="fa fa-dashboard"></i>
                        <span class="hide-menu"> Dashboard <span class="fa arrow"></span>
                            <span class="label label-rouded label-custom pull-right">4</span></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li><a href="index.html">Demographical</a></li>
                        <li><a href="index2.html">Minimalistic</a></li>
                        <li><a href="index3.html">Analitical</a></li>
                        <li><a href="index4.html">Simpler</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="fa fa-user"></i>
                        <span class="hide-menu"> Usuarios<span class="fa arrow"></span></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li><a href="#">Listar usuarios</a></li>
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
                    <h4 class="page-title">Starter Page </h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <a href="https://themeforest.net/item/elite-admin-responsive-dashboard-web-app-kit-/16750820"
                       target="_blank"
                       class="btn btn-danger pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light">Buy
                        Now</a>
                    <ol class="breadcrumb">
                        <li><a href="#">Dashboard</a></li>
                        <li class="active">Starter Page</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title">Blank Starter page</h3>
                    </div>
                </div>
            </div>
            <!-- .right-sidebar -->
            <div class="right-sidebar">
                <div class="slimscrollright">
                    <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span>
                    </div>
                    <div class="r-panel-body">
                        <ul>
                            <li><b>Layout Options</b></li>
                            <li>
                                <div class="checkbox checkbox-info">
                                    <input id="checkbox1" type="checkbox" class="fxhdr">
                                    <label for="checkbox1"> Fix Header </label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox checkbox-warning">
                                    <input id="checkbox2" type="checkbox" checked="" class="fxsdr">
                                    <label for="checkbox2"> Fix Sidebar </label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox checkbox-success">
                                    <input id="checkbox4" type="checkbox" class="open-close">
                                    <label for="checkbox4"> Toggle Sidebar </label>
                                </div>
                            </li>
                        </ul>
                        <ul id="themecolors" class="m-t-20">
                            <li><b>With Light sidebar</b></li>
                            <li><a href="javascript:void(0)" theme="default" class="default-theme working">1</a></li>
                            <li><a href="javascript:void(0)" theme="green" class="green-theme">2</a></li>
                            <li><a href="javascript:void(0)" theme="gray" class="yellow-theme">3</a></li>
                            <li><a href="javascript:void(0)" theme="blue" class="blue-theme">4</a></li>
                            <li><a href="javascript:void(0)" theme="purple" class="purple-theme">5</a></li>
                            <li><a href="javascript:void(0)" theme="megna" class="megna-theme">6</a></li>
                            <li><b>With Dark sidebar</b></li>
                            <br/>
                            <li><a href="javascript:void(0)" theme="default-dark" class="default-dark-theme">7</a></li>
                            <li><a href="javascript:void(0)" theme="green-dark" class="green-dark-theme">8</a></li>
                            <li><a href="javascript:void(0)" theme="gray-dark" class="yellow-dark-theme">9</a></li>
                            <li><a href="javascript:void(0)" theme="blue-dark" class="blue-dark-theme">10</a></li>
                            <li><a href="javascript:void(0)" theme="purple-dark" class="purple-dark-theme">11</a></li>
                            <li><a href="javascript:void(0)" theme="megna-dark" class="megna-dark-theme">12</a></li>
                        </ul>
                        <ul class="m-t-20 chatonline">
                            <li><b>Chat option</b></li>
                            <li>
                                <a href="javascript:void(0)"><img src="../plugins/images/users/varun.jpg" alt="user-img"
                                                                  class="img-circle"> <span>Varun Dhavan <small
                                                class="text-success">online</small></span></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><img src="../plugins/images/users/genu.jpg" alt="user-img"
                                                                  class="img-circle"> <span>Genelia Deshmukh <small
                                                class="text-warning">Away</small></span></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><img src="../plugins/images/users/ritesh.jpg"
                                                                  alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small
                                                class="text-danger">Busy</small></span></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><img src="../plugins/images/users/arijit.jpg"
                                                                  alt="user-img" class="img-circle"> <span>Arijit Sinh <small
                                                class="text-muted">Offline</small></span></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><img src="../plugins/images/users/govinda.jpg"
                                                                  alt="user-img" class="img-circle"> <span>Govinda Star <small
                                                class="text-success">online</small></span></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><img src="../plugins/images/users/hritik.jpg"
                                                                  alt="user-img" class="img-circle"> <span>John Abraham<small
                                                class="text-success">online</small></span></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><img src="../plugins/images/users/john.jpg" alt="user-img"
                                                                  class="img-circle"> <span>Hritik Roshan<small
                                                class="text-success">online</small></span></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><img src="../plugins/images/users/pawandeep.jpg"
                                                                  alt="user-img" class="img-circle"> <span>Pwandeep rajan <small
                                                class="text-success">online</small></span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /.right-sidebar -->
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
