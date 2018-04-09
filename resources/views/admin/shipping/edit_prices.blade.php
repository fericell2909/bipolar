@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\Shipping $shipping */ ?>
@section('title', "Editar precios de zona de envío {$shipping->title}")
@section('content')
  <div class="row">
    <div class="col-md">
      <a href="{{ route('settings.shipping.edit', $shipping->id) }}" class="card text-center">
        <div class="card-body">
          <h4 class="card-text">1. Zona de envío</h4>
        </div>
      </a>
    </div>
    <div class="col-md">
      <a href="{{ route('settings.shipping.edit.price', $shipping->id) }}" class="card text-center text-white bg-primary">
        <div class="card-body">
          <h4 class="card-text">2. Precios</h4>
        </div>
      </a>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      {!! Form::open() !!}
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <td>Cantidad</td>
              <td>Precio x cantidad (S/ - soles)</td>
              <td>Precio x cantidad ($ - dólares)</td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align-middle class=align-middle"><strong>200g</strong></td>
              <td class="align-middle">{!! Form::number('g200', old('g200', $shipping->g200), ['class' => 'form-control', 'step' => 'any']) !!}</td>
              <td class="align-middle">{!! Form::number('g200_dolar', old('g200_dolar', $shipping->g200_dolar), ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
            <tr>
              <td class="align-middle"><strong>500g</strong></td>
              <td class="align-middle">{!! Form::number('g500', $shipping->g500, ['class' => 'form-control', 'step' => 'any']) !!}</td>
              <td class="align-middle">{!! Form::number('g500_dolar', $shipping->g500_dolar, ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
            <tr>
              <td class="align-middle"><strong>1kg</strong></td>
              <td class="align-middle">{!! Form::number('kg1', old('kg1', $shipping->kg1), ['class' => 'form-control', 'step' => 'any']) !!}</td>
              <td class="align-middle">{!! Form::number('kg1_dolar', old('kg1_dolar', $shipping->kg1_dolar), ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
            <tr>
              <td class="align-middle"><strong>2kg</strong></td>
              <td class="align-middle">{!! Form::number('kg2', old('kg2', $shipping->kg2), ['class' => 'form-control', 'step' => 'any']) !!}</td>
              <td class="align-middle">{!! Form::number('kg2_dolar', old('kg2_dolar', $shipping->kg2_dolar), ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
            <tr>
              <td class="align-middle"><strong>3kg</strong></td>
              <td class="align-middle">{!! Form::number('kg3', old('kg3', $shipping->kg3), ['class' => 'form-control', 'step' => 'any']) !!}</td>
              <td class="align-middle">{!! Form::number('kg3_dolar', old('kg3_dolar', $shipping->kg3_dolar), ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
            <tr>
              <td class="align-middle"><strong>4kg</strong></td>
              <td class="align-middle">{!! Form::number('kg4', old('kg4', $shipping->kg4), ['class' => 'form-control', 'step' => 'any']) !!}</td>
              <td class="align-middle">{!! Form::number('kg4_dolar', old('kg4_dolar', $shipping->kg4_dolar), ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
            <tr>
              <td class="align-middle"><strong>5kg</strong></td>
              <td class="align-middle">{!! Form::number('kg5', old('kg5', $shipping->kg5), ['class' => 'form-control', 'step' => 'any']) !!}</td>
              <td class="align-middle">{!! Form::number('kg5_dolar', old('kg5_dolar', $shipping->kg5_dolar), ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
            <tr>
              <td class="align-middle"><strong>6kg</strong></td>
              <td class="align-middle">{!! Form::number('kg6', old('kg6', $shipping->kg6), ['class' => 'form-control', 'step' => 'any']) !!}</td>
              <td class="align-middle">{!! Form::number('kg6_dolar', old('kg6_dolar', $shipping->kg6_dolar), ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
            <tr>
              <td class="align-middle"><strong>7kg</strong></td>
              <td class="align-middle">{!! Form::number('kg7', old('kg7', $shipping->kg7), ['class' => 'form-control', 'step' => 'any']) !!}</td>
              <td class="align-middle">{!! Form::number('kg7_dolar', old('kg7_dolar', $shipping->kg7_dolar), ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
            <tr>
              <td class="align-middle"><strong>8kg</strong></td>
              <td class="align-middle">{!! Form::number('kg8', old('kg8', $shipping->kg8), ['class' => 'form-control', 'step' => 'any']) !!}</td>
              <td class="align-middle">{!! Form::number('kg8_dolar', old('kg8_dolar', $shipping->kg8_dolar), ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
            <tr>
              <td class="align-middle"><strong>9kg</strong></td>
              <td class="align-middle">{!! Form::number('kg9', old('kg9', $shipping->kg9), ['class' => 'form-control', 'step' => 'any']) !!}</td>
              <td class="align-middle">{!! Form::number('kg9_dolar', old('kg9_dolar', $shipping->kg9_dolar), ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
            <tr>
              <td class="align-middle"><strong>10kg</strong></td>
              <td class="align-middle">{!! Form::number('kg10', old('kg10', $shipping->kg10), ['class' => 'form-control', 'step' => 'any']) !!}</td>
              <td class="align-middle">{!! Form::number('kg10_dolar', old('kg10_dolar', $shipping->kg10_dolar), ['class' => 'form-control', 'step' => 'any']) !!}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <button type="submit" class="btn btn-sm btn-dark btn-rounded">
        <i class="fas fa-fw fa-cloud-upload-alt"></i> Guardar
      </button>
      {!! Form::close() !!}
    </div>
  </div>
@endsection