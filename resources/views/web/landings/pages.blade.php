@extends('web.layouts.app_web')
@section('content')
  <?php /** @var \App\Models\Page $page */ ?>
  @if(!is_null($page->main_image))
    <img src="{{ $page->main_image }}" style="width: 100%;" class="img-responsive" alt="{{ $page->title }}">
  @endif
  <div class="bipolar-page-container">
    <h1>{{ $page->title }}</h1>
    {!! $page->body !!}
  </div>
@endsection