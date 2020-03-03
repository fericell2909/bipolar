const switcher = require('switchery/switchery');
const select2 = require('select2/dist/js/select2.full');

$(function() {
  // Select 2
  $('.select2').select2();

  // Switchery
  if ($('.js-switch').length) {
    const elem = document.querySelector('.js-switch');
    new switcher(elem, { color: '#F9967B' });
  }

  if ($('.js-switch-salient').length) {
    const elem = document.querySelector('.js-switch-salient');
    new switcher(elem, { color: '#F9967B' });
  }

  const generalDateTimeOptions = {
    icons: {
      time: 'far fa-clock',
      date: 'far fa-calendar',
      up: 'fas fa-arrow-up',
      down: 'fas fa-arrow-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right',
      today: 'far fa-calendar-check',
      clear: 'fas fa-trash',
      close: 'fas fa-times',
    },
  };
  const datePickerOptions = {
    ...generalDateTimeOptions,
    format: 'DD/MM/YYYY',
  };
  const dateTimePickerOptions = {
    ...generalDateTimeOptions,
    format: 'DD/MM/YYYY HH:mm',
  };

  const datePickerBegin = $('#datepickerbegin');
  const datePickerEnd = $('#datepickerend');

  if (datePickerBegin.length) {
    // @ts-ignore
    datePickerBegin.datetimepicker(datePickerOptions);
  }

  if (datePickerEnd.length) {
    // @ts-ignore
    datePickerEnd.datetimepicker(datePickerOptions);
  }

  if ($('#datetimepickerbegin').length) {
    // @ts-ignore
    $('#datetimepickerbegin').datetimepicker(dateTimePickerOptions);
  }

  if ($('#datetimepickerend').length) {
    // @ts-ignore
    $('#datetimepickerend').datetimepicker(dateTimePickerOptions);
  }
});
