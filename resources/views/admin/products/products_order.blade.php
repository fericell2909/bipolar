@extends('admin.layouts.app_admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">Coge un elemento para ordenar y suelta para guardar</h3>
                <div id="sortable-products">
                    @foreach($products as $product)
                        <?php /** @var \App\Models\Product $product */ ?>
                        <div class="media" data-id="{{ $product->hash_id }}">
                            <div class="media-left">
                                @if(count($product->photos) > 0)
                                <a>
                                    <img class="media-object" src="{{ $product->photos->first()->url }}" width="100">
                                </a>
                                @endif
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">{{ $product->name }}</h4>
                                <p>
                                    {{ $product->description }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection