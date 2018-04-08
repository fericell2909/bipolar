@extends('admin.layouts.app_admin')
@section('title', 'Lista de usuarios')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">Buscar usuario</div>
        <div class="card-body">
          {!! Form::open(['method' => 'get', 'route' => 'users.search']) !!}
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-fw fa-search"></i></span>
              </div>
              {!! Form::text('searchfield', null, ['class' => 'form-control', 'placeholder' => 'Coloque un nombre o apellido y presione enter']) !!}
              <div class="input-group-append">
                <button class="btn btn-dark">
                  <i class="fas fa-fw fa-search"></i>
                  Buscar
                </button>
              </div>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <a href="{{ route('users.download') }}" class="btn btn-sm btn-outline-dark btn-rounded pull-right">
            <i class="fas fa-fw fa-file-excel"></i>
            Descargar todos
          </a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover color-table dark-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th class="text-center"><i class="fas fa-fw fa-image"></i></th>
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
                    <td class="text-center">
                      @if($user->photo)
                        <img src="{{ $user->photo }}" alt="" class="img-circle" style="width: 32px; height: 32px">
                      @else
                        <i class="fas fa-fw fa-image"></i>
                      @endif
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->lastname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->getBirthdayOrNull() }}</td>
                    <td>{!! $user->getActiveLabelAdmin() !!}</td>
                    <td>
                      <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-rounded btn-dark">
                        <i class="fas fa-fw fa-edit"></i>
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
    </div>
  </div>
@endsection