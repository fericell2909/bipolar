@extends('admin.layouts.app_admin')
@section('title', 'Lista de reglas de envío')
@section('superior-buttons')
  <a href="{{ route('settings.shipping.new') }}" class="btn btn-dark btn-rounded btn-sm">
    <i class="fas fa-fw fa-plus"></i> Nuevo
  </a>
@endsection
@section('content')
  <div class="card">
    <div class="card-header">Lista de reglas de envíos</div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Título</th>
              <th>Enviar a</th>
              <th>Excepto a</th>
              <th class="text-center">Showroom pickup</th>
              <th class="text-center">DNI requerido</th>
              <th class="text-center">Activa</th>
              <th><i class="fas fa-fw fa-cog"></i></th>
            </tr>
          </thead>
          <tbody>
            @foreach($shippings as $shipping)
              <?php /** @var \App\Models\Shipping $shipping */ ?>
              <tr>
                <td class="align-middle">{{ $shipping->id }}</td>
                <td class="align-middle">{{ $shipping->title }}</td>
                <td class="align-middle">
                  <ul class="list-unstyled">
                    @foreach($shipping->includes as $shippingInclude)
                      @if($shippingInclude->all_countries)
                        Todos los países
                      @endif
                      @if($shippingInclude->country)
                        <li>{{ $shippingInclude->country->name }}</li>
                      @elseif($shippingInclude->country_state)
                        <li>{{ $shippingInclude->country_state->country->name }} - {{ $shippingInclude->country_state->name }}</li>
                      @endif
                    @endforeach
                  </ul>
                </td>
                <td class="align-middle">
                  <ul class="list-unstyled">
                    @foreach($shipping->excludes as $shippingExclude)
                      @if($shippingExclude->country)
                        <li>{{ $shippingExclude->country->name }}</li>
                      @elseif($shippingExclude->country_state)
                        <li>{{ $shippingExclude->country_state->country->name }} - {{ $shippingExclude->country_state->name }}</li>
                      @endif
                    @endforeach
                  </ul>
                </td>
                <td class="align-middle text-center">
                  @if($shipping->allow_showroom)
                    <i class="fas fa-fw fa-check"></i>
                  @else
                    <i class="fas fa-fw fa-times"></i>
                  @endif
                </td>
                <td class="align-middle text-center">
                  @if($shipping->is_dni_required)
                    <i class="fas fa-fw fa-check"></i>
                  @else
                    <i class="fas fa-fw fa-times"></i>
                  @endif
                </td>
                <td class="align-middle text-center">
                  @if($shipping->active)
                    <i class="fas fa-fw fa-check"></i>
                  @else
                    <i class="fas fa-fw fa-times"></i>
                  @endif
                </td>
                <td class="align-middle">
                  <div class="button-group">
                    <a href="{{ route('settings.shipping.edit', $shipping->id) }}" class="btn btn-sm btn-dark btn-rounded">
                      <i class="fas fa-fw fa-edit"></i> Editar
                    </a>
                    <a href="{{ route('settings.shipping.edit.price', $shipping->id) }}" class="btn btn-sm btn-dark btn-rounded">
                      <i class="fas fa-fw fa-dollar-sign"></i> Precios
                    </a>
                    @if($shipping->active)
                      <a href="{{ route('settings.shipping.activate', [$shipping->id, 0]) }}" class="btn btn-sm btn-dark btn-rounded">
                        <i class="fas fa-fw fa-pause"></i> Desactivar
                      </a>
                    @else
                      <a href="{{ route('settings.shipping.activate', [$shipping->id, 1]) }}" class="btn btn-sm btn-dark btn-rounded">
                        <i class="fas fa-fw fa-play"></i> Activar
                      </a>
                    @endif
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
