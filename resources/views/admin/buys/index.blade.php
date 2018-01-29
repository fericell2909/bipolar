@extends('admin.layouts.app_admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">Listado de compras</h3>
                <table class="table">
                    <thead>
                      <tr>
                          <th>#</th>
                          <th>Nombre</th>
                          <th>Comprado</th>
                          <th>Enviar a</th>
                          <td>Fecha</td>
                          <td>Total</td>
                          <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($buys as $buy)
                        <?php /** @var \App\Models\Buy $buy */ ?>
                        <tr>
                            <td>{{ $buy->id }}</td>
                            <td>{{ $buy->user->name }}</td>
                            <td>{{ $buy->details->count() }} artículos</td>
                            <td>
                              {{ $buy->shipping_address->address }} {{ $buy->shipping_address->country_state->name }} {{ $buy->shipping_address->country_state->country->name }}
                            </td>
                            <td>{{ $buy->created_at->format('d/m/Y') }}</td>
                            <td>{{ $buy->created_at->format('d/m/Y') }}</td>
                            <td>S/ {{ $buy->total }} / $ {{ $buy->total_dolar }}</td>
                            <td>
                              <a href="#" class="btn btn-dark btn-rounded btn-sm">Ver</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection