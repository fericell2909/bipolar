@extends('web.layouts.app_web') 
@section('content')
<div class="background-title-image">
	<h1>Checkout</h1>
</div>
<div class="container bipolar-checkout">
	<div class="row">
		<div class="col-md-3">

		</div>
		<div class="col-md-9">
			{!! Form::open() !!}
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								Dirección de facturación
							</a>
						</h4>
					</div>
					<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body">
							{!! Form::open() !!}
							<div class="row">
								<div class="form-group col-md-6">
									{!! Form::label('Nombre') !!}
									{!! Form::text('name', null, ['class' => 'form-control']) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Apellidos') !!}
									{!! Form::text('lastname', null, ['class' => 'form-control']) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Correo') !!}
									{!! Form::text('email', null, ['class' => 'form-control']) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Teléfono') !!}
									{!! Form::text('phone', null, ['class' => 'form-control']) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('País') !!}
									{!! Form::text('country', null, ['class' => 'form-control']) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Estado') !!}
									{!! Form::text('state', null, ['class' => 'form-control']) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Address') !!}
									{!! Form::text('address', null, ['class' => 'form-control']) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Código zip') !!}
									{!! Form::text('zip', null, ['class' => 'form-control']) !!}
								</div>
							</div>
							<div class="text-center">
								{!! Form::submit('Guardar', ['class' => 'btn btn-dark-rounded']) !!}
								<button type="button" class="btn btn-dark-rounded">Continuar</button>
							</div>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingTwo">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false"
							 aria-controls="collapseTwo">
								Dirección de envío
							</a>
						</h4>
					</div>
					<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
						<div class="panel-body">
							<div id="bipolar-directions"></div>
							<div class="row">
								<div class="form-group col-md-6">
									{!! Form::label('Nombre') !!}
									{!! Form::text('name', null, ['class' => 'form-control']) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Apellidos') !!}
									{!! Form::text('lastname', null, ['class' => 'form-control']) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Correo') !!}
									{!! Form::text('email', null, ['class' => 'form-control']) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Teléfono') !!}
									{!! Form::text('phone', null, ['class' => 'form-control']) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('País') !!}
									{!! Form::text('country', null, ['class' => 'form-control']) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Estado') !!}
									{!! Form::text('state', null, ['class' => 'form-control']) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Address') !!}
									{!! Form::text('address', null, ['class' => 'form-control']) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Código zip') !!}
									{!! Form::text('zip', null, ['class' => 'form-control']) !!}
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingThree">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false"
							 aria-controls="collapseThree">
								Tu pedido
							</a>
						</h4>
					</div>
					<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
						<div class="panel-body centered">
							<table class="table-review-order">
                <thead>
                  <tr>
                    <th>Producto</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach(CartBipolar::content() as $cartDetail)
                  <tr>
                    <td class="product-name">
                      {{ $cartDetail->product->name }} x {{ $cartDetail->quantity }}
                      @if($cartDetail->stock)
                      <dt class="stock-variation">
                        Talla: {{ $cartDetail->stock->size->name }}
                      </dt>
                      @endif
                    </td>
                    <td><span class="amount">{{ $cartDetail->total_currency }}</span></td>
                  </tr>
                  @endforeach
                  <tr>
                    <td class="total">Subtotal</td>
                    <td><span class="amount">{{ CartBipolar::totalCurrency() }}</span></td>
                  </tr>
                  <tr>
                    <td class="total">Total</td>
                    <td><span class="amount">{{ CartBipolar::totalCurrency() }}</span></td>
                  </tr>
                </tbody>
              </table>
              <div class="payment-method">
                {!! Form::radio('payment', '1') !!} <span class="checkbox-content">Tarjeta de crédito o débito</span>
              </div>
              <div class="submit-payment">
                <button type="submit" class="btn btn-rounded btn-dark">Pagar</button>
                <p>
                  {!! Form::checkbox('terms', '1') !!}
                  <label for="terms">He leído y acepto los <a href="#">términos y condiciones</a></label>
                </p>
              </div>
						</div>
					</div>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection