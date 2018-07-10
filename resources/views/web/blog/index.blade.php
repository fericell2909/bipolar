@extends('web.layouts.app_web')
@section('content')
<div class="bipolar-blog-page">
  <div class="breadcrumb-wrapper">
    <div class="container">
      <ul class="breadcrumbs">
        <li><a href="#"><i class="fa fa-home"></i></a></li>
        <li><span>Blog posts</span></li>
      </ul>
    </div>
  </div>
  <section class="posts-wrapper">
    <section class="container">
      <section class="row clearfix">
        <section class="col-md-9 posts">
          @foreach($posts as $post)
            <article>
              <header><a href="#">{{ $post->title }}</a></header>
              <nav class="meta">
                <span><img class="svg" src="{{ asset('/images/users.svg') }}" alt="Author"> Bipolar</span>
                <span><img class="svg" src="{{ asset('/images/clock.svg') }}" alt="Author"> {{ $post->created_at->format('j F Y') }}</span>
                <span><img class="svg" src="{{ asset('/images/ribbon.svg') }}" alt="Author"> {{ $post->categories->implode('name', ', ') }}</span>
              </nav>
              <section class="post-images">
                <img class="img-responsive" src="https://placehold.it/1238x812/000000/ffffff" alt="{{ $post->title }}">
              </section>
              <footer>
                <a class="btn btn-dark-rounded">Leer más</a>
              </footer>
            </article>
          @endforeach
          {!! $posts->links('web.partials.pagination-blog') !!}
        </section>
        <aside class="post-sidebars col-md-3 hidden-sm hidden-xs">
          <article>
            <header>Recent posts</header>
            @if($lastPosts->count() > 0)
              <ul>
                @foreach($lastPosts as $post)
                  <li><a href="#">{{ $post->title }}</a></li>
                @endforeach
              </ul>
            @endif
          </article>
          <article>
            <header>Archives</header>
          </article>
          <article>
            <header>Categories</header>
            @if($categories->count() > 0)
              <ul>
                @foreach($categories as $category)
                  <li><a href="#">{{ $category->name }}</a></li>
                @endforeach
              </ul>
            @endif
          </article>
          <article>
            <header>Tags</header>
            @if($tags->count() > 0)
              <div class="tags">
                @foreach($tags as $tag)
                  <a href="#">{{ $tag->name }}</a>
                @endforeach
              </div>
            @endif
          </article>
        </aside>
      </section>
    </section>
  </section>
</div>
@endsection