@extends('admin.layouts.app_admin')
@section('title', 'Listado de productos')
@section('superior-buttons')
  <a href="{{ route('products.create') }}" class="btn btn-dark btn-rounded m-l-15">
    <i class="fas fa-fw fa-plus"></i> Crear nuevo
  </a>
@endsection
@section('content')
  <div id="bipolar-product-list"></div>
@endsection
