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
                  <th class="align-middle">#</th>
                  <th class="align-middle">Nombre</th>
                  <th class="align-middle">Correo</th>
                  <th class="align-middle">Shipping</th>
                  <th class="align-middle">Comprado</th>
                  <th class="align-middle">Enviar a</th>
                  <th class="align-middle">Estado</th>
                  <th class="align-middle">Pagada</th>
                  <th class="align-middle">Fecha</th>
                  <th class="align-middle">Total</th>
                  <th class="text-center align-middle">Store pickup</th>
                  <th class="align-middle">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach($buys as $buy)
                  <?php /** @var \App\Models\Buy $buy */ ?>
                  <tr>
                    <td class="align-middle">{{ $buy->id }}</td>
                    <td class="align-middle">{{ $buy->user->name }}</td>
                    <td class="align-middle">{{ $buy->user->email }}</td>
                    <td class="align-middle">{{ $buy->shipping->title ?? '--' }}</td>
                    <td class="align-middle">{{ $buy->details->count() }} artículos</td>
                    <td class="align-middle">
                      {{ $buy->shipping_address->address }} {{ $buy->shipping_address->country_state->name }} {{ $buy->shipping_address->country_state->country->name }}
                    </td>
                    <td class="align-middle">{{ ucfirst($buy->status) }}</td>
                    <td class="align-middle">{!! $buy->payed ? "<i class='fa fa-check'></i>" : null !!}</td>
                    <td class="align-middle">{{ $buy->created_at->format('d/m/Y') }}</td>
                    <td class="align-middle">{{ $buy->total }} {{ $buy->currency }}</td>
                    <td class="text-center align-middle">{!! $buy->showroom ? "<i class='fa fa-check'></i>" : null !!}</td>
                    <td class="align-middle">
                      <div class="button-group">
                        <a href="{{ route('buys.edit', $buy->id) }}" class="btn btn-dark btn-sm btn-rounded">
                          <i class="fas fa-fw fa-edit"></i> Editar
                        </a>
                        @if($buy->bsale_document_url)
                          <a href="{{ $buy->bsale_document_url }}" target="_blank" class="btn btn-dark btn-sm btn-rounded">
                            Ver boleta
                          </a>
                        @endif
                        <button class="btn btn-dark btn-sm btn-rounded" data-target="#payments_{{ $buy->id }}" data-toggle="modal">
                          <i class="fa fa-credit-card"></i> Intentos de pago
                        </button>
                        <button class="btn btn-dark btn-rounded btn-sm" data-target="#buy_details_{{ $buy->id }}" data-toggle="modal">
                          <i class="fa fa-eye"></i> Ver
                        </button>
                      </div>
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