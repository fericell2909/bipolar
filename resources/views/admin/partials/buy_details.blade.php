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