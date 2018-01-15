@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\Product $product */ ?>
@push('before_scripts')
    <script>
        window.BipolarProductId = "{{ $product->hash_id }}";
    </script>
@endpush
@section('content')
    @include('admin.partials.product_header_steps', ['active' => 1])
    <div id="bipolar-product-edit"></div>
@endsection