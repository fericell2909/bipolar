@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\Post $post */ ?>
@section('title', "Editar post {$post->title}")
@push('before_scripts')
  <script>
    window.BipolarPostId = "{{ $post->id }}";
  </script>
@endpush
@section('content')
  @include('admin.partials.post_header_steps', ['active' => 1])
  <div id="bipolar-edit-post"></div>
@endsection