const tippy = require('tippy.js');

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
});