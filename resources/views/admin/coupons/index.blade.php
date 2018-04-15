@extends('admin.layouts.app_admin')
@section('title', 'Listar cupones')
@section('superior-buttons')
  <a href="{{ route('coupons.create') }}" class="btn btn-dark btn-rounded">
    <i class="fas fa-fw fa-plus"></i> Nuevo
  </a>
@endsection
@section('content')
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover color-table dark-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Nombre</th>
              <th>Tipo</th>
              <th class="text-center">Monto</th>
              <th class="text-center">Veces por usuario</th>
              <th>Inicio</th>
              <th>Fin</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($coupons as $coupon)
            <?php /** @var \App\Models\Coupon $coupon */ ?>
            <tr>
              <td class="align-middle">{{ $coupon->id }}</td>
              <td class="align-middle">{{ $coupon->code }}</td>
              <td class="align-middle">{{ $coupon->type->name }}</td>
              <td class="align-middle text-center">{{ $coupon->amount }}</td>
              <td class="align-middle text-center">{{ $coupon->frequency }}</td>
              <td class="align-middle">{{ $coupon->begin->format('d/m/Y') }}</td>
              <td class="align-middle">{{ $coupon->end->format('d/m/Y') }}</td>
              <td class="align-middle text-center">
                <div class="button-group">
                  <a href="{{ route('coupon.edit', $coupon->id) }}" class="btn btn-dark btn-sm btn-rounded">
                    <i class="fas fa-fw fa-edit"></i> Editar
                  </a>
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