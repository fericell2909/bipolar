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
							Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute,
							non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt
							aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft
							beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat
							craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable
							VHS.
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
							Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute,
							non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt
							aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft
							beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat
							craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable
							VHS.
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
						<div class="panel-body">
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