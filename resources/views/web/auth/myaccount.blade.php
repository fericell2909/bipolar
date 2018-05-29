@extends('web.layouts.app_web')
@section('content')
  <div class="background-title-image">
    <h1>Mi cuenta</h1>
  </div>
  <div class="container">
    <p>
      Hola {{ \Auth::user()->name }} (¿no eres bipolar? <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Cerrar sesión</a>). 
      Desde tu página de cuenta, puedes ver tus pedidos recientes, gestionar la dirección de envío, la dirección de facturación
      y <a href="{{ route('profile') }}">cambiar la información de la cuenta y la contraseña</a>
    </p>
    {!! Form::open(['route' => 'logout', 'style' => 'display:none', 'id' => 'logout-form']) !!}
    {!! Form::close() !!}
    <table class="table-buys">
      <thead>
        <tr>
          <th>Pedido</th>
          <th>Fecha</th>
          <th>Estado</th>
          <th>Total</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($buys as $buy)
        <tr>
          <td><a href="{{ route('confirmation', $buy->id) }}" class="order-link">#{{ $buy->id }}</a></td>
          <td>{{ $buy->created_at->format('d-m-Y') }}</td>
          <td>{{ $buy->status }}</td>
          <td><span class="price">{{ $buy->totalCurrency }}</span> por {{ $buy->details->count() }} items</td>
          <td class="order-actions">
            <a href="#" class="btn btn-dark-rounded">Pagar</a>
            <a href="#" class="btn btn-dark-rounded">Cancelar</a>
            <a href="{{ route('confirmation', $buy->id) }}" class="btn btn-dark-rounded">Ver</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection