@extends('web.layouts.app_web') 
@section('content')
<div class="background-title-image">
	<h1>Checkout</h1>
</div>
<div class="container bipolar-checkout">
	<div class="row">
		<div class="col-md-3">
			@if($cart->coupon)
				<div class="content-coupon">
          <p>{{ __('bipolar.checkout.coupon') }} {{ $cart->coupon->code }}</p>
          <button type="button" id="button-remove-coupon" class="btn btn-dark-rounded">{{ __('bipolar.checkout.remove') }}</button>
				</div>
			@else
				<div id="alert-coupon" class="alert alert-danger" style="display: none;"></div>
				{!! Form::open(["id" => 'form-coupon', 'class' => 'form-coupon']) !!}
					{!! Form::label(__('bipolar.checkout.have_coupon')) !!}
					{!! Form::text('coupon_name', null, ['class' => 'form-control', 'placeholder' => __('bipolar.checkout.coupon_code'), 'autocomplete' => 'off', 'required']) !!}
					<button type="submit" class="btn btn-dark-rounded">{{ __('bipolar.checkout.apply_coupon') }}</button>
				{!! Form::close() !!}
				@endif
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
					<div class="panel-heading {{ !Request::has('part') ? null : 'content-collapsed' }}" role="tab" id="headingOne">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#sectionCollapseOne" aria-expanded="true" aria-controls="sectionCollapseOne">
								{{ __('bipolar.checkout.billing_address') }}
							</a>
						</h4>
						<div class="panel-icon"><i class="fa fa-chevron-down"></i></div>
					</div>
					<div id="sectionCollapseOne" class="panel-collapse collapse {{ !Request::has('part') ? 'in' : null }}" role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body">
							@foreach($billingAddresses as $billingAddress)
								<div class="address-list">
									<div class="first-part">
										<div class="pretty p-default p-round p-thick">
											{!! Form::radio('address_billing', $billingAddress->hash_id, $billingAddress->main, ['class' => 'address-list-option address-billing-option']) !!}
											<div class="state p-primary-o">
												<label class="address-list-title">
													<span>{{ $billingAddress->name }} {{ $billingAddress->lastname }}</span>
												</label>
											</div>
										</div>
										<div class="address-list-content">
											<ul class="address-list-of-lists">
												<li>{{ $billingAddress->address }}</li>
												<li>{{ $billingAddress->country_state->name }}</li>
												<li>{{ $billingAddress->country_state->country->name }}</li>
												<li>{{ $billingAddress->phone }}</li>
											</ul>
										</div>
									</div>
									<div class="second-part">
										<div class="trash-icon" data-address-hash-id="{{ $billingAddress->hash_id }}">
											<a><img src="{{ asset('images/trash.svg') }}" width="20" alt="Eliminar"></a>
										</div>
									</div>
								</div>
							@endforeach
							{!! Form::open(['url' => route('address.add', 'billing')]) !!}
								<div id="form-add-billing-address" style="display:none" class="row">
									<div class="form-group col-md-6">
										{!! Form::label(__('bipolar.form_fields.firstname')) !!}
										{!! Form::text('name', null, ['class' => 'form-control', 'required' => true, 'autocomplete' => 'off']) !!}
									</div>
									<div class="form-group col-md-6">
										{!! Form::label(__('bipolar.form_fields.lastname')) !!}
										{!! Form::text('lastname', null, ['class' => 'form-control', 'required' => true, 'autocomplete' => 'off']) !!}
									</div>
									<div class="form-group col-md-6">
										{!! Form::label(__('bipolar.form_fields.email')) !!}
										{!! Form::text('email', null, ['class' => 'form-control', 'required' => true, 'autocomplete' => 'off']) !!}
									</div>
									<div class="form-group col-md-6">
										{!! Form::label(__('bipolar.form_fields.phone')) !!}
										{!! Form::text('phone', null, ['class' => 'form-control', 'required' => true, 'autocomplete' => 'off']) !!}
									</div>
									<div class="form-group col-md-6">
										{!! Form::label(__('bipolar.form_fields.country')) !!}
										<select name="country" id="" class="form-control select-2-countries" autocomplete="off">
											<option disabled selected>{{ __('bipolar.checkout.select') }}</option>
											@foreach($countries as $countryId => $countryName)
												<option value="{{ $countryId }}">{{ $countryName }}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group col-md-6">
										{!! Form::label(__('bipolar.form_fields.city')) !!}
										{!! Form::select('state', [], null, ['class' => 'form-control select-2-country-states', 'required' => true, 'autocomplete' => 'off']) !!}
										{!! Form::hidden('country_state_billing_hidden', null, ['id' => 'country_state_billing_hidden']) !!}
									</div>
									<div class="form-group col-md-6">
										{!! Form::label(__('bipolar.form_fields.address')) !!}
										{!! Form::text('address', null, ['class' => 'form-control', 'required' => true, 'autocomplete' => 'off']) !!}
									</div>
									<div class="form-group col-md-6">
										{!! Form::label(__('bipolar.form_fields.zip')) !!}
										{!! Form::text('zip', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
									</div>
								</div>
								<div class="text-center">
									<button type="button" id="button-add-billing-address" class="btn btn-bipolar-rounded">Agregar otra dirección</button>
									<button type="submit" id="checkoutContinuePartTwo" class="btn btn-dark-rounded">{{ __('bipolar.checkout.continue') }}</button>
								</div>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading {{ Request::input('part') === "2" ? null : 'content-collapsed' }}" role="tab" id="headingTwo">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#sectionCollapseTwo" aria-expanded="false"
							 aria-controls="collapseTwo">
								{{ __('bipolar.checkout.shipping_address') }}
							</a>
						</h4>
						<div class="panel-icon"><i class="fa fa-chevron-down"></i></div>
					</div>
					<div id="sectionCollapseTwo" class="panel-collapse collapse {{ Request::input('part') === "2" ? 'in' : null }}" role="tabpanel" aria-labelledby="headingTwo">
						<div class="panel-body">
							<div id="bipolar-directions"></div>
              <div class="send-distinct-address">
                <label>{{ __('bipolar.checkout.another_address') }}</label> {!! Form::checkbox('send-distinct-address', '1') !!}
              </div>
							@foreach($shippingAddresses as $shippingAddress)
								<div class="address-list">
									<div class="first-part">
										<div class="pretty p-default p-round p-thick">
											{!! Form::radio('address_shipping', $shippingAddress->hash_id, $shippingAddress->main, ['class' => 'address-list-option address-shipping-option']) !!}
											<div class="state p-primary-o">
												<label class="address-list-title">
													<span>{{ $shippingAddress->name }} {{ $shippingAddress->lastname }}</span>
												</label>
											</div>
										</div>
										<div class="address-list-content">
											<ul class="address-list-of-lists">
												<li>{{ $shippingAddress->address }}</li>
												<li>{{ $shippingAddress->country_state->name }}</li>
												<li>{{ $shippingAddress->country_state->country->name }}</li>
												<li>{{ $shippingAddress->phone }}</li>
											</ul>
										</div>
									</div>
									<div class="second-part">
										<div class="trash-icon">
											<a href="#"><img src="{{ asset('images/trash.svg') }}" width="20" alt="Eliminar"></a>
										</div>
									</div>
								</div>
							@endforeach
							{!! Form::open(['url' => route('address.add', 'shipping'), 'id' => 'form-new-shipping-address', 'style' => 'display:none']) !!}
							<div class="row">
								<div class="form-group col-md-6">
									{!! Form::label(__('bipolar.form_fields.firstname')) !!}
									{!! Form::text('name', null, ['class' => 'form-control', 'required' => true, 'autocomplete' => 'off']) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label(__('bipolar.form_fields.lastname')) !!}
									{!! Form::text('lastname', null, ['class' => 'form-control', 'required' => true, 'autocomplete' => 'off']) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label(__('bipolar.form_fields.email')) !!}
									{!! Form::text('email', null, ['class' => 'form-control', 'required' => true, 'autocomplete' => 'off']) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label(__('bipolar.form_fields.email')) !!}
									{!! Form::text('phone', null, ['class' => 'form-control', 'required' => true, 'autocomplete' => 'off']) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label(__('bipolar.form_fields.country')) !!}
									<select name="country" id="" class="select-2-countries-shipping form-control" required autocomplete="off">
										<option selected disabled>{{ __('bipolar.checkout.select') }}</option>
										@foreach($countries as $countryId => $countryName)
											<option value="{{ $countryId }}">{{ $countryName }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group col-md-6">
									{!! Form::label(__('bipolar.form_fields.city')) !!}
									{!! Form::select('state', [], null, ['class' => 'select-2-country-states-shipping form-control', 'required' => true, 'autocomplete' => 'off']) !!}
									{!! Form::hidden('country_state_shipping_hidden', null, ['id' => 'country_state_shipping_hidden']) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label(__('bipolar.form_fields.address')) !!}
									{!! Form::text('address', null, ['class' => 'form-control', 'required' => true, 'autocomplete' => 'off']) !!}
								</div>
								<div class="form-group col-md-6">
									{!! Form::label(__('bipolar.form_fields.zip')) !!}
									{!! Form::text('zip', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
								</div>
							</div>
              <div class="text-center">
                <button type="submit" class="btn btn-dark-rounded">{{ __('bipolar.checkout.continue') }}</button>
              </div>
							{!! Form::close() !!}
              <div class="text-center">
                <button type="button" class="btn btn-dark-rounded" id="checkoutContinuePartThree">{{ __('bipolar.checkout.continue') }}</button>
              </div>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading {{ Request::input('part') === '3' ? null : 'content-collapsed' }}" role="tab" id="headingThree">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#sectionCollapseThree" aria-expanded="false"
							 aria-controls="collapseThree">
								{{ __('bipolar.checkout.your_order') }}
							</a>
						</h4>
						<div class="panel-icon"><i class="fa fa-chevron-down"></i></div>
					</div>
					<div id="sectionCollapseThree" class="panel-collapse collapse {{ Request::input('part') === '3' ? 'in' : null }}" role="tabpanel" aria-labelledby="headingThree">
						<div class="panel-body centered">
							<table class="table-review-order">
                <thead>
                  <tr>
                    <th>{{ __('bipolar.confirmation.product') }}</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php /** @var \App\Models\Cart $cart */ ?>
                  @foreach($cart->details as $cartDetail)
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
                  @if($cart->coupon)
                    <tr>
                      <td class="total">Cupón {{ $cart->coupon->code }} : {{ $cart->coupon->discount_format }}</td>
                      <td><span class="amount">-{{ $cart->total_discount_coupon }}</span></td>
                    </tr>
                  @endif
                  <tr>
                    <td class="total">Subtotal</td>
                    <td><span class="amount">{{ $cart->subtotal_currency }}</span></td>
                  </tr>
									<tr>
										<td class="total">{{ __('bipolar.checkout.shipping') }}</td>
										<td class="shipping-pickers">
											<div class="picker">{!! Form::radio('shipping_pick', 'free', false, ['required']) !!} {{ __('bipolar.checkout.showroom_shipping') }}</div>
											<div class="picker">
												{!! Form::radio('shipping_pick', 'pay', false, ['required']) !!}
                        <div class="shipping-explanation">
                          <span>{{ $shippingName }}:</span>
                          <span>{{ $shippingFee }}</span>
                        </div>
											</div>
										</td>
									</tr>
                  <tr>
                    <td class="total">Total</td>
                    <td><span class="amount">{{ $cart->total_currency }}</span></td>
                  </tr>
                </tbody>
							</table>
							<div class="bipolar-alert-message" id="terms-check" style="display: none;">
								<i class="fa fa-times-circle-o"></i>
								<div class="success-content">
									<span>{{ __('bipolar.checkout.terms_check') }}</span>
								</div>
							</div>
							<div class="bipolar-alert-message" id="shipping-check" style="display: none;">
								<i class="fa fa-times-circle-o"></i>
								<div class="success-content">
									<span>{{ __('bipolar.checkout.shipping_check') }}</span>
								</div>
							</div>
							{!! Form::open(['id' => 'checkout-form']) !!}
								<div class="submit-payment">
									<button type="submit" class="btn btn-dark-rounded">{{ __('bipolar.checkout.continue') }}</button>
									{!! Form::hidden('showroom_pick') !!}
									<p>
										{!! Form::checkbox('terms', '1', null) !!}
										<label for="terms">{!! __('bipolar.checkout.terms_accept') !!}</label>
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
@endsection