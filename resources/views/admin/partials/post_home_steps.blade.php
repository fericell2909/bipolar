<div class="row thin-steps">
    <a href="{{ route('homepost.edit', $homePost->slug) }}" class="col-md-4 column-step start {{ $active === 1 ? 'active' : null }}">
        <div class="step-number">1</div>
        <div class="step-title">Publicación</div>
    </a>
    <a href="{{ route('homepost.photos', $homePost->slug) }}"
       class="col-md-4 column-step {{ $active === 2 ? 'active' : null }}">
        <div class="step-number">2</div>
        <div class="step-title">Fotos</div>
    </a>
    <a href="{{ route('homepost.photos.order', $homePost->slug) }}"
       class="col-md-4 column-step {{ $active === 3 ? 'active' : null }}">
        <div class="step-number">3</div>
        <div class="step-title">Ordenar</div>
    </a>
</div>