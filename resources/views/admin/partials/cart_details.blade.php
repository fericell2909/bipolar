<div class="modal fade" id="cart_details_{{ $cart->id }}" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Contenido de carrito</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              @foreach($cart->details as $detail)
                <?php /** @var \App\Models\CartDetail $detail */ ?>
                <tr>
                  <td>{{ $detail->product->name }}</td>
                  <td>{{ $detail->quantity }}</td>
                  <td>S/ {{ $detail->total }} | $ {{ $detail->total_dolar }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>