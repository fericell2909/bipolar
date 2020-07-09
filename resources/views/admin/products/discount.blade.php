@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\Product $product */ ?>
@section('title', "Agregar descuentos a {$product->name}")
@push('before_scripts')
  <script>
    window.BipolarProductId = "{{ $product->hash_id }}";
  </script>
@endpush
@section('content')
  @include('admin.partials.product_header_steps', ['active' => "discounts"])
  <div id="bipolar-product-discount"></div>
@endsection
