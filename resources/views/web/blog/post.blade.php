@extends('web.layouts.app_blog')
@section('posts')
<?php /** @var \App\Models\Post $post */ ?>
<article>
  <header><a href="{{ route('landings.blog.post', $post->slug) }}">{{ $post->title }}</a></header>
  <nav class="meta">
    <span><img class="svg" src="{{ asset('/images/users.svg') }}" alt="Author"> Bipolar</span>
    <span><img class="svg" src="{{ asset('/images/clock.svg') }}" alt="Author"> {{ $post->created_at->format('j F Y') }}</span>
    <span><img class="svg" src="{{ asset('/images/ribbon.svg') }}" alt="Author"> {{ $post->categories->implode('name', ', ') }}</span>
  </nav>
    <div class="owl-carousel-blog owl-carousel owl-theme">
      @foreach($post->photos as $photo)
        <a href="{{ route('landings.blog.post', $post->slug) }}">
          <img class="img-responsive" src="{{ $photo->url }}" alt="{{ $post->title }}">
        </a>
      @endforeach
    </div>
  <footer>
    <p>{{ str_limit(strip_tags($post->content), 50) }}</p>
  </footer>
</article>
@endsection