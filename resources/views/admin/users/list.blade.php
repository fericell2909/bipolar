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
        <div class="card-header text-right">
          <a href="{{ route('users.download') }}" class="btn btn-sm btn-outline-dark btn-rounded">
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
                  <th>DNI</th>
                  <th>Nacimiento</th>
                  <th>Activo</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @forelse($users as $user)
                  <?php /** @var \App\Models\User $user */ ?>
                  <tr>
                    <td class="align-middle">{{ $user->id }}</td>
                    <td class="align-middle text-center">
                      @if($user->photo)
                        <img src="{{ $user->photo }}" alt="" class="img-circle" style="width: 32px; height: 32px">
                      @else
                        <i class="fas fa-fw fa-image"></i>
                      @endif
                    </td>
                    <td class="align-middle">{{ $user->name }}</td>
                    <td class="align-middle">{{ $user->lastname }}</td>
                    <td class="align-middle">{{ $user->email }}</td>
                    <td class="align-middle">{{ $user->dni }}</td>
                    <td class="align-middle">{{ $user->getBirthdayOrNull() }}</td>
                    <td class="align-middle">{!! $user->getActiveLabelAdmin() !!}</td>
                    <td class="align-middle">
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
          @if($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
            {!! $users->links() !!}
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
