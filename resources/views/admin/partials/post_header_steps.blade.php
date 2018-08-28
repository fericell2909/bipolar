@if(Route::currentRouteName() === "blog.create")
<div class="row">
  <a href="#" class="col-md">
    <div class="card text-center text-white bg-primary">
      <div class="card-body">
        <h4 class="card-text">1. Nuevo post</h4>
      </div>
    </div>
  </a>
  <a href="#" class="col-md">
    <div class="card text-center">
      <div class="card-body">
        <h4 class="card-text">2. Fotos (Slider)</h4>
      </div>
    </div>
  </a>
  <a href="#" class="col-md">
    <div class="card text-center">
      <div class="card-body">
        <h4 class="card-text">3. Ordenar</h4>
      </div>
    </div>
  </a>
</div>
@else
<div class="row">
  <a href="{{ route('blog.edit', $post->id) }}" class="col-md">
    <div class="card text-center {{ $active === 1 ? 'text-white bg-primary' : null }}">
      <div class="card-body">
        <h4 class="card-text">1. Nuevo post</h4>
      </div>
    </div>
  </a>
  <a href="{{ route('blog.photos', $post->id) }}" class="col-md">
    <div class="card text-center {{ $active === 2 ? 'text-white bg-primary' : null }}">
      <div class="card-body">
        <h4 class="card-text">2. Fotos (Slider)</h4>
      </div>
    </div>
  </a>
  <a href="{{ route('blog.photos.order', $post->id) }}" class="col-md">
    <div class="card text-center {{ $active === 3 ? 'text-white bg-primary' : null }}">
      <div class="card-body">
        <h4 class="card-text">3. Ordenar</h4>
      </div>
    </div>
  </a>
</div>
@endif