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

  $('.btn-number').click(function () {
    const operation = $(this).data('type');
    const $quantity = $("input[name='quantity']");
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
    console.log($(this).serializeArray());
    // Check if product has sizes
    if ($('.product-sizes').length) {
      const $sizeSelected = $('#size-selected');
      if ($sizeSelected.val().trim().length === 0) {
        swal('Atención', 'Necesitas seleccionar una talla para continuar', 'warning');
      }
    }
  });
});