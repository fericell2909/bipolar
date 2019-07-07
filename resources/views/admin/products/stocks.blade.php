@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\Product $product */ ?>
@section('title', "Stocks para {$product->name} y sincronizacion con Bsale")
@push('before_scripts')
  <script>
    window.BipolarProductId = "{{ $product->hash_id }}";
  </script>
@endpush
@section('content')
  @include('admin.partials.product_header_steps', ['active' => 5])
  <div class="row">
    <div class="col-md-12 white-box">
      <div class="card">
        <div class="card-body">
          <div class="alert alert-info">
            Info: Para conectar con Bsale debe tener registrado al menos una variación por producto, comúnmente es una talla
          </div>
          <div id="bipolar-product-stocks"></div>
        </div>
      </div>
    </div>
  </div>
@endsection