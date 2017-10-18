<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
    <title>Bipolar Administrador</title>
    <link href="{{ mix('css/app-admin-styles.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://use.fontawesome.com/d71cf672b2.js"></script>
</head>

<body>
<section id="wrapper" class="login-register">
    <div class="login-box login-sidebar">
        <div class="white-box">
            {!! Form::open(['url' => route('login.admin.post'),'class' => 'form-horizontal form-material']) !!}
                <a href="javascript:void(0)" class="text-center db">
                    <br/><img src="{{ asset('images/logo-linea.png') }}" width="160"/>
                </a>
                <div class="form-group m-t-40">
                    <div class="col-xs-12">
                        {!! Form::email('email', null, ['placeholder' => 'Correo electrónico', 'class' => 'form-control', 'required' => true]) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        {!! Form::password('password', ['placeholder' => 'Contraseña', 'class' => 'form-control', 'required' => true]) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="checkbox checkbox-primary pull-left p-t-0">
                            <input id="checkbox-signup" type="checkbox">
                            <label for="checkbox-signup"> Recordarme </label>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-outline-warning btn-lg btn-block text-uppercase" type="submit">
                            Iniciar sesión
                        </button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</section>
</body>

</html>
