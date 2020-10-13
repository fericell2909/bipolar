@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\Product $product */ ?>
@section('title')
  Editar Premium Link - {{ $premium_link->name }}
@endsection
@push('before_scripts')
  <script>
    window.BipolarPremiumLinkUuid = "{{ $premium_link->uuid }}";
  </script>
@endpush
@section('content')
  <div id="bipolar-product-premium-link-edit"></div>
@endsection
