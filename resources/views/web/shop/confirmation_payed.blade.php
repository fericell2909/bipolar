@extends('web.layouts.app_web')
@section('content')
<?php /** @var \App\Models\Buy $buy */ ?>
<div class="background-order-confirmed">
  <div class="content-order-confirmed">
  <img src="{{ asset('storage/bipolar-images/assets/bag.png') }}">
    <h1>Gracias,<br> hemos recibido <br> tu pedido</h1>
    <h2>Tu número de orden es el <a href="{{ route('confirmation', $buy->id) }}">{{ $buy->id }}</a></h2>
  </div>
</div>
@endsection