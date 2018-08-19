@extends('web.layouts.app_web')
@section('content')
<div class="bipolar-blog-page">
  <div class="breadcrumb-wrapper">
    <div class="container">
      <ul class="breadcrumbs">
        <li><a href="#"><i class="fa fa-home"></i></a></li>
        <li><span>{{ __('bipolar.blog.blog_posts') }}</span></li>
      </ul>
    </div>
  </div>
  <section class="posts-wrapper">
    <section class="container">
      <section class="row clearfix">
        <section class="col-md-9 posts">
          @foreach($posts as $post)
            <?php /** @var \App\Models\Post $post */ ?>
            <article>
              <header><a href="#">{{ $post->title }}</a></header>
              <nav class="meta">
                <span><img class="svg" src="{{ asset('/images/users.svg') }}" alt="Author"> Bipolar</span>
                <span><img class="svg" src="{{ asset('/images/clock.svg') }}" alt="Author"> {{ $post->created_at->format('j F Y') }}</span>
                <span><img class="svg" src="{{ asset('/images/ribbon.svg') }}" alt="Author"> {{ $post->categories->implode('name', ', ') }}</span>
              </nav>
              <section class="post-images">
                <div class="owl-carousel-blog owl-carousel owl-theme">
                  @foreach($post->photos as $photo)
                    <img class="img-responsive" src="{{ $photo->url }}" alt="{{ $post->title }}">
                  @endforeach
                </div>
              </section>
              <footer>
                {{ str_limit(strip_tags($post->content), 50) }}
                @if (strlen(strip_tags($post->content)) > 50)
                  <a class="btn btn-dark-rounded">{{ __('bipolar.blog.read_more') }}</a>
                @endif
              </footer>
            </article>
          @endforeach
          {!! $posts->links('web.partials.pagination-blog') !!}
        </section>
        <aside class="post-sidebars col-md-3 hidden-sm hidden-xs">
          <article>
            <header>{{ __('bipolar.blog.recent_posts') }}</header>
            @if($lastPosts->count() > 0)
              <ul>
                @foreach($lastPosts as $post)
                  <li><a href="#">{{ $post->title }}</a></li>
                @endforeach
              </ul>
            @endif
          </article>
          <article>
            <header>{{ __('bipolar.blog.archives') }}</header>
          </article>
          <article>
            <header>{{ __('bipolar.blog.categories') }}</header>
            @if($categories->count() > 0)
              <ul>
                @foreach($categories as $category)
                  <li><a href="#">{{ $category->name }}</a></li>
                @endforeach
              </ul>
            @endif
          </article>
          <article>
            <header>{{ __('bipolar.blog.tags') }}</header>
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