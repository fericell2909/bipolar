@extends('admin.layouts.app_admin')
@section('title', 'Dashboard')
@section('content')
  <div class="row">
    <div class="col-md">
      @include('admin.partials.widget', [
        'icon' => 'fas fa-fw fa-boxes',
        'quantity' => $productsBuyWeek,
        'description' => 'Número de items comprados semanal',
      ])
    </div>
    <div class="col-md">
      @include('admin.partials.widget', [
        'icon' => 'fas fa-fw fa-money-bill-alt',
        'quantity' => "S/ {$sumTotalBuys}",
        'description' => 'Venta en soles semanal',
      ])
    </div>
    <div class="col-md">
      @include('admin.partials.widget', [
        'icon' => 'fas fa-fw fa-battery-quarter',
        'quantity' => $cartsInWeek,
        'description' => 'Compras truncas semanal',
      ])
    </div>
    <div class="col-md">
      @include('admin.partials.widget', [
        'icon' => 'fas fa-fw fa-shopping-cart',
        'quantity' => $firstBuyUsers,
        'description' => 'Clientes primera compra semanal',
      ])
    </div>
  </div>
  <div class="row">
    <div class="col-md">
      @include('admin.partials.widget', [
        'icon' => 'fas fa-fw fa-envelope',
        'quantity' => $newsletterUsersInWeek,
        'description' => 'Nuevos suscriptores newsletter',
      ])
    </div>
    <div class="col-md">
      @include('admin.partials.widget', [
        'icon' => 'fas fa-fw fa-user-plus',
        'quantity' => $usersInWeek,
        'description' => 'Nuevos registros semanal',
      ])
    </div>
    <div class="col-md">
      @include('admin.partials.widget', [
        'icon' => 'fas fa-fw fa-chart-area',
        'quantity' => $visitorsThisWeek,
        'description' => 'Número de visitas semanal',
      ])
    </div>
    <div class="col-md">
      @include('admin.partials.widget', [
        'icon' => 'fas fa-fw fa-users',
        'quantity' => $usersTotal,
        'description' => 'Usuarios en total',
      ])
    </div>
  </div>
  <div class="row m-b-10">
    <div class="col-md-3">
      <a href="{{ url('/admin/settings/types/1zyP4KGYeL/subtypes') }}" class="btn btn-dark btn-rounded btn-block">
        Ordenar colecciones
      </a>
    </div>
  </div>
  <div class="card border-dark">
    <div class="card-header bg-dark">
      <h4 class="m-b-0 text-white">Bipolar: Cambios Setiembre 2019</h4>
    </div>
    <div class="card-body">
      <ul>
        <li><span class="text-success">NUEVO:</span> Botón para ordenar colecciones</li>
      </ul>
    </div>
  </div>
@endsection
