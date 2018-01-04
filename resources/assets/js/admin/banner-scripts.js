import swal from "sweetalert2";

$(function () {
  const $deleteBanner = $(".delete-banner");

  if ($deleteBanner.length) {
    $deleteBanner.on('click', function () {
      swal({
        title: 'Eliminar banner',
        text: 'Seguro que desea eliminar',
        type: 'question',
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        showLoaderOnConfirm: true,
      }).then(result => {
        if (result.value) {
          const bannerId = $(this).data('bannerId');
          $.ajax({
            method: 'DELETE',
            url: `/ajax-admin/banners/${bannerId}`
          }).done(() => location.reload());
        }
      });
    });
  }
});