<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bipolar</title>
    <link rel="stylesheet" href="{{ mix('css/app-web-styles.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bipolar-background">
        <span class="navbar-text">
            Hola <a href="#">Ingresa</a> o <a href="#">regístrate</a>
        </span>
        <ul class="navbar-nav mr-auto">

        </ul>
        <div class="btn-group">
            <a class="btn btn-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Mi cuenta
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
            </div>
        </div>
    </nav>
    <section class="container d-sm-none d-md-none d-lg-none">
        <p class="text-center text-heading-mobile">¡Bienvenido invitado! Ingresa o regístrate</p>
        <div class="dropdown show">
            <a class="btn btn-link btn-block dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Mi cuenta
            </a>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
            </div>
        </div>
    </section>
    <section class="header-mobile d-sm-none d-md-none d-lg-none">
        <a href="#">
            <img src="{{ asset('images/logo-linea.png') }}">
        </a>
    </section>
    <div>
        <section class="header-desktop">
            <a href="#">
                <img src="{{ asset('images/logo-linea.png') }}">
            </a>
        </section>
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="https://bipolar.com.pe/wp-content/uploads/2017/08/6.png" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="https://bipolar.com.pe/wp-content/uploads/2017/08/6.png" alt="Second slide">
                </div>
            </div>
        </div>
    </div>
    <section class="header-mobile-menu d-sm-none d-md-none d-lg-none">
        MENU
    </section>
    <section class="header-worldwide-shipping">
        Envío a todo el mundo
    </section>
    <div class="card text-center">
        <div class="card-body">
            <h4 class="card-title">Regístrate</h4>
            <p class="card-text">Y disfruta de nuestras compras y descuentos especiales.</p>
            <form action="#" class="mx-auto" style="width: 20%;">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Nombre">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Apellidos (opcional)">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Cumpleaños">
                </div>
                <div class="form-group">
                    <select name="pais" id="" class="form-control">
                        <option selected disabled>País</option>
                    </select>
                </div>
                <button class="btn btn-dark">Enviar</button>
            </form>
        </div>
    </div>
    <footer class="bipolar-footer">
        <div class="container">
            <div class="row">
                <div class="col">
                    SAN ISIDRO, LIMA - PERÚ
                    (+51) 965.367.385
                    EMAIL: BIPOLAR@BIPOLAR.COM.PE
                </div>
                <div class="col">
                    <ul>
                        <li>Envíos</li>
                        <li>Cambios y devoluciones</li>
                        <li>Recomendaciones de Uso</li>
                    </ul>
                </div>
                <div class="col">
                    <ul>
                        <li>Envíos</li>
                        <li>Cambios y devoluciones</li>
                        <li>Recomendaciones de Uso</li>
                    </ul>
                </div>
                <div class="col">

                </div>
            </div>
        </div>
    </footer>
    <script src="{{ mix('js/app-web-scripts.js') }}"></script>
</body>
</html>