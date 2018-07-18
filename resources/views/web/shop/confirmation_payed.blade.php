@extends('web.layouts.app_web')
@section('content')
<?php /** @var \App\Models\Buy $buy */ ?>
<div class="background-order-confirmed">
  <div class="content-order-confirmed">
    <img src="https://bipolar-peru.s3.amazonaws.com/assets/bag.png">
    <h1>Gracias,<br> hemos recibido <br> tu pedido</h1>
    <h2>Tu número de orden es el <span>{{ $buy->id }}</span></h2>
  </div>
</div>
@endsection