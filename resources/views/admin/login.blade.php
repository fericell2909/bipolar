<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="caffeinated" content="false">
    <title>Bipolar Administrador</title>
    <link href="{{ mix('css/app-admin-styles.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('favicon-bipolar.jpg') }}" type="image/x-icon">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <section id="wrapper" class="login-register login-sidebar" style="background-image: url({{ asset('storage/bipolar-images/assets/bipolar-gold.png') }});">
      <div class="login-box card">
        <div class="card-body">
          <form action="{{ route('login.admin.post') }}" method="POST" class="form-horizontal form-material">
            @csrf
            <a href="javascript:void(0)" class="text-center db">
              <br/><img src="https://bipolar.nyc3.digitaloceanspaces.com/images/LogoLetrasrosadas.svg" width="160"/>
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
            <div class="form-group text-center m-t-20">
              <div class="col-xs-12">
                <button class="btn btn-outline-warning btn-lg btn-block text-uppercase" type="submit">
                  Iniciar sesión
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </body>

</html>
