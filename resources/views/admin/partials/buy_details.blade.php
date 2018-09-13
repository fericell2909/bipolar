<div class="modal fade" id="buy_details_{{ $buy->id }}" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detalles de compra</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-6">
            <h5>Datos de facturación</h5>
            <table class="table">
              <tbody>
                <tr>
                  <td><strong>Nombre - Apellido</strong></td>
                  <td>{{ $buy->billing_address->name }} {{ $buy->billing_address->lastname }}</td>
                </tr>
                <tr>
                  <td><strong>Correo - Teléfono</strong></td>
                  <td>{{ $buy->billing_address->email }} - {{ $buy->billing_address->phone }}</td>
                </tr>
                <tr>
                  <td><strong>Dirección - Zip</strong></td>
                  <td>{{ $buy->billing_address->address }} - {{ $buy->billing_address->zip }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-6">
            <h5>Datos de envío</h5>
            <table class="table">
              <tbody>
                <tr>
                  <td><strong>Nombre - Apellido</strong></td>
                  <td>{{ $buy->shipping_address->name }} {{ $buy->shipping_address->lastname }}</td>
                </tr>
                <tr>
                  <td><strong>Correo - Teléfono</strong></td>
                  <td>{{ $buy->shipping_address->email }} - {{ $buy->shipping_address->phone }}</td>
                </tr>
                <tr>
                  <td><strong>Dirección - Zip</strong></td>
                  <td>{{ $buy->shipping_address->address }} - {{ $buy->shipping_address->zip }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <table class="table">
          <thead>
            <tr>
              <th>Producto</th>
              <th>Talla</th>
              <th>Color</th>
              <th>Cantidad</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            @foreach($buy->details as $detail)
              <?php /** @var \App\Models\BuyDetail $detail */ ?>
              <tr>
                <td>{{ $detail->product->name }}</td>
                <td>{{ optional($detail->stock)->size->name ?? '--' }}</td>
                <td>{{ optional($detail->product->colors->first())->name ?? '--' }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>{{ $detail->total }} {{ $detail->buy->currency }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>