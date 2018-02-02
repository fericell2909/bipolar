@extends('admin.layouts.app_admin')
@section('content')
<div class="row thin-steps">
  <a href="{{ route('settings.shipping.edit', $shipping->id) }}" class="col-md-6 column-step start">
      <div class="step-number">1</div>
      <div class="step-title">Editar shipping</div>
  </a>
  <a href="{{ route('settings.shipping.edit.price', $shipping->id) }}" class="col-md-6 column-step active">
      <div class="step-number">2</div>
      <div class="step-title">Precios</div>
  </a>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="white-box">
      {!! Form::open() !!}
      <h3 class="box-title">Editar precios de zona de envío {{ $shipping->title }}</h3>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <td>Cantidad</td>
              <td>Precio x cantidad</td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><strong>200g</strong></td>
              <td>{!! Form::number('g200', $shipping->g200, ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
            <tr>
              <td><strong>500g</strong></td>
              <td>{!! Form::number('g500', $shipping->g500, ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
            <tr>
              <td><strong>1kg</strong></td>
              <td>{!! Form::number('kg1', $shipping->kg1, ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
            <tr>
              <td><strong>2kg</strong></td>
              <td>{!! Form::number('kg2', $shipping->kg2, ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
            <tr>
              <td><strong>3kg</strong></td>
              <td>{!! Form::number('kg3', $shipping->kg3, ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
            <tr>
              <td><strong>4kg</strong></td>
              <td>{!! Form::number('kg4', $shipping->kg4, ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
            <tr>
              <td><strong>5kg</strong></td>
              <td>{!! Form::number('kg5', $shipping->kg5, ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
            <tr>
              <td><strong>6kg</strong></td>
              <td>{!! Form::number('kg6', $shipping->kg6, ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
            <tr>
              <td><strong>7kg</strong></td>
              <td>{!! Form::number('kg7', $shipping->kg7, ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
            <tr>
              <td><strong>8kg</strong></td>
              <td>{!! Form::number('kg8', $shipping->kg8, ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
            <tr>
              <td><strong>9kg</strong></td>
              <td>{!! Form::number('kg9', $shipping->kg9, ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
            <tr>
              <td><strong>10kg</strong></td>
              <td>{!! Form::number('kg10', $shipping->kg10, ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <button type="submit" class="btn btn-sm btn-dark btn-rounded">Guardar</button>
      {!! Form::close() !!}
    </div>
  </div>
</div>
@endsection