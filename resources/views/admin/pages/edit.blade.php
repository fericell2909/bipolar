@extends('admin.layouts.app_admin')
@section('title', 'Editar página')
@push('before_scripts')
  <script>
    window.BipolarPageId = "{{ $page->id }}";
  </script>
@endpush
@section('content')
  <div id="bipolar-edit-page"></div>
@endsection