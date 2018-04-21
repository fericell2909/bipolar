@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\Coupon $coupon */ ?>
@section('title', "Asociar cupón {$coupon->code} con productos o tipos")
@push('before_scripts')
  <script>
    window.BipolarCouponId = "{{ $coupon->id }}";
  </script>
@endpush
@section('content')
  @include('admin.partials.coupon_steps', ['active' => 2])
  <div id="bipolar-coupon-association"></div>
@endsection