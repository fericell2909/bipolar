@extends('admin.layouts.app_admin')
@section('title', 'Listado de compras')
@section('content')
  <div class="card">
    <div class="card-body">
      {!! Form::open(['route' => 'buys.index', 'method' => 'GET']) !!}
        <div class="d-flex">
          <div class="flex-grow-1 mr-3">
            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre, orden o estado">
          </div>
          <button type="submit" class="btn btn-rounded btn-dark">Buscar</button>
        </div>
      {!! Form::close() !!}
    </div>
  </div>
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
                    <td class="align-middle">{{ $buy->user->name }} {{ $buy->user->lastname }}</td>
                    <td class="align-middle">{{ $buy->user->email }}</td>
                    <td class="align-middle">{{ $buy->shipping->title ?? '--' }}</td>
                    <td class="align-middle">{{ $buy->details->count() }} artículos</td>
                    <td class="align-middle">
                      {{ $buy->shipping_address->address }} {{ $buy->shipping_address->country_state->name }} {{ $buy->shipping_address->country_state->country->name }}
                    </td>
                    <td class="align-middle">{{ ucfirst($buy->status) }}</td>
                    <td class="align-middle">{!! $buy->payed ? "<i class='fas fa-check'></i>" : null !!}</td>
                    <td class="align-middle">{{ $buy->created_at->format('d/m/Y') }}</td>
                    <td class="align-middle">{{ $buy->total }} {{ $buy->currency }}</td>
                    <td class="text-center align-middle">{!! $buy->showroom ? "<i class='fas fa-check'></i>" : null !!}</td>
                    <td class="align-middle">
                      <div class="dropdown">
                        <button class="btn btn-dark btn-sm btn-rounded dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Acciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          @if($buy->bsale_document_url)
                            <a href="{{ $buy->bsale_document_url }}" target="_blank" class="dropdown-item">
                              <i class="fad fa-money-bill-alt"></i> Ver boleta
                            </a>
                            <div class="dropdown-divider"></div>
                          @endif
                          <a href="{{ route('buys.edit', $buy->id) }}" class="dropdown-item">
                            <i class="fas fa-fw fa-edit"></i> Editar
                          </a>
                          <a href="#" class="dropdown-item" data-target="#buy_resend_email_{{ $buy->id }}" data-toggle="modal">
                            <i class="fas fa-envelope"></i> Reenviar correo
                          </a>
                          <a href="#" class="dropdown-item" data-target="#payments_{{ $buy->id }}" data-toggle="modal">
                            <i class="fas fa-credit-card"></i> Intentos de pago
                          </a>
                          <a href="#" class="dropdown-item" data-target="#buy_details_{{ $buy->id }}" data-toggle="modal">
                            <i class="fas fa-eye"></i> Detalles
                          </a>
                        </div>
                      </div>
                      <div class="button-group">

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
          @each('admin.partials.buy_admin_resend_email', $buys, 'buy')
        </div>
      </div>
    </div>
  </div>
@endsection
