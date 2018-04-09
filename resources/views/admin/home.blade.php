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
        'quantity' => 999999,
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
        'quantity' => 999999,
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
@endsection