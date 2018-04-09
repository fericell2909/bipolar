@extends('admin.layouts.app_admin')
@section('title', 'Nuevo producto')
@section('content')
  <div class="row">
    <div class="col-md">
      <div class="card text-center text-white bg-primary">
        <div class="card-body">
          <h4 class="card-text">1. Producto</h4>
        </div>
      </div>
    </div>
    <div class="col-md">
      <div class="card text-center">
        <div class="card-body">
          <h4 class="card-text">2. Fotos</h4>
        </div>
      </div>
    </div>
    <div class="col-md">
      <div class="card text-center">
        <div class="card-body">
          <h4 class="card-text">3. Ordenar</h4>
        </div>
      </div>
    </div>
    <div class="col-md">
      <div class="card text-center">
        <div class="card-body">
          <h4 class="card-text">4. Recomendados</h4>
        </div>
      </div>
    </div>
    <div class="col-md">
      <div class="card text-center">
        <div class="card-body">
          <h4 class="card-text">5. Stocks</h4>
        </div>
      </div>
    </div>
  </div>
  <div id="bipolar-product-new"></div>
@endsection