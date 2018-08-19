@extends('admin.layouts.app_admin')
@section('title', 'Papelera de productos')
@section('content')
  <div class="alert alert-warning">
    <i class="fas fa-fw fa-exclamation-triangle"></i> <strong>Cuidado</strong> <br>
    Al destruir un producto se perderán todas las fotos, datos de venta que tenga registrado.
  </div>
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-center">
        {!! $products->links() !!}
      </div>
      <div class="table-responsive">
        <table class="table table-hover color-table dark-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Nombre</th>
              <th>S/ | $</th>
              <th>Estado</th>
              <th>Descartado</th>
              <th><i class="fas fa-fw fa-cog"></i></th>
            </tr>
          </thead>
          <tbody>
            @forelse($products as $product)
              <?php /** @var \App\Models\Product $product */  ?>
              <tr>
                <td class="align-middle">{{ $product->id }}</td>
                <td class="align-middle">{{ $product->name }} <span class="text-primary">({{ $product->colors->implode('name', ', ') }})</span></td>
                <td class="align-middle">{{ $product->price }} | {{ $product->price_dolar }}</td>
                <td class="align-middle">
                  <span class="badge badge-pill badge-{{ $product->state->color }} text-white">{{ $product->state->name }}</span>
                </td>
                <td class="align-middle">{{ $product->deleted_at->toDayDateTimeString() }}</td>
                <td class="align-middle">
                  <div class="button-group">
                    <a href="{{ route('products.restore', $product->hash_id) }}" class="btn btn-rounded btn-dark btn-sm">
                      <i class="fas fa-fw fa-undo-alt"></i> Restaurar
                    </a>
                    <button class="btn btn-rounded btn-outline-danger btn-sm" data-toggle="modal" data-target="#destroyProduct_{{ $product->id }}">
                      <i class="fas fa-fw fa-times"></i> Destruir
                    </button>
                  </div>
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
      <div class="d-flex justify-content-center">
        {!! $products->links() !!}
      </div>
    </div>
  </div>
@endsection