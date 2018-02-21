import swal from 'sweetalert2';

$(function () {
  $('.change-to-sent-status').click(function () {
    const buyId = $(this).data('buyId');
    swal({
      title: 'Marcar como enviado',
      text: 'Seguro que desea cambiar el estado',
      type: 'question',
      showCancelButton: true,
      cancelButtonText: "Cancelar",
      showLoaderOnConfirm: true,
    }).then(result => {
      if (result.value) {
        $.ajax({
          method: 'POST',
          url: `/ajax-admin/buys/${buyId}/sent`
        }).done(() => location.reload());
      }
    })
  });
});