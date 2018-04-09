<div class="row">
  <a href="{{ route('homepost.edit', $homePost->slug) }}" class="col-md">
    <div class="card text-center {{ $active === 1 ? 'text-white bg-primary' : null }}">
      <div class="card-body">
        <h4 class="card-text">1. Publicación</h4>
      </div>
    </div>
  </a>
  <a href="{{ route('homepost.photos', $homePost->slug) }}" class="col-md">
    <div class="card text-center {{ $active === 2 ? 'text-white bg-primary' : null }}">
      <div class="card-body">
        <h4 class="card-text">2. Fotos</h4>
      </div>
    </div>
  </a>
  <a href="{{ route('homepost.photos.order', $homePost->slug) }}" class="col-md">
    <div class="card text-center {{ $active === 3 ? 'text-white bg-primary' : null }}">
      <div class="card-body">
        <h4 class="card-text">3. Ordenar</h4>
      </div>
    </div>
  </a>
</div>