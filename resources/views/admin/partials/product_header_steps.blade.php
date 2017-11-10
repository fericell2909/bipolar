<div class="white-box">
    <div class="row thin-steps-no-bg">
        <div class="col-md-3 column-step start {{ $active === 1 ? 'active' : null }}">
            <div class="step-number">1</div>
            <div class="step-title">Producto</div>
        </div>
        <div class="col-md-3 column-step {{ $active === 2 ? 'active' : null }}">
            <a href="{{ route('products.photos', $product->slug) }}" class="step-number">2</a>
            <div class="step-title">Fotos</div>
        </div>
        <div class="col-md-3 column-step {{ $active === 3 ? 'active' : null }}">
            <a href="{{ route('products.photos.order', $product->slug) }}" class="step-number">3</a>
            <div class="step-title">Ordenar</div>
        </div>
        <div class="col-md-3 column-step finish {{ $active === 4 ? 'active' : null }}">
            <a href="{{ route('products.recommended', $product->slug) }}" class="step-number">4</a>
            <div class="step-title">Recomendados</div>
        </div>
    </div>
</div>