@extends('admin.layouts.app_admin')
@section('content')
    <div class="row thin-steps">
        <div class="col-md-3 column-step active">
            <div class="step-number">1</div>
            <div class="step-title">Producto</div>
        </div>
        <div class="col-md-3 column-step">
            <div class="step-number">2</div>
            <div class="step-title">Fotos</div>
        </div>
        <div class="col-md-3 column-step">
            <div class="step-number">3</div>
            <div class="step-title">Ordenar</div>
        </div>
        <div class="col-md-3 column-step">
            <div class="step-number">4</div>
            <div class="step-title">Recomendados</div>
        </div>
    </div>
    <div id="bipolar-product-new"></div>
@endsection