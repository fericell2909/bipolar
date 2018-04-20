<div class="row">
  <a href="{{ route('coupon.edit', $coupon->id) }}" class="col-md">
    <div class="card text-center {{ $active === 1 ? 'text-white bg-primary' : null }}">
      <div class="card-body">
        <h4 class="card-text">1. Datos de cupón</h4>
      </div>
    </div>
  </a>
  <a href="{{ route('coupons.associate', $coupon->id) }}" class="col-md">
    <div class="card text-center {{ $active === 2 ? 'text-white bg-primary' : null }}">
      <div class="card-body">
        <h4 class="card-text">2. Asociar con productos</h4>
      </div>
    </div>
  </a>
</div>