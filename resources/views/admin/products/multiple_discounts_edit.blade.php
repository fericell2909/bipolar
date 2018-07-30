@extends('admin.layouts.app_admin')
@section('title', "Editar descuento")
@push('before_scripts')
  <script>
    window.BipolarDiscountTaskId = "{{ $discount->id }}";
  </script>
@endpush
@section('content')
  <div id="bipolar-product-multiple-discounts-edit"></div>
@endsection