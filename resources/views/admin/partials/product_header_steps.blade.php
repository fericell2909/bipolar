<div class="row">
  <a href="{{ route('products.edit', $product->hash_id) }}" class="col-md">
    <div class="card text-center {{ $active === 1 ? 'text-white bg-primary' : null }}">
      <div class="card-body">
        <h4 class="card-text">1. Producto</h4>
      </div>
    </div>
  </a>
  <a href="{{ route('products.photos', $product->slug) }}" class="col-md">
    <div class="card text-center {{ $active === 2 ? 'text-white bg-primary' : null }}">
      <div class="card-body">
        <h4 class="card-text">2. Fotos</h4>
      </div>
    </div>
  </a>
  <a href="{{ route('products.photos.order', $product->slug) }}" class="col-md">
    <div class="card text-center {{ $active === 3 ? 'text-white bg-primary' : null }}">
      <div class="card-body">
        <h4 class="card-text">3. Ordenar</h4>
      </div>
    </div>
  </a>
  <a href="{{ route('products.recommended', $product->slug) }}" class="col-md">
    <div class="card text-center {{ $active === 4 ? 'text-white bg-primary' : null }}">
      <div class="card-body">
        <h4 class="card-text">4. Recomendados</h4>
      </div>
    </div>
  </a>
  <a href="{{ route('products.stock', $product->slug) }}" class="col-md">
    <div class="card text-center {{ $active === 5 ? 'text-white bg-primary' : null }}">
      <div class="card-body">
        <h4 class="card-text">5. Stocks</h4>
      </div>
    </div>
  </a>
</div>