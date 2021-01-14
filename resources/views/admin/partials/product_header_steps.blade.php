<div class="row">
  <a href="{{ route('products.edit', $product->hash_id) }}" class="col-md">
    <div class="card text-center {{ $active === "product-edit" ? 'text-white bg-primary' : null }}">
      <div class="card-body">
        <h4 class="card-text">1. Producto</h4>
      </div>
    </div>
  </a>
  <a href="{{ route('products.photos', $product->slug) }}" class="col-md">
    <div class="card text-center {{ $active === "photos" ? 'text-white bg-primary' : null }}">
      <div class="card-body">
        <h4 class="card-text">2. Fotos y Videos</h4>
      </div>
    </div>
  </a>
  <a href="{{ route('products.photos.order', $product->slug) }}" class="col-md">
    <div class="card text-center {{ $active === "order" ? 'text-white bg-primary' : null }}">
      <div class="card-body">
        <h4 class="card-text">3. Ordenar</h4>
      </div>
    </div>
  </a>
  <a href="{{ route('products.calculate', $product->slug) }}" class="col-md">
    <div class="card text-center {{ $active === "calculate-size" ? 'text-white bg-primary' : null }}">
      <div class="card-body">
        <h4 class="card-text">4. Cálculo talla</h4>
      </div>
    </div>
  </a>
  <a href="{{ route('products.recommended', $product->slug) }}" class="col-md">
    <div class="card text-center {{ $active === "recommended" ? 'text-white bg-primary' : null }}">
      <div class="card-body">
        <h4 class="card-text">5. Recomendados</h4>
      </div>
    </div>
  </a>
  <a href="{{ route('products.stock', $product->slug) }}" class="col-md">
    <div class="card text-center {{ $active === "stocks" ? 'text-white bg-primary' : null }}">
      <div class="card-body">
        <h4 class="card-text">6. Stocks</h4>
      </div>
    </div>
  </a>
  <a href="{{ route('products.discount', $product->slug) }}" class="col-md">
    <div class="card text-center {{ $active === "discounts" ? 'text-white bg-primary' : null }}">
      <div class="card-body">
        <h4 class="card-text">7. Descuentos</h4>
      </div>
    </div>
  </a>
</div>
