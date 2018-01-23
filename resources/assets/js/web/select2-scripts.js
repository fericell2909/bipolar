const select2 = require('select2');

$(function() {
  const countrySelect = $('.select-2-countries').select2({width: '100%'});
  const countryStateSelect = $('.select-2-country-states').select2({width: '100%'});
  let countryStatesData = [];

  countrySelect.on('select2:select', event => {
    const selected = $(event.currentTarget).val();
    
    $.get(`/ajax/country/${selected}/country-states`)
      .done(response => countryStatesData = response)
      .then(() => {
        countryStateSelect.val(null).empty();
        countryStatesData.map(element => {
          const newOption = new Option(element.text, element.id, false, false);
          countryStateSelect.append(newOption);
        });
        countryStateSelect.trigger('change');
      });
  });

  countryStateSelect.on('select2:select', event => {
    const selected = $(event.currentTarget).val();
    $('#country_state_billing_hidden').val(selected);
  });
});