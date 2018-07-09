@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\Post $post */ ?>
@section('title', "Editar post {$post->title}")
@push('before_scripts')
  <script>
    window.BipolarPostId = "{{ $post->id }}";
  </script>
@endpush
@section('content')
  <div id="bipolar-edit-post"></div>
@endsection