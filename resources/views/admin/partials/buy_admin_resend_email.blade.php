<div class="modal fade" id="buy_resend_email_{{ $buy->id }}" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Reenviar correo de compra</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Deseas re-enviar correo de confirmación?
      </div>
      <div class="modal-footer">
        <a href="{{ route('buys.resend-email', $buy->id) }}" class="btn btn-dark btn-rounded">Sí, reenviar</a>
      </div>
    </div>
  </div>
</div>
