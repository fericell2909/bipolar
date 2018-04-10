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

  const datePickerOptions = {
    format: 'YYYY-MM-DD HH:mm',
    icons: {
      time: 'far fa-clock',
      date: 'far fa-calendar',
      up: 'fas fa-arrow-up',
      down: 'fas fa-arrow-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right',
      today: 'far fa-calendar-check',
      clear: 'fas fa-trash',
      close: 'fas fa-times'
    }
  };

  if ($("#datepickerbegin").length) {
    $("#datepickerbegin").datetimepicker(datePickerOptions);
  }

  if ($('#datepickerend').length) {
    $("#datepickerend").datetimepicker(datePickerOptions);
  }
});