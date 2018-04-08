@extends('admin.layouts.app_admin')
@section('title', 'Listado de compras')
@section('content')
  <div class="row">
    <div class="col-md">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover color-table dark-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nombre</th>
                  <th>Correo</th>
                  <th>Comprado</th>
                  <th>Enviar a</th>
                  <th>Estado</th>
                  <th>Pagada</th>
                  <th>Fecha</th>
                  <th>Total</th>
                  <th class="text-center">Showroom pickup</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach($buys as $buy)
                  <?php /** @var \App\Models\Buy $buy */ ?>
                  <tr>
                    <td>{{ $buy->id }}</td>
                    <td>{{ $buy->user->name }}</td>
                    <td>{{ $buy->user->email }}</td>
                    <td>{{ $buy->details->count() }} artículos</td>
                    <td>
                      {{ $buy->shipping_address->address }} {{ $buy->shipping_address->country_state->name }} {{ $buy->shipping_address->country_state->country->name }}
                    </td>
                    <td>{{ ucfirst($buy->status) }}</td>
                    <td>{!! $buy->payed ? "<i class='fa fa-check'></i>" : null !!}</td>
                    <td>{{ $buy->created_at->format('d/m/Y') }}</td>
                    <td>{{ $buy->total }} {{ $buy->currency }}</td>
                    <td class="text-center">{!! $buy->showroom ? "<i class='fa fa-check'></i>" : null !!}</td>
                    <td>
                      <button class="btn btn-dark btn-sm btn-rounded" data-target="#payments_{{ $buy->id }}" data-toggle="modal">
                        <i class="fa fa-credit-card"></i> Intentos de pago
                      </button>
                      <button class="btn btn-dark btn-rounded btn-sm change-to-sent-status" data-buy-id="{{ $buy->id }}">
                        <i class="fa fa-check"></i> Marcar como enviado
                      </button>
                      <button class="btn btn-dark btn-rounded btn-sm" data-target="#buy_details_{{ $buy->id }}" data-toggle="modal">
                        <i class="fa fa-eye"></i> Ver
                      </button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          {!! $buys->links() !!}
          @each('admin.partials.buy_details', $buys, 'buy')
          @each('admin.partials.payments', $buys, 'buy')
        </div>
      </div>
    </div>
  </div>
@endsection