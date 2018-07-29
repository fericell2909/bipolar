import swal from "sweetalert2";

const showCheckoutPartTwo = () => {
  $('#sectionCollapseOne').collapse('hide');
  $('#sectionCollapseTwo').collapse('show');
};

const clickedBillingAddress = addressId => {
  return $.post(`ajax/address/${addressId}/main`)
    .done(response => {
      if (response['shipping_fee'] !== undefined && response['shipping_name'] !== undefined) {
        $('#checkout-shipping-fee').html(`<span>${response['shipping_name']}</span><span>${response['shipping_fee']}</span>`);
      }
      showCheckoutPartTwo();
    });
};

const clickedShippingAddress = addressId => {
  return $.post(`ajax/address/${addressId}/main`)
    .done(response => {
      if (response['shipping_fee'] !== undefined && response['shipping_name'] !== undefined) {
        $('#checkout-shipping-fee').html(`<span>${response['shipping_name']}</span><span>${response['shipping_fee']}</span>`);
      }
      $('#sectionCollapseTwo').collapse('hide');
      $('#sectionCollapseThree').collapse('show');
    });
};

$(function() {
  // If press Continue button submit the form or continue to the second zone
  $('#checkoutContinuePartTwo').click(event => {
    const formIsVisible = $('#form-add-billing-address').is(':visible');
    if (!formIsVisible) {
      event.preventDefault();
      showCheckoutPartTwo();
    }
  });

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
    clickedBillingAddress(addressId);
  });

  $('.address-shipping-option').click(function () {
    const addressId = $(this).val();
    clickedShippingAddress(addressId);    
  });

  $('.first-part').click(function () {
    const addressBillingRadio = $(this).find('.address-billing-option');
    const addressShippingRadio = $(this).find('.address-shipping-option');
    if (addressBillingRadio.length) {
      clickedBillingAddress(addressBillingRadio.val());
    }
    if (addressShippingRadio.length) {
      clickedShippingAddress(addressShippingRadio.val());
    }
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

  // Effects for the headers of the collapsers
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

  // Submit the checkout form
  $('#checkout-form').submit(function (event) {
    const $hiddenShipping = $('input[name="showroom_pick"]');
    if (!$hiddenShipping.val()) {
      $('#shipping-check').show();
      return event.preventDefault();
    }

    const terms = $('input[name="terms"]');
    if (terms.is(':checked') === false) {
      $('#terms-check').show();
      return event.preventDefault();
    }
  });

  // Change the shipping for the form
  $('input[name="shipping_pick"]').change(event => {
    $('#shipping-check').hide();
    return $('input[name="showroom_pick"]').val(event.target.value);
  });

  $('#button-add-billing-address').click(function () {
    $('#form-add-billing-address').toggle();
  });
});