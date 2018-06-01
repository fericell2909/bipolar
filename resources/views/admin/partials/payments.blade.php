<div class="modal fade" id="payments_{{ $buy->id }}" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Intentos de pago</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table">
          <thead>
          <tr>
            <th>#</th>
            <th>Resultado</th>
            <th>Marca de tarjeta</th>
            <th>Referencia</th>
          </tr>
          </thead>
          <tbody>
          @forelse($buy->payments as $payment)
              <?php /** @var \App\Models\Payment $payment */ ?>
              <tr>
                <td>{{ $payment->id }}</td>
                <td>{{ $payment->auth_result_text }}</td>
                <td>{{ $payment->card_brand }}</td>
                <td>{{ $payment->reference }}</td>
              </tr>
          @empty
            <tr><td colspan="4">No hay intentos de pago aún</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>