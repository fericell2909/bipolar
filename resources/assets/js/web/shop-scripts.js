const PhotoSwipe = require('photoswipe/dist/photoswipe.min');
const PhotoSwipeUI = require('photoswipe/dist/photoswipe-ui-default.min');

$(function () {
    if ($('#see-photoswipe').length) {
        $('#see-photoswipe').click(() => {
            var pswpElement = document.querySelectorAll('.pswp')[0];

            // build items array
            var items = [
                {
                    src: 'https://placekitten.com/600/400',
                    w: 600,
                    h: 400
                },
                {
                    src: 'https://placekitten.com/1200/900',
                    w: 1200,
                    h: 900
                }
            ];

            // define options (if needed)
            var options = {
                // optionName: 'option value'
                // for example:
                index: 0 // start at first slide
            };

            // Initializes and opens PhotoSwipe
            var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI, items, options);
            gallery.init();
        });
    }

    if ($('.bipolar-filters').length) {
        $('.bipolar-filters').show('slow');
    }

    if ($('.btn-see-filters').length) {
        $('.btn-see-filters').click(() => {
            $('.filters-container').toggle();
        });
    }

    if ($('#shopForm').length) {
        $('.bipolar-filter.pretty').click(() => {
            setTimeout(function () {
                $('#shopForm').submit();
            }, 1000);
        })

        $('#shop-sort-by').change(function () {
            setTimeout(function () {
                $('#shopForm').submit();
            }, 1000);
        });
    }

    if ($('.button-see-details').length) {
        let $buttonSeeDetails = $('.button-see-details');
        
        $buttonSeeDetails.click(function () {
            let productHashId = $(this).data('hashId');
            $(`.modal-product-detail-${productHashId}`).modal({ show: true });
        });
    }
});