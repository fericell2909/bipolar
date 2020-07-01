<div class="row">
  <a href="{{ route('banners_colors.edit', $banner->id) }}" class="col-md">
    <div class="card text-center {{ $active === 1 ? 'text-white bg-primary' : null }}">
      <div class="card-body">
        <h4 class="card-text">1. Programación</h4>
      </div>
    </div>
  </a>
  <a href="{{ route('banners_colors.set_text', $banner->id) }}" class="col-md">
    <div class="card text-center {{ $active === 2 ? 'text-white bg-primary' : null }}">
      <div class="card-body">
        <h4 class="card-text">2. Texto</h4>
      </div>
    </div>
  </a>
</div>
