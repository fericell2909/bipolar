@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\Product $product */ ?>
@section('title', "Variables para el cálculo de talla")
@section('content')
  <div class="card">
    <div class="card-body">
      {!! Form::open() !!}
        <label><strong>Escoge tu talla</strong></label>
        <div class="d-flex btn-group btn-group-toggle mb-3" data-toggle="buttons">
          @foreach($fitsSizes as $fit)
            <label class="btn btn-outline-dark">
              {!! Form::radio('fit_size', $fit->uuid, $product->fit_size->uuid === $fit->uuid, ['autocomplete' => 'off']) !!}
              {{ $fit->getTranslation('name', 'es') }}
            </label>
          @endforeach
        </div>
        <label><strong>Ancho</strong></label>
        <div class="d-flex btn-group btn-group-toggle mb-3" data-toggle="buttons">
          @foreach($fitsWidths as $fitWidth)
            <label class="btn btn-outline-dark">
              {!! Form::radio('fit_width', $fitWidth->uuid, $product->fit_width->uuid === $fitWidth->uuid, ['autocomplete' => 'off']) !!}
              {{ $fitWidth->getTranslation('name', 'es') }}
            </label>
          @endforeach
        </div>
        <div class="table-responsive">
         <table class="table table-primary table-borderless">
           <thead>
              <tr>
                <th></th>
                <th class="text-center">Muy angosto</th>
                <th class="text-center">Un poco angosto</th>
                <th class="text-center">Standard</th>
                <th class="text-center">Un poco ancho</th>
                <th class="text-center">Muy ancho</th>
              </tr>
           </thead>
           <tbody>
             <tr>
               <td class="align-middle">Anchura</td>
               <td class="form-group">{!! Form::number('width_very_low', $product->width_level_very_low, ['class' => 'form-control form-control-success', 'min' => '-100', 'step' => '0.01']) !!}</td>
               <td class="form-group">{!! Form::number('width_low', $product->width_level_low, ['class' => 'form-control form-control-success', 'min' => '-100', 'step' => '0.01']) !!}</td>
               <td class="form-group">{!! Form::number('width_normal', $product->width_level_normal, ['class' => 'form-control form-control-success', 'min' => '-100', 'step' => '0.01']) !!}</td>
               <td class="form-group">{!! Form::number('width_high', $product->width_level_high, ['class' => 'form-control form-control-success', 'min' => '-100', 'step' => '0.01']) !!}</td>
               <td class="form-group">{!! Form::number('width_very_high', $product->width_level_very_high, ['class' => 'form-control form-control-success', 'min' => '-100', 'step' => '0.01']) !!}</td>
             </tr>
           </tbody>
         </table>
        </div>
        <div class="table-responsive">
          <table class="table table-primary table-borderless">
            <thead>
              <tr>
                <th></th>
                <th class="text-center">Muy bajo</th>
                <th class="text-center">Un poco bajo</th>
                <th class="text-center">Standard</th>
                <th class="text-center">Un poco alto</th>
                <th class="text-center">Muy alto</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="align-middle">Empeine</td>
                <td class="form-group">{!! Form::number('instep_very_low', $product->instep_level_very_low, ['class' => 'form-control form-control-success', 'min' => '-100', 'step' => '0.01']) !!}</td>
                <td class="form-group">{!! Form::number('instep_low', $product->instep_level_low, ['class' => 'form-control form-control-success', 'min' => '-100', 'step' => '0.01']) !!}</td>
                <td class="form-group">{!! Form::number('instep_normal', $product->instep_level_normal, ['class' => 'form-control form-control-success', 'min' => '-100', 'step' => '0.01']) !!}</td>
                <td class="form-group">{!! Form::number('instep_high', $product->instep_level_high, ['class' => 'form-control form-control-success', 'min' => '-100', 'step' => '0.01']) !!}</td>
                <td class="form-group">{!! Form::number('instep_very_high', $product->instep_level_very_high, ['class' => 'form-control form-control-success', 'min' => '-100', 'step' => '0.01']) !!}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <button class="btn btn-dark" type="submit">Actualizar</button>
      {!! Form::close() !!}
    </div>
  </div>
@endsection
