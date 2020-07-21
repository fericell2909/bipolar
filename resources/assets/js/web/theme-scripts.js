import { CountUp } from 'countup.js';

require('icheck');

// After reload, scroll to top
$(window).on('beforeunload', function() {
  $(window).scrollTop(0);
});

$(function() {
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

  owlThumbnail.on('click', '.owl-item', function() {
    let index = $(this).index();
    owlMain.trigger('to.owl.carousel', [index, duration, true]);
    owlThumbnail.trigger('to.owl.carousel', [index, duration, true]);
  });

  $('.owl-carousel-blog').owlCarousel({
    items: 1,
    nav: true,
  });

  $('.owl-carousel-home').owlCarousel({
    animateIn: 'slideInRight',
    animateOut: 'fadeOut',
    items: 1,
    nav: false,
    autoplay: true,
    autoplayTimeout: 4000,
    loop: true,
  });

  $('.owl-carousel-banner-colors').owlCarousel({
    loop: true,
    items: 1,
    autoplay: true,
    autoplayTimeout: 4000,
  });

  // Historic change image
  $('#showHistoricModal').on('show.bs.modal', function(event) {
    const $button = $(event.relatedTarget);
    const imageUrl = $button.data('imageUrl');

    $('.image-historic-preview').attr('src', imageUrl);
  });

  // Menu text works like a dropdown in mobile header
  $('.menu-text-header-mobile').click(() => {
    $('.bipolar-navbar-toggle').trigger('click');
  });

  // Scroll header function
  $(function() {
    $(document).on('scroll', function() {
      const $transparentHeader = $('.bipolar-header-desktop');
      const $grandHeader = $('.bipolar-grand-header');
      const $bipolarNavigation = $grandHeader.children('.bipolar-navigation');
      const $container = $bipolarNavigation.children('.container');
      const $logoInHeader = $container.find('.bipolar-logo');
      const isLongScroll = $(this).scrollTop() > $grandHeader.height();
      const homeIsLongScroll = $(this).scrollTop() > $transparentHeader.height();
      if (isLongScroll === true || homeIsLongScroll === true) {
        $transparentHeader.addClass('d-none');
        $grandHeader.addClass('bipolar-grand-header-hidden');
        $logoInHeader.removeClass('d-none');
        $container.removeClass('resized-container');
        $bipolarNavigation.addClass('has-shadow').addClass('has-background');
      } else {
        $transparentHeader.removeClass('d-none');
        $grandHeader.removeClass('bipolar-grand-header-hidden');
        $logoInHeader.addClass('d-none');
        $container.addClass('resized-container');
        $bipolarNavigation.removeClass('has-shadow').removeClass('has-background');
      }
    });
  });

  $('.bipolar-item').hover(
    function() {
      $(this)
        .children('a')
        .children('.the-line')
        .addClass('is-active');
    },
    function() {
      $(this)
        .children('a')
        .children('.the-line')
        .removeClass('is-active');
    }
  );

  // ==============================================================
  //tooltip
  // ==============================================================
  $(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });
  // ==============================================================
  //Popover
  // ==============================================================
  $(function() {
    $('[data-toggle="popover"]').popover();
  });

  if ($('.bipolar-counts-title').length) {
    const $firstCounter = $('#bipolar-first-counter');
    const $secondCounter = $('#bipolar-second-counter');
    const $instagramCounter = $('#bipolar-instagram-counter');
    const counterOptions = {
      useEasing: true,
      useGrouping: true,
      separator: '',
      decimal: '.',
      duration: 2.5,
    };

    const firstCounter = new CountUp('bipolar-first-counter', $firstCounter.data('number'), {
      ...counterOptions,
    });
    const instagramCounter = new CountUp(
      'bipolar-instagram-counter',
      $instagramCounter.data('number'),
      { ...counterOptions }
    );
    const secondCounter = new CountUp('bipolar-second-counter', $secondCounter.data('number'), {
      ...counterOptions,
    });

    firstCounter.start();
    secondCounter.start();
    instagramCounter.start();
  }

  // Convert SVG to InlineSVG
  document.querySelectorAll('img.svg').forEach(function(img) {
    var imgID = img.id;
    var imgClass = img.className;
    var imgURL = img.src;

    fetch(imgURL)
      .then(function(response) {
        return response.text();
      })
      .then(function(text) {
        var parser = new DOMParser();
        var xmlDoc = parser.parseFromString(text, 'text/xml');

        // Get the SVG tag, ignore the rest
        var svg = xmlDoc.getElementsByTagName('svg')[0];

        // Add replaced image's ID to the new SVG
        if (typeof imgID !== 'undefined') {
          svg.setAttribute('id', imgID);
        }
        // Add replaced image's classes to the new SVG
        if (typeof imgClass !== 'undefined') {
          svg.setAttribute('class', imgClass + ' replaced-svg');
        }

        // Remove any invalid XML tags as per http://validator.w3.org
        svg.removeAttribute('xmlns:a');

        // Check if the viewport is set, if the viewport is not set the SVG wont't scale.
        if (
          !svg.getAttribute('viewBox') &&
          svg.getAttribute('height') &&
          svg.getAttribute('width')
        ) {
          svg.setAttribute(
            'viewBox',
            '0 0 ' + svg.getAttribute('height') + ' ' + svg.getAttribute('width')
          );
        }

        // Replace image with new SVG
        img.parentNode.replaceChild(svg, img);
      });
  });
});
