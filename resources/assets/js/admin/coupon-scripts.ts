import swal from 'sweetalert2';

$(function() {
  const $deleteCoupon = $('.delete-coupon');

  if ($deleteCoupon.length) {
    $deleteCoupon.on('click', function() {
      swal({
        title: 'Eliminar cupón',
        text: 'Seguro que desea eliminar',
        type: 'question',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
      }).then(result => {
        if (result.value) {
          const couponId = $(this).data('couponId');
          $.ajax({
            method: 'DELETE',
            url: `/ajax-admin/coupons/${couponId}`,
          }).done(response => {
            if (response.success) {
              location.reload();
            } else {
              swal('Error', response.message, 'error');
            }
          });
        }
      });
    });
  }
});
