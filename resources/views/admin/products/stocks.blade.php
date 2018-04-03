@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\Product $product */ ?>
@push('before_scripts')
  <script>
    window.BipolarProductId = "{{ $product->hash_id }}";
  </script>
@endpush
@section('content')
  @include('admin.partials.product_header_steps', ['active' => 5])
  <div class="row">
    <div class="col-md-12 white-box">
      <div id="bipolar-product-stocks"></div>
    </div>
  </div>
@endsection