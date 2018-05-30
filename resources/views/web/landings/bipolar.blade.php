@extends('web.layouts.app_web')
@section('content')
    <img src="https://bipolar-peru.s3.amazonaws.com/assets/jeringas-rosado.jpg" style="width: 100%;" class="img-responsive" alt="Bipolar">
    <div class="bipolar-container">
        <p class="title-text-content">BIPOLAR</p>
        <p>
            Nos encanta la dualidad y que no todo sea lo que parece. <br>
            Nos gusta la línea que divide lo femenino y dulce, de lo secreto y provocador. <br>
            Queremos tener el control pero jugamos a perderlo. <br>
            Nos gusta lo cursi y lo sobrio. Lo correcto y lo indebido. <br>
            Nos gusta ir de rosa. Pero, sobre todo, nos gusta ir de negro. <br>
        </p>
        <p>
            Nuestra pasión son los tacos altos y lo que nos hacen sentir. <br>
            Desde el 2011, Bipolar diseña zapatos de cuero para que seas quien quieras ser, <br>
            para jugar o conquistar el mundo. <br>
        </p>
        <p>
            <a href="{{ route('landings.historico') }}">Aquí</a> un recorrido por todos nuestros bipolares desde el inicio!
        </p>
    </div>
@endsection