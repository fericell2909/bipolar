@extends('web.layouts.app_web')
@section('recaptcha')
  @include('web.partials.recaptcha')
@endsection
@section('content')
  @include('web.partials.newsletter', ['showBackground' => true])
@endsection