@extends('web.layouts.app_web')
@section('content')
  @include('web.partials.newsletter', ['settings' => \App\Models\Settings::first(), 'showBackground' => true])
@endsection