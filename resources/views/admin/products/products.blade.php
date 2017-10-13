@extends('admin.layouts.app_admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-md-11">
                        <h3 class="box-title">Listar los productos</h3>
                    </div>
                    <div class="col-md-1">
                        <a href="{{ route('products.create') }}" class="btn btn-success btn-rounded">
                            <i class="fa fa-plus"></i> Nuevo
                        </a>
                    </div>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Colores</th>
                        <th class="text-right">Precio</th>
                        <th class="text-center">Activo</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <?php /** @var \App\Models\Product $product */ ?>
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }} - {{ $product->subtitle }}</td>
                            <td>
                                @foreach($product->colors as $color)
                                    <div style="background-color: {{ $color->hexadecimal }}">
                                        {{ $color->name }}
                                    </div>
                                @endforeach
                            </td>
                            <td class="text-right">{{ $product->price }}</td>
                            <td class="text-center">{!! $product->getAdminActiveButton() !!}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary btn-rounded">
                                    <i class="fa fa-pencil"></i> Editar
                                </a>
                                <button class="btn btn-sm btn-danger btn-rounded product-delete"
                                        data-product-id="{{ $product->hash_id }}">
                                    <i class="fa fa-trash"></i>
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection