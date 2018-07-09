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
                <span><img class="svg" src="{{ asset('/images/clock.svg') }}" alt="Author"> 15 March 2019</span>
                <span><img class="svg" src="{{ asset('/images/ribbon.svg') }}" alt="Author"> Sample Text, XD</span>
              </nav>
              <section class="post-images">
                <img class="img-responsive" src="https://placehold.it/1238x812/000000/ffffff" alt="{{ $post->title }}">
              </section>
              <footer>
                <a class="btn btn-dark-rounded">Leer más</a>
              </footer>
            </article>
          @endforeach
          {!! $posts->links() !!}
        </section>
        <aside class="col-md-3 hidden-sm hidden-xs">
          This is the side bar
        </aside>
      </section>
    </section>
  </section>
</div>
@endsection