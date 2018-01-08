<div class="row thin-steps">
    <a href="{{ route('products.edit', $product->hash_id) }}" class="col-md-2 column-step start {{ $active === 1 ? 'active' : null }}">
        <div class="step-number">1</div>
        <div class="step-title">Producto</div>
    </a>
    <a href="{{ route('products.photos', $product->slug) }}"
       class="col-md-2 column-step {{ $active === 2 ? 'active' : null }}">
        <div class="step-number">2</div>
        <div class="step-title">Fotos</div>
    </a>
    <a href="{{ route('products.photos.order', $product->slug) }}"
       class="col-md-2 column-step {{ $active === 3 ? 'active' : null }}">
        <div class="step-number">3</div>
        <div class="step-title">Ordenar</div>
    </a>
    <a href="{{ route('products.recommended', $product->slug) }}"
       class="col-md-3 column-step {{ $active === 4 ? 'active' : null }}">
        <div class="step-number">4</div>
        <div class="step-title">Recomendados</div>
    </a>
    <a href="{{ route('products.stock', $product->slug) }}" class="col-md-3 column-step {{ $active === 5 ? 'active' : null }}">
        <div class="step-number">5</div>
        <div class="step-title">Stocks</div>
    </a>
</div>