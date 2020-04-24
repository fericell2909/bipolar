import swal from 'sweetalert2';
import $ from 'jquery';

const showCheckoutPartTwo = () => {
  (<any>$('#sectionCollapseOne')).collapse('hide');
  (<any>$('#sectionCollapseTwo')).collapse('show');
};

const clickedBillingAddress = addressId => {
  return $.post(`ajax/address/${addressId}/main`).done(response => {
    if (response['shipping_fee'] !== undefined && response['shipping_name'] !== undefined) {
      $('#checkout-shipping-fee').html(
        `<span>${response['shipping_name']}</span><span>${response['shipping_fee']}</span>`
      );
    }
    showCheckoutPartTwo();
  });
};

const clickedShippingAddress = addressId => {
  return $.post(`ajax/address/${addressId}/main`).done(response => {
    if (response['shipping_fee'] !== undefined && response['shipping_name'] !== undefined) {
      $('#checkout-shipping-fee').html(
        `<span>${response['shipping_name']}</span><span>${response['shipping_fee']}</span>`
      );
    }
    const urlWithoutQuery = location.href.replace(location.search, '');
    window.location.href = `${urlWithoutQuery}?part=3`;
  });
};

$(function() {
  // If press Continue button submit the form or continue to the second zone
  $('#checkoutContinuePartTwo').on('click', event => {
    const formIsVisible = $('#form-add-billing-address').is(':visible');
    if (!formIsVisible) {
      event.preventDefault();
      showCheckoutPartTwo();
    }
  });

  $('#form-coupon').on('submit', event => {
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
            $('#alert-coupon')
              .show()
              .html(response['message']);
          }
        }
      });
  });

  $('#button-remove-coupon').on('click', () => {
    $.post('/ajax/coupon-remove')
      .done(() => window.location.reload())
      .fail(error => {
        if (error.status === 400) {
          const response = error.responseJSON;
          if (response['message']) {
            $('#alert-coupon')
              .show()
              .html(response['message']);
          }
        }
      });
  });

  $('.address-billing-option').click(function() {
    const addressId = $(this).val();
    clickedBillingAddress(addressId);
  });

  $('.address-shipping-option').on('click', () => {
    const addressId = $(this).val();
    clickedShippingAddress(addressId);
  });

  $('.first-part').on('click', () => {
    const addressBillingRadio = $(this).find('.address-billing-option');
    const addressShippingRadio = $(this).find('.address-shipping-option');
    if (addressBillingRadio.length) {
      clickedBillingAddress(addressBillingRadio.val());
    }
    if (addressShippingRadio.length) {
      clickedShippingAddress(addressShippingRadio.val());
    }
  });

  $('input[name="send-distinct-address"]').on('click', () => {
    $('#form-new-shipping-address').toggle();
    $('#checkoutContinuePartThree').toggle();
  });

  $('.trash-icon').on('click', () => {
    const addressId = $(this).data('addressHashId');
    swal({
      title: 'Eliminar dirección',
      confirmButtonColor: '#000000',
      showCancelButton: true,
      cancelButtonText: 'No',
      showLoaderOnConfirm: true,
      preConfirm: () => {
        return new Promise(resolve => {
          $.ajax({
            method: 'DELETE',
            url: `ajax/address/${addressId}`,
          }).done(response => resolve(response));
        });
      },
    }).then(result => {
      if (result.value.success === true) {
        location.reload();
      }
    });
  });

  $('#checkoutContinuePartThree').on('click', () => {
    (<any>$('#sectionCollapseOne')).collapse('hide');
    (<any>$('#sectionCollapseTwo')).collapse('hide');
    (<any>$('#sectionCollapseThree')).collapse('show');
  });

  // Prevent third zone to open if there is no address
  $('#headingThree').on('click', event => {
    if ($('.address-list').length === 0) {
      return event.stopPropagation();
    }
  });

  // Effects for the headers of the collapsers
  $('#sectionCollapseOne, #sectionCollapseTwo, #sectionCollapseThree')
    .on('show.bs.collapse', event => {
      const headingId = $(event.currentTarget).attr('aria-labelledby');
      const heading = $(`#${headingId}`);
      heading.removeClass('content-collapsed');
      heading.children('.panel-icon').html("<i class='fas fa-fw fa-chevron-up'></i>");
    })
    .on('hide.bs.collapse', event => {
      const headingId = $(event.currentTarget).attr('aria-labelledby');
      const heading = $(`#${headingId}`);
      heading.addClass('content-collapsed');
      heading.children('.panel-icon').html("<i class='fas fa-fw fa-chevron-down'></i>");
    });

  // Submit the checkout form
  $('#checkout-form').on('submit', event => {
    const $hiddenShipping = $('input[name="showroom_pick"]');
    if (!$hiddenShipping.val()) {
      $('#shipping-check').show();
      return event.preventDefault();
    } else {
      $('#shipping-check').hide();
    }

    const $dni = document.querySelector<HTMLInputElement>('input[name="dni"]');
    if ($dni !== null) {
      const $dniAlert = document.getElementById('dni-alert');
      const $dniForSubmit = document.querySelector<HTMLInputElement>('input[name="dni_hidden"]');
      if (!/^\d+$/.test($dni.value)) {
        $dniAlert.style.display = 'flex';
        return event.preventDefault();
      } else {
        $dniForSubmit.value = $dni.value;
        $dniAlert.style.display = 'none';
      }
    }

    const terms = $('input[name="terms"]');
    if (terms.is(':checked') === false) {
      $('#terms-check').show();
      return event.preventDefault();
    } else {
      $('#terms-check').hide();
    }
  });

  // Change the shipping for the form
  $<HTMLInputElement>('input[name="shipping_pick"]').on('change', event => {
    $('#shipping-check').hide();
    return $('input[name="showroom_pick"]').val(event.target.value);
  });

  $('#button-add-billing-address').on('click', () => {
    $('#form-add-billing-address').toggle();
  });
});
