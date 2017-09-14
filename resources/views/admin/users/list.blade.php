@extends('admin.layouts.app_admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">Buscar usuario</h3>
                {!! Form::open(['method' => 'get', 'route' => 'users.search']) !!}
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-search"></i></div>
                        {!! Form::text('searchfield', null, ['class' => 'form-control', 'placeholder' => 'Coloque un nombre o apellido y presione enter']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">Lista de Usuarios</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Correo</th>
                            <th>Nacimiento</th>
                            <th>Activo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <?php /** @var \App\Models\User $user */ ?>
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->lastname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->birthday_date ? $user->birthday_date->toDateString() : '--' }}</td>
                                <td>{!! $user->getActiveLabelAdmin() !!}</td>
                                <td>
                                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-rounded btn-primary">
                                        <i class="fa fa-pencil"></i>
                                        Editar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td>No hay usuarios registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection