import swal from "sweetalert2";

$(function() {
  $('.address-billing-option').click(function () {
    const addressId = $(this).val();
    
    $.post(`ajax/address/${addressId}/main`)
      .done(() => {
        $('#sectionCollapseOne').collapse('hide');
        $('#sectionCollapseTwo').collapse('show');
      });
  });

  $('.address-shipping-option').click(function () {
    const addressId = $(this).val();

    $.post(`ajax/address/${addressId}/main`)
      .done(() => {
        $('#sectionCollapseTwo').collapse('hide');
        $('#sectionCollapseThree').collapse('show');
      });
  });

  $('input[name="send-distinct-address"]').click(function () {
    $('#form-new-shipping-address').toggle();
    $('#checkoutContinuePartThree').toggle();
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

  $('#checkoutContinuePartThree').click(function () {
    $('#sectionCollapseOne').collapse('hide');
    $('#sectionCollapseTwo').collapse('hide');
    $('#sectionCollapseThree').collapse('show');
  });

  $('#checkout-form').submit(function (event) {
    const terms = $('input[name="terms"]');
    if (terms.is(':checked') === false) {
      $('#terms-check').show();
      return event.preventDefault();
    }
  });
});