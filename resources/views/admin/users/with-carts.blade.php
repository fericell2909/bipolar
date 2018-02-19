@extends('admin.layouts.app_admin')
@section('content')
  <div class="white-box">
    <h3 class="box-title">Lista de usuarios con contenido en el carrito</h3>
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
              <td>{{ $user->getBirthdayOrNull() }}</td>
              <td>{!! $user->getActiveLabelAdmin() !!}</td>
              <td>
                <button class="btn btn-sm btn-rounded btn-dark" data-target="#cart_details_{{ optional($user->carts->first())->id }}" data-toggle="modal">
                  <i class="fa fa-shopping-cart"></i>
                  Ver carrito
                </button>
              </td>
            </tr>
        @empty
          <tr>
            <td>No hay usuarios registrados</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    @foreach($users as $user)
      @include('admin.partials.cart_details', ['cart' => $user->carts->first()])
    @endforeach
  </div>
@endsection