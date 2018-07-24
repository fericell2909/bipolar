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
              <th class="text-center">Monto si S/</th>
              <th class="text-center">Monto si $</th>
              <th class="text-center">Veces por usuario</th>
              <th>Inicio</th>
              <th>Fin</th>
              <th>Mínimo S/</th>
              <th>Mínimo $</th>
              <th class="text-center">¿Productos con descuento?</th>
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
              <td class="align-middle text-center">{{ $coupon->amount_pen }} {{ config('constants.PERCENTAGE_DISCOUNT_ID') ? '%' : 'S/' }}</td>
              <td class="align-middle text-center">{{ $coupon->amount_usd }} {{ config('constants.PERCENTAGE_DISCOUNT_ID') ? '%' : '$' }}</td>
              <td class="align-middle text-center">{{ $coupon->frequency }}</td>
              <td class="align-middle">{{ $coupon->begin->format('d/m/Y') }}</td>
              <td class="align-middle">{{ $coupon->end->format('d/m/Y') }}</td>
              <td class="align-middle">{{ $coupon->minimum_pen }}</td>
              <td class="align-middle">{{ $coupon->minimum_usd }}</td>
              <td class="align-middle text-center">{{ $coupon->discounted_products ? 'Sí' : 'No' }}</td>
              <td class="align-middle text-center">
                <div class="button-group">
                  <a href="{{ route('coupon.edit', $coupon->id) }}" class="btn btn-dark btn-sm btn-rounded">
                    <i class="fas fa-fw fa-edit"></i> Editar
                  </a>
                  <button class="btn btn-sm btn-dark btn-rounded delete-coupon" data-coupon-id="{{ $coupon->id }}">
                    <i class="fas fa-fw fa-times"></i>
                    Eliminar
                  </button>
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