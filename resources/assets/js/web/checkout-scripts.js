import swal from "sweetalert2";

$(function() {
  $('#form-coupon').submit(function (event) {
    event.preventDefault();
    const params = $(this).serializeArray();
    $.post(`/ajax/coupon`, params)
      .done(() => {
        $('#alert-coupon').hide();
        return window.location.reload();
      })
      .fail(error => {
        if (error.status === 400) {
          const response = error.responseJSON;
          if (response['message']) {
            $('#alert-coupon').show().html(response['message']);
          }
        }
      });
  });

  $('#button-remove-coupon').click(function () {
    $.post('/ajax/coupon-remove')
      .done(() => window.location.reload())
      .fail(error => {
        if (error.status === 400) {
          const response = error.responseJSON;
          if (response['message']) {
            $('#alert-coupon').show().html(response['message']);
          }
        }
      });
  });

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

  $('#sectionCollapseOne, #sectionCollapseTwo, #sectionCollapseThree')
    .on('show.bs.collapse', event => {
      const headingId = $(event.currentTarget).attr('aria-labelledby');
      const heading = $(`#${headingId}`);
      heading.removeClass('content-collapsed');
      heading.children('.panel-icon').html("<i class='fa fa-chevron-up'></i>");
    })
    .on('hide.bs.collapse', event => {
      const headingId = $(event.currentTarget).attr('aria-labelledby');
      const heading = $(`#${headingId}`);
      heading.addClass('content-collapsed');
      heading.children('.panel-icon').html("<i class='fa fa-chevron-down'></i>");
    });

  $('#checkout-form').submit(function (event) {
    const terms = $('input[name="terms"]');
    if (terms.is(':checked') === false) {
      $('#terms-check').show();
      return event.preventDefault();
    }
  });
});