$(function () {
  if ($(".singledatepicker").length) {
    $(".singledatepicker").daterangepicker({
      singleDatePicker: true,
      timePicker: true,
      timePicker24Hour: true,
      buttonClasses: "btn btn-sm btn-rounded",
      locale: {
        format: 'YYYY-MM-DD HH:mm'
      },
    });
  }
});