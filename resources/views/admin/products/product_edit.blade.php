@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\Product $product */ ?>
@section('title')
  Editar producto {{ $product->name }} {{ $product->colors->implode('name', ', ') }}
@endsection
@push('before_scripts')
  <script>
    window.BipolarProductId = "{{ $product->hash_id }}";
  </script>
@endpush
@section('content')
  @include('admin.partials.product_header_steps', ['active' => "product-edit"])
  <div id="bipolar-product-edit"></div>
@endsection
