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
    {!! Form::open(['id' => 'shopForm', 'method' => 'GET']) !!}
    <div class="bipolar-container">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group">
                        {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Buscar']) !!}
                        <div class="input-group-addon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div>
                </div>
                @foreach($types as $type)
                    <h4 class="bipolar-filter-title">Filtrar {{ $type->name }}</h4>
                    <div class="list-unstyled bipolar-filters">
                        @foreach($type->subtypes as $subtype)
                            <div class="icheck">
                                {!! Form::checkbox("subtypes[]", $subtype->slug) !!} {{ $subtype->name }} ({{ count($subtype->products) }})
                            </div>
                        @endforeach
                    </div>
                @endforeach
                @if($sizes)
                    <h4 class="bipolar-filter-title">Tallas</h4>
                    <div class="list-unstyled bipolar-filters">
                        @foreach($sizes as $size)
                            <div class="icheck">
                                {!! Form::checkbox('sizes[]', $size->slug) !!} {{ $size->name }} ({{ $size->product_count }})
                            </div>
                        @endforeach
                    </div>
                @endif
                <h4 class="bipolar-filter-title">Destacados</h4>
                @foreach($productsSalient as $salient)
                    <? /** @var \App\Models\Product $salient */ ?>
                    <div class="row bipolar-product-showed">
                        <div class="col-md-6 ">
                            @if(count($salient->photos))
                                <a href="{{ route('shop.product', $salient->slug) }}">
                                    <img src="{{ $salient->photos->first()->url }}" alt="{{ $salient->name }}" class="img-responsive">
                                </a>
                            @else
                                <img src="https://placehold.it/212x141" alt="Shop" class="img-responsive">
                            @endif
                        </div>
                        <div class="col-md-6">
                            {{ $salient->name }}<br>
                            {{ $salient->price }}
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-md-9">
                <div class="row bipolar-shop-results-filter">
                    <div class="col-md-5">MOSTRANDO 1–12 DE {{ $products->total() }} RESULTADOS</div>
                    <div class="col-md-offset-2 col-md-5">
                        {!! Form::select('orderBy', $orderOptions, $selectedOrderOption, ['id' => 'shop-sort-by', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    @forelse($products as $product)
                        <div class="col-md-4 bipolar-product">
                            @if(count($product->photos))
                                <a href="{{ route('shop.product', $product->slug) }}">
                                    <img src="{{ $product->photos->first()->url }}" alt="{{ $product->name }}" class="img-responsive">
                                </a>
                            @else
                                <a href="{{ route('shop.product', $salient->slug) }}">
                                    <img src="https://placehold.it/317x210" alt="{{ $salient->name }}" class="img-responsive">
                                </a>
                            @endif
                        </div>
                    @empty
                        <h3>No se encontraron productos, cambie sus parámetros de búsqueda</h3>
                    @endforelse
                </div>
                <div class="text-center">
                    {{ $products->links('web.partials.pagination-web') }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection