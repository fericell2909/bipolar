@extends('admin.layouts.app_admin')
@section('content')
    <div class="alert alert-warning">
        <i class="fa fa-exclamation-triangle"></i> <strong>Cuidado</strong> <br>
        Al destruir un producto se perderán todas las fotos, datos de venta que tenga registrado.
    </div>
    <div class="row">
        <div class="col-md-12 white-box">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th>Envío gratis</th>
                        <th>Destacado</th>
                        <th><i class="fa fa-gear"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <?php /** @var \App\Models\Product $product */  ?>
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ optional($product->state)->name }}</td>
                            <td>{!! $product->free_shipping ? "<i class='fa fa-check'></i>" : "" !!}</td>
                            <td>{!! $product->is_salient !== null ? "<i class='fa fa-check'></i>" : "" !!}</td>
                            <td>
                                <button class="btn btn-rounded btn-dark btn-sm" data-toggle="modal" data-target="#destroyProduct_{{ $product->id }}">
                                    <i class="fa fa-close"></i> Destruir
                                </button>
                            </td>
                        </tr>
                        <div class="modal fade" id="destroyProduct_{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Destruir producto {{ $product->name }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Se eliminarán los siguientes datos del producto
                                        <ul>
                                            <li>Compras del producto realizadas</li>
                                            <li>Imágenes del producto</li>
                                            <li>Datos del producto</li>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        {!! Form::open(['url' => route('products.harddelete', $product->hash_id), 'method' => 'POST']) !!}
                                        <button type="button" class="btn btn-rounded btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-rounded btn-danger">Destruir</button>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="7">No hay productos eliminados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection