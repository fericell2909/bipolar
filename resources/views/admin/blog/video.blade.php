@extends('admin.layouts.app_admin')
@section('title', 'Agregar un video a la publicación')
@section('content')
  @include('admin.partials.post_header_steps', ['active' => 2])
  <div class="row">
    <div class="col-md">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Información del video</h4>
          {!! Form::open() !!}
            <div class="form-group">
              {!! Form::label('Dirección del video en Youtube') !!}
              {!! Form::text('video', null, ['class' => 'form-control', 'placeholder' => 'Ej: https://www.youtube.com/watch?v=AAAABBBBCCCC', 'required']) !!}
            </div>
            {!! Form::submit('Guardar', ['class' => 'btn btn-dark btn-rounded']) !!}
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <div class="col-md">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Demo del video</h4>
          @if($post->main_video)
            <div class="embed-responsive embed-responsive-16by9">
              <iframe class="embed-responsive-item" src="{{ $post->main_video }}"></iframe>
            </div>
            <a href="{{ route('blog.video.remove', $post->id) }}" class="btn btn-outline-primary btn-rounded mt-3"> <i class="fas fa-fw fa-times"></i> Remover video</a>
          @else
            <div class="text-center">No se ha adjuntado ningún video aún</div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection