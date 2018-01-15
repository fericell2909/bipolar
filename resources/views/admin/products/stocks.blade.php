@extends('admin.layouts.app_admin')
@section('content')
    @include('admin.partials.product_header_steps', ['active' => 5])
    <div class="row">
        <div class="col-md-12 white-box">
            <table class="table table-responsive">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Talla</th>
                    <th>Cantidad</th>
                </tr>
                </thead>
                <tbody>
                <?php /** @var \App\Models\Product $product */ ?>
                @foreach($product->stocks as $stock)
                    <tr>
                        <td>{{ $stock->id }}</td>
                        <td>{{ $stock->size->name ?? '--' }}</td>
                        <td>
                            {!! Form::open(['url' => route('products.stock.save', $stock->id)]) !!}
                                {!! Form::number('quantity', $stock->quantity) !!}
                                {!! Form::submit('Guardar', ['class' => 'btn btn-dark btn-rounded btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection