@extends('web.layouts.app_blog')
@section('posts')
@foreach($posts as $post)
  <?php /** @var \App\Models\Post $post */ ?>
  <article>
    <header><a href="{{ route('landings.blog.post', $post->slug) }}">{{ $post->title }}</a></header>
    <nav class="meta">
      <span><img class="svg" src="{{ asset('/images/users.svg') }}" alt="Author"> Bipolar</span>
      <span><img class="svg" src="{{ asset('/images/clock.svg') }}" alt="Author"> {{ $post->created_at->format('j F Y') }}</span>
      <span><img class="svg" src="{{ asset('/images/ribbon.svg') }}" alt="Author"> {{ $post->categories->implode('name', ', ') }}</span>
    </nav>
    <div class="owl-carousel-blog owl-carousel owl-theme">
      @if($post->main_video)
        <video  
          class="video-js vjs-default-skin vjs-big-play-centered"
          width="100%"
          height="100%" 
          controls
          data-setup='{ "techOrder": ["youtube"], "aspectRatio":"16:9", "sources": [{ "type": "video/youtube", "src": "{{ $post->main_video }}"}] }'
        >
        </video>
      @else
        @foreach($post->photos as $photo)
          <a href="{{ route('landings.blog.post', $post->slug) }}">
            <img class="img-responsive" src="{{ $photo->url }}" alt="{{ $post->title }}">
          </a>
        @endforeach
      @endif
    </div>
    <footer>
      <p>{!! str_limit($post->content, 50) !!}</p>
      <a href="{{ route('landings.blog.post', $post->slug) }}" class="btn btn-dark-rounded">{{ __('bipolar.blog.read_more') }}</a>
    </footer>
  </article>
@endforeach
{!! $posts->links('web.partials.pagination-blog') !!}
@endsection