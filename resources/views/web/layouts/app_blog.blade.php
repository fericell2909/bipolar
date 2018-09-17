@extends('web.layouts.app_web')
@section('content')
  <div class="bipolar-blog-page">
    <div class="breadcrumb-wrapper">
      <div class="container">
        <ul class="breadcrumbs">
          <li><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
          <li><span>{{ __('bipolar.blog.blog_posts') }}</span></li>
        </ul>
      </div>
    </div>
    <section class="posts-wrapper">
      <section class="container">
        <section class="row clearfix">
          <section class="col-md-9 posts">
            @yield('posts')
          </section>
          <aside class="post-sidebars col-md-3 hidden-sm hidden-xs">
            <article>
              <header>{{ __('bipolar.blog.recent_posts') }}</header>
              @if($lastPosts->count() > 0)
                <ul>
                  @foreach($lastPosts as $post)
                    <li><a href="{{ route('landings.blog.post', $post->slug) }}">{{ $post->title }}</a></li>
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
                    <?php /** @var \App\Models\Category $category */ ?>
                    <li><a href="{{ route('landings.blog', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
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