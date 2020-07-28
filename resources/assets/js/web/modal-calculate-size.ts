import $ from 'jquery';

$(function() {
  if ($('#size_calculate_modal').length) {
    const $commonSizeSelect = $('select[name="common_size"]');
    const $footWidth = $('select[name="foot_width"]');
    const $footInstep = $('select[name="foot_instep"]');
    const $sizeResult = $('.size-number-result');
    const $productUUID = $('#product_uuid').data('uuid');
    const calculateSize = () => {
      if (
        $commonSizeSelect.val() === null ||
        $footWidth.val() === null ||
        $footInstep.val() === null
      ) {
        return;
      }
      $.post('/ajax/calculate-size', {
        common_size: $commonSizeSelect.val(),
        foot_width: $footWidth.val(),
        foot_instep: $footInstep.val(),
        product_uuid: $productUUID,
      }).done(response => {
        if (response.success) {
          $sizeResult.text(response.result);
        }
      });
    };

    $commonSizeSelect.on('change', calculateSize);
    $footWidth.on('change', calculateSize);
    $footInstep.on('change', calculateSize);
    // For auth users
    calculateSize();
  }
});
