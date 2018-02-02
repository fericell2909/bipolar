@extends('admin.layouts.app_admin')
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="white-box">
      <h3 class="box-title">Lista de reglas de envío</h3>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Título</th>
              <th>Enviar a</th>
              <th>Excepto a</th>
              <th>Activa</th>
              <th><i class="fa fa-gear"></i></th>
            </tr>
          </thead>
          <tbody>
            @foreach($shippings as $shipping)
              <tr>
                <td>{{ $shipping->id }}</td>
                <td>{{ $shipping->title }}</td>
                <td>
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
                <td>
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
                <td>
                  @if($shipping->active)
                    <i class="fa fa-check"></i>
                  @else
                    <i class="fa fa-close"></i>
                  @endif
                </td>
                <td>
                  <a href="#" class="btn btn-sm btn-dark btn-rounded">
                    <i class="fa fa-pencil"></i> Editar
                  </a>
                  <a href="{{ route('settings.shipping.edit.price', $shipping->id) }}" class="btn btn-sm btn-dark btn-rounded">
                    <i class="fa fa-price"></i> Precios
                  </a>
                  @if($shipping->active)
                    <a href="{{ route('settings.shipping.activate', [$shipping->id, 0]) }}" class="btn btn-sm btn-dark btn-rounded">
                      <i class="fa fa-pause"></i> Desactivar
                    </a>
                  @else
                    <a href="{{ route('settings.shipping.activate', [$shipping->id, 1]) }}" class="btn btn-sm btn-dark btn-rounded">
                      <i class="fa fa-play"></i> Activar
                    </a>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection