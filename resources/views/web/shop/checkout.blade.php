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
			@if($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#sectionCollapseOne" aria-expanded="true" aria-controls="sectionCollapseOne">
								Dirección de facturación
							</a>
						</h4>
					</div>
					<div id="sectionCollapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body">
							{!! Form::open(['url' => route('address.add', 'billing')]) !!}
							<div class="row">
								<div class="form-group col-md-6">
									{!! Form::label('Nombre') !!}
									{!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Apellidos') !!}
									{!! Form::text('lastname', null, ['class' => 'form-control', 'required' => true]) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Correo') !!}
									{!! Form::text('email', null, ['class' => 'form-control', 'required' => true]) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Teléfono') !!}
									{!! Form::text('phone', null, ['class' => 'form-control', 'required' => true]) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('País') !!}
									<select name="" id="" class="form-control select-2-countries">
										<option disabled selected>SELECCIONAR</option>
										@foreach($countries as $countryId => $countryName)
											<option value="{{ $countryId }}">{{ $countryName }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Estado / Ciudad') !!}
									{!! Form::select('state', [], null, ['class' => 'form-control select-2-country-states', 'required' => true]) !!}
									{!! Form::hidden('country_state_billing_hidden', null, ['id' => 'country_state_billing_hidden']) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Address') !!}
									{!! Form::text('address', null, ['class' => 'form-control', 'required' => true]) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Código zip') !!}
									{!! Form::text('zip', null, ['class' => 'form-control', 'required' => true]) !!}
								</div>
							</div>
							<div class="text-center">
								{!! Form::submit('Guardar nueva dirección', ['class' => 'btn btn-bipolar-rounded']) !!}
							</div>
							{!! Form::close() !!}
							@foreach($billingAddresses as $billingAddress)
								<div class="address-list">
									<div class="pretty p-default p-round p-thick">
										{!! Form::radio('address_billing', $billingAddress->hash_id, $billingAddress->main, ['class' => 'address-list-option address-billing-option']) !!}
										<div class="state p-primary-o">
											<label class="address-list-title">{{ $billingAddress->name }} {{ $billingAddress->lastname }}</label>
										</div>
									</div>
									<div class="address-list-content">
										<ul class="address-list-of-lists">
											<li>{{ $billingAddress->address }}</li>
											<li>{{ $billingAddress->country_state->name }}</li>
											<li>{{ $billingAddress->country_state->country->name }}</li>
											<li>{{ $billingAddress->phone }}</li>
										</ul>
										<div class="trash-icon" data-address-hash-id="{{ $billingAddress->hash_id }}">
											<a><img src="{{ asset('images/trash.svg') }}" width="20" alt="Eliminar"></a>
										</div>
									</div>
								</div>
							@endforeach
							<div class="text-center">
								<button type="button" id="checkoutContinuePartTwo" class="btn btn-rounded btn-dark">Continuar</button>
							</div>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingTwo">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#sectionCollapseTwo" aria-expanded="false"
							 aria-controls="collapseTwo">
								Dirección de envío
							</a>
						</h4>
					</div>
					<div id="sectionCollapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
						<div class="panel-body">
							<div id="bipolar-directions"></div>
							{!! Form::open(['url' => route('address.add', 'shipping')]) !!}
							<div class="row">
								<div class="form-group col-md-6">
									{!! Form::label('Nombre') !!}
									{!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Apellidos') !!}
									{!! Form::text('lastname', null, ['class' => 'form-control', 'required' => true]) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Correo') !!}
									{!! Form::text('email', null, ['class' => 'form-control', 'required' => true]) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Teléfono') !!}
									{!! Form::text('phone', null, ['class' => 'form-control', 'required' => true]) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('País') !!}
									<select name="" id="" class="select-2-countries-shipping form-control" required>
										<option selected disabled>SELECCIONAR</option>
										@foreach($countries as $countryId => $countryName)
											<option value="{{ $countryId }}">{{ $countryName }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Estado / Ciudad') !!}
									{!! Form::select('state', [], null, ['class' => 'select-2-country-states-shipping form-control', 'required' => true]) !!}
									{!! Form::hidden('country_state_shipping_hidden', null, ['id' => 'country_state_shipping_hidden']) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Address') !!}
									{!! Form::text('address', null, ['class' => 'form-control', 'required' => true]) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label('Código zip') !!}
									{!! Form::text('zip', null, ['class' => 'form-control', 'required' => true]) !!}
								</div>
							</div>
							<div class="text-center">
								{!! Form::submit('Guardar nueva dirección', ['class' => 'btn btn-bipolar-rounded']) !!}
							</div>
							{!! Form::close() !!}
							@foreach($shippingAddresses as $shippingAddress)
								<div class="address-list">
									<div class="pretty p-default p-round p-thick">
										{!! Form::radio('address_shipping', $shippingAddress->hash_id, $shippingAddress->main, ['class' => 'address-list-option']) !!}
										<div class="state p-primary-o">
												<label class="address-list-title">{{ $shippingAddress->name }} {{ $shippingAddress->lastname }}</label>
										</div>
									</div>
									<div class="address-list-content">
										<ul class="address-list-of-lists">
											<li>{{ $shippingAddress->address }}</li>
											<li>{{ $shippingAddress->country_state->name }}</li>
											<li>{{ $shippingAddress->country_state->country->name }}</li>
											<li>{{ $shippingAddress->phone }}</li>
										</ul>
										<div class="trash-icon">
											<a href="#"><img src="{{ asset('images/trash.svg') }}" width="20" alt="Eliminar"></a>
										</div>
									</div>
								</div>
							@endforeach
							<div class="text-center">
								<button type="button" id="checkoutContinuePartThree" class="btn btn-dark btn-rounded">Continuar</button>
							</div>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingThree">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#sectionCollapseThree" aria-expanded="false"
							 aria-controls="collapseThree">
								Tu pedido
							</a>
						</h4>
					</div>
					<div id="sectionCollapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
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
							{!! Form::open() !!}
								<div class="submit-payment">
									<button type="submit" class="btn btn-rounded btn-dark">Pagar</button>
									<p>
										{!! Form::checkbox('terms', '1', ['required' => true]) !!}
										<label for="terms">He leído y acepto los <a href="#">términos y condiciones</a></label>
									</p>
								</div>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	@push('js_plus')
		<script>
			$('#checkoutContinuePartTwo').click(function () {
			  $('#sectionCollapseOne').collapse('hide');
			  $('#sectionCollapseTwo').collapse('show');
			});
			$('#checkoutContinuePartThree').click(function () {
			  $('#sectionCollapseOne').collapse('hide');
			  $('#sectionCollapseTwo').collapse('hide');
			  $('#sectionCollapseThree').collapse('show');
			});
		</script>
	@endpush
@endsection