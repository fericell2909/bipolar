$(function() {
  $('.address-billing-option').click(function () {
    const addressId = $(this).val();

    $.post(`ajax/address/${addressId}/main`)
      .done(() => console.log('guardado'));
  });
});