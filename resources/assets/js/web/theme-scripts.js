import CountUp from 'countup.js';

require('icheck');

$(function () {
  // Owl Carousel scripts
  let thumbs = 5;
  let duration = 300;

  let owlMain = $('.owl-carousel-main').owlCarousel({
    items: 1,
    onDragged: draggedOwlMain,
  });
  let owlThumbnail = $('.owl-carousel-thumbnails').owlCarousel({
    margin: 10,
    items: thumbs,
  });

  function draggedOwlMain(event) {
    owlMain.trigger('to.owl.carousel', [event.item.index, duration, true]);
  }

  owlThumbnail.on('click', '.owl-item', function () {
    let index = $(this).index();
    owlMain.trigger('to.owl.carousel', [index, duration, true]);
    owlThumbnail.trigger('to.owl.carousel', [index, duration, true]);
  });

  // Historic change image
  $('#showHistoricModal').on('show.bs.modal', function (event) {
    const $button = $(event.relatedTarget);
    const imageUrl = $button.data('imageUrl');

    $('.image-historic-preview').attr('src', imageUrl);
  });

  // Scroll header function
  $(function () {
    $(document).scroll(function () {
      const $transparentHeader = $('.bipolar-header-desktop');
      const $grandHeader = $(".bipolar-grand-header");
      const $bipolarNavigation = $grandHeader.children('.bipolar-navigation');
      const $container = $bipolarNavigation.children('.container');
      const $logoInHeader = $container.find('.bipolar-logo');
      //let $grandHeaderAlternate = $('.bipolar-alternate-grand-header');
      const isLongScroll = $(this).scrollTop() > $grandHeader.height();
      const homeIsLongScroll = $(this).scrollTop() > $transparentHeader.height();
      if (isLongScroll === true || homeIsLongScroll === true) {
        $transparentHeader.addClass('hidden');
        $grandHeader.addClass('bipolar-grand-header-hidden');
        $logoInHeader.removeClass('hidden');
        $container.removeClass('resized-container');
        $bipolarNavigation.addClass('has-shadow').addClass('has-background');
        //$grandHeaderAlternate.removeClass('hidden');
      } else {
        $transparentHeader.removeClass('hidden');
        $grandHeader.removeClass('bipolar-grand-header-hidden');
        $logoInHeader.addClass('hidden');
        $container.addClass('resized-container');
        $bipolarNavigation.removeClass('has-shadow').removeClass('has-background');
        //$grandHeaderAlternate.addClass('hidden');
      }
    });
  });

  $('.bipolar-item').hover(function () {
    $(this).children('a').children('.the-line').addClass('is-active');
  }, function () {
    $(this).children('a').children('.the-line').removeClass('is-active');
  });

  // Bootstrap tooltip
  $('[data-toggle="tooltip"]').tooltip();

  if ($('.bipolar-counts-title').length) {
    const $firstCounter = $('#bipolar-first-counter');
    const $secondCounter = $('#bipolar-second-counter');
    const counterOptions = {
      useEasing: true,
      useGrouping: true,
      separator: '',
      decimal: '.',
    };

    $.get('https://graph.facebook.com/bipolar.zapatos/?fields=fan_count&access_token=100210840716931|hxQGZTOgdjwE1zG8tDKwyN7Fvy0')
      .done(response => {
        const firstCounter = new CountUp('bipolar-first-counter', 0, $firstCounter.data('number'), 0, 2.5, counterOptions);
        const secondCounter = new CountUp('bipolar-second-counter', 0, response['fan_count'], 0, 2.5, counterOptions);

        firstCounter.start();
        secondCounter.start();
      });
  }
});
