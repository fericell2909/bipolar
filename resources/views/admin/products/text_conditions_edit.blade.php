@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\Product $product */ ?>
@section('title')
  Editar Texto Condición - {{ $name }}
@endsection
@push('before_scripts')
  <script>
    window.BipolarTextConditionUuid = "{{ $text_condition->uuid }}";
  </script>
@endpush
@section('content')
  <div id="bipolar-product-conditions-text-edit"></div>
@endsection
