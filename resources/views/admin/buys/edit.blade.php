@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\Buy $buy */ ?>
@section('title', "Editar compra {$buy->id} de {$buy->user->name} ({$buy->user->email})")
@section('content')
 <div class="card">
   <div class="card-body">
      {!! Form::open() !!}
        <div class="row">
          <div class="col-6 form-group">
            <label>Shipping fee</label>
            {!! Form::text('shipping_fee', $buy->shipping_fee, ['class' => 'form-control']) !!}
          </div>
          <div class="col-6 form-group">
            <label>Total (compra hecha en {{ $buy->currency }})</label>
            {!! Form::text('total', $buy->total, ['class' => 'form-control']) !!}
          </div>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-sm btn-dark btn-rounded">Guardar</button>
        </div>
      {!! Form::close() !!}
   </div>
 </div>
@endsection