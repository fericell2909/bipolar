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
                @foreach($types as $type)
                    <h4 class="bipolar-filter-title">Filtrar {{ $type->name }}</h4>
                    <ul class="list-unstyled bipolar-filters">
                        @foreach($type->subtypes as $subtype)
                            <li><a href="#">{{ $subtype->name }} ({{ count($subtype->products) }})</a></li>
                        @endforeach
                    </ul>
                @endforeach
                @if($sizes)
                    <h4 class="bipolar-filter-title">Tallas</h4>
                    <ul class="list-unstyled bipolar-filters">
                        @foreach($sizes as $size)
                            <li><a href="#">{{ $size->name }}</a></li>
                        @endforeach
                    </ul>
                @endif
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
                    <div class="col-md-5">MOSTRANDO 1–12 DE {{ $products->total() }} RESULTADOS</div>
                    <div class="col-md-offset-2 col-md-5">
                        {!! Form::select('order', [0 => 'Orden predeterminado', 1 => 'Ordenar por popularidad'], null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4 bipolar-product">
                            @if(count($product->photos))
                                <a href="{{ route('shop.product', $product->slug) }}">
                                    <img src="{{ $product->photos->first()->url }}" alt="{{ $product->name }}" class="img-responsive">
                                </a>
                            @else
                                <img src="https://placehold.it/212x141" alt="Shop" class="img-responsive">
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="text-center">
                    {{ $products->links('web.partials.pagination-web') }}
                </div>
            </div>
        </div>
    </div>
@endsection