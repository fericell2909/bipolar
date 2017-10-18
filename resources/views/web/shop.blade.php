@extends('web.layouts.app_web')
@push('css_plus')
    <style>
        .bipolar-container {
            padding-top: 250px;
            margin-top: 0;
        }
    </style>
@endpush
@section('content')
    <div class="bipolar-container">
        <div class="row">
            <div class="col-md-3">
                {!! Form::text('search', null, ['class' => 'form-control']) !!}
                <h4 class="bipolar-filter-title">Filtrar zapatos</h4>
                <ul class="list-unstyled bipolar-filters">
                    <li><a href="#">Test 1</a></li>
                    <li><a href="#">Test 1</a></li>
                    <li><a href="#">Test 1</a></li>
                    <li><a href="#">Test 1</a></li>
                </ul>
                <h4 class="bipolar-filter-title">Filtrar accesorios</h4>
                <ul class="list-unstyled bipolar-filters">
                    <li><a href="#">Test 1</a></li>
                    <li><a href="#">Test 1</a></li>
                    <li><a href="#">Test 1</a></li>
                    <li><a href="#">Test 1</a></li>
                </ul>
                <h4 class="bipolar-filter-title">Destacados</h4>
                @for($i = 0; $i < 5; $i++)
                    <div class="row bipolar-product-showed">
                        <div class="col-md-6 ">
                            <img class="img-responsive" src="https://placehold.it/212x141" alt="Bipolar">
                        </div>
                        <div class="col-md-6">
                            10{{ $i }}<br>
                            S/ 10{{ $i }}
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-md-9">
                <div class="row bipolar-shop-results-filter">
                    <div class="col-md-5">MOSTRANDO 1–12 DE 63 RESULTADOS</div>
                    <div class="col-md-offset-2 col-md-5">
                        {!! Form::select('order', [0 => 'Orden predeterminado', 1 => 'Ordenar por popularidad'], null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    @for($i = 0; $i < 13; $i++)
                        <div class="col-md-4 bipolar-product">
                            <img src="https://placehold.it/212x141" alt="Shop" class="img-responsive">
                        </div>
                    @endfor
                </div>
                <div class="text-center">
                    <ul class="pagination">
                        <li><a href="#" class="page-number active">1</a></li>
                        <li><a href="#" class="page-number">1</a></li>
                        <li><a href="#" class="page-number">1</a></li>
                        <li><a href="#" class="page-number">1</a></li>
                        <li><a href="#" class="page-number">1</a></li>
                        <li><a href="#" class="page-number">&raquo;</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection