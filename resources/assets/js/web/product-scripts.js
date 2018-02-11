const tippy = require('tippy.js');
import swal from 'sweetalert2';

$(function () {
  $('.product-size').on('click', function (event) {
    event.preventDefault();
    const $sizeButton = $(this);
    $('.product-sizes>.product-size').removeClass('product-size-selected');

    $sizeButton.addClass('product-size-selected');
    $('#size-selected').val($sizeButton.data('stockHashId'));
  });

  // Add to wishlist
  $('.wishlist-add').on('click', function () {
    const productHashId = $(this).data('productId');
    $.post(`/ajax/wishlist/add/${productHashId}`)
      .done(response => {
        swal({
          title: `<span class="color-white">${response['message']}</span>`,
          background: 'black',
          toast: true,
          position: "top-right",
          showConfirmButton: false,
          timer: 3000,
          animation: false,
        });
      });
  });

  if ($('.tooltip-container').length) {
    tippy('.tooltip-container', {
      theme: 'bipolar',
      animation: 'shift-toward',
      size: 'large',
      arrow: true,
    });
  }

  $('#product-currency-select').change(function (event) {
    event.preventDefault();
    const currency = $(this).val();
    window.location.href = `/change-currency?currency=${currency}`;
  });

  $('.btn-number').on('click', function () {
    const operation = $(this).data('type');
    const $quantity = $(this).siblings(".quantity-number");
    let quantity = parseInt($quantity.val());
    if (operation === 'minus') {
      let newValue = quantity - 1;
      if (newValue <= 0) {
        newValue = 1;
      }
      $quantity.val(newValue);
    } else if (operation === 'plus') {
      $quantity.val(quantity + 1);
    }
  });

  $('#product-add-cart').submit(function (event) {
    event.preventDefault();

    if ($('.product-sizes').length) {
      const $sizeSelected = $('#size-selected');
      if ($sizeSelected.val().trim().length === 0) {
        return swal({
          title: '<span class="color-white">Necesitas seleccionar una talla para continuar</span>',
          background: 'black',
          toast: true,
          showConfirmButton: false,
          timer: 3000,
          animation: false,
        });
      }
    }

    const fields = {};
    $(this).serializeArray().map(field => {
      fields[field['name']] = field['value'];
    });

    return $.post('/ajax/cart/product', fields).done(() => location.reload());
  });
});