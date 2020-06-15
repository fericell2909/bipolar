@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\Banner $banner */ ?>
@section('title')
  Editar banner
@endsection
@push('before_scripts')
  <script>
    window.BannerColorHashId = "{{ $banner->hash_id }}";
    window.BannerColorId = "{{ $banner->id }}";
  </script>
@endpush
@section('content')
  @include('admin.partials.banner_color_steps', ['active' => 2])
  <div id="bipolar-banner-color-edit"></div>
@endsection
