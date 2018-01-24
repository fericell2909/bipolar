import swal from "sweetalert2";

$(function() {
  $('.address-billing-option').click(function () {
    const addressId = $(this).val();
    
    $.post(`ajax/address/${addressId}/main`)
      .done(() => console.log('guardado'));
  });
  
  $('.trash-icon').click(function () {
    const addressId = $(this).data('addressHashId');
    swal({
      title: 'Eliminar dirección',
      confirmButtonColor: '#000000',
      showCancelButton: true,
      cancelButtonText: 'No',
      showLoaderOnConfirm: true,
      preConfirm: result => {
        return new Promise(resolve => {
          $.ajax({
            method: 'DELETE',
            url: `ajax/address/${addressId}`,
          }).done(response => resolve(response));
        })
      }
    }).then(result => {
      if (result.value.success === true) {
        location.reload();
      }
    });
  });
});