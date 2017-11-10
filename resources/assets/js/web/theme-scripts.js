import Viewer from 'viewerjs/dist/viewer.esm';
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

    function draggedOwlMain (event) {
        owlMain.trigger('to.owl.carousel', [event.item.index, duration, true]);
    }

    owlThumbnail.on('click', '.owl-item', function() {
        let index = $(this).index();
        owlMain.trigger('to.owl.carousel', [index, duration, true]);
        owlThumbnail.trigger('to.owl.carousel', [index, duration, true]);
    });

    // Scroll header function
    $(function () {
        $(document).scroll(function () {
            let $transparentHeader = $('.bipolar-header-desktop');
            let $grandHeader = $(".bipolar-grand-header");
            let $grandHeaderAlternate = $('.bipolar-alternate-grand-header');
            let isLongScroll = $(this).scrollTop() > $grandHeader.height();
            let homeIsLongScroll = $(this).scrollTop() > $transparentHeader.height();
            if (isLongScroll === true || homeIsLongScroll === true) {
                $transparentHeader.addClass('hidden');
                $grandHeader.addClass('hidden');
                $grandHeaderAlternate.removeClass('hidden');
            } else {
                $transparentHeader.removeClass('hidden');
                $grandHeader.removeClass('hidden');
                $grandHeaderAlternate.addClass('hidden');
            }
        });
    });

    // Viewer function
    if (document.querySelector('#viewer-images')) {
        const viewerImages = document.querySelector('#viewer-images');
        const viewer = new Viewer(viewerImages, {
            rotatable: false,
            movable: false,
            interval: 9999999,
            title: false,
            minZoomRatio: 1,
        });
    }

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
        const firstCounter = new CountUp('bipolar-first-counter', 0, $firstCounter.data('number'), 0, 2.5, counterOptions);
        const secondCounter = new CountUp('bipolar-second-counter', 0, $secondCounter.data('number'), 0, 2.5, counterOptions);
        
        firstCounter.start();
        secondCounter.start();
    }
});
