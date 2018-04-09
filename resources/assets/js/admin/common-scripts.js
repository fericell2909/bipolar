const switcher = require('switchery/switchery');
const select2 = require('select2/dist/js/select2.full');

$(function () {
  // Select 2
  $('.select2').select2();

  // Switchery
  if ($('.js-switch').length) {
    const elem = document.querySelector('.js-switch');
    const init = new switcher(elem, {color: '#F9967B'});
  }

  if ($('.js-switch-salient').length) {
    const elem = document.querySelector('.js-switch-salient');
    const init = new switcher(elem, {color: '#F9967B'});
  }

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